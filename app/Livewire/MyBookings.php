<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyBookings extends Component
{
    public function release($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($booking->started_at->isFuture()) {
            session()->flash('error', 'Аренда еще не началась');
            return;
        }

        $now = Carbon::now('Europe/Moscow');
        $price = $booking->calculatePrice();
        $usedMinutes = $booking->started_at->diffInMinutes($now, false);

        $booking->update([
            'status'       => 'completed',
            'expires_at'   => $now,
            'finished_at'  => $now,
            'total_price'  => $price,
            'used_minutes' => $usedMinutes,
        ]);

        session()->flash('message', 'Ячейка освобождена. Стоимость: '.number_format($price, 0, '.', ' ').' ₽');
        $this->dispatch('contentChanged');
    }

    public function cancel($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($booking->started_at->isPast()) {
            session()->flash('error', 'Нельзя отменить — аренда уже началась');
            return;
        }

        $now = Carbon::now('Europe/Moscow');

        $booking->update([
            'status'      => 'cancelled',
            'total_price' => 0,
            'expires_at'  => $now,
            'finished_at' => $now,
            'updated_at'  => $now,
        ]);

        session()->flash('message', 'Бронь отменена');
        $this->dispatch('contentChanged');
    }

    public function render()
    {
        $now = now('Europe/Moscow');

        $bookings = Booking::with('cell')
            ->where('user_id', Auth::id())
            ->where(function($q) {
                $q->whereIn('status', ['pending', 'active'])
                    ->orWhere(function($sub) {
                        $sub->where('status', 'completed')
                            ->where('updated_at', '>=', now()->subHours(24));
                    })
                    ->orWhere(function($sub) {
                        $sub->where('status', 'cancelled')
                            ->where('updated_at', '>=', now()->subHours(24));
                    });
            })
            ->latest()
            ->get();

        $bookings = $bookings->filter(function($booking) use ($now) {
            if ($booking->status === 'active' && $booking->expires_at->isPast()) return false;
            if ($booking->status === 'pending' && $booking->started_at->isPast()) return false;
            return true;
        })->map(function($booking) use ($now) {

            if ($booking->status === 'completed') {
                $booking->display_state = 'completed';
            } elseif ($booking->status === 'cancelled') {
                $booking->display_state = 'cancelled';
            }
            elseif ($booking->started_at->isFuture()) {
                $booking->display_state = 'pending';
            }
            elseif ($booking->started_at->isPast() && $booking->expires_at->isFuture()) {
                $booking->display_state = 'active';
            }
            else {
                $booking->display_state = $booking->status;
            }

            return $booking;
        });

        $stats = [
            'active_count' => $bookings->where('display_state', 'active')->count(),
            'pending_count' => $bookings->where('display_state', 'pending')->count(),
            'total_spent' => $bookings->where('status', 'completed')->sum('total_price'),
        ];

        return view('livewire.my-bookings', [
            'bookings' => $bookings,
            'stats' => $stats,
        ]);
    }
}
