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
            ->where('status', 'active') // Добавляем проверку статуса для безопасности
            ->firstOrFail();

        $now = Carbon::now('Europe/Moscow');

        $booking->update([
            'status'      => 'completed',
            'expires_at'  => $now,
            'finished_at' => $now,
        ]);

        $this->dispatch('contentChanged');
        session()->flash('message', 'Ячейка успешно освобождена!');
    }

    public function render()
    {
        return view('livewire.my-bookings', [
            'bookings' => Booking::with('cell')
                ->where('user_id', Auth::id())
                ->where('status', 'active')
                ->latest() // Свежие бронирования сверху
                ->get()
        ]);
    }
}
