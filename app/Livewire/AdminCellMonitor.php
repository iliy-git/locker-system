<?php

namespace App\Livewire;

use App\Models\Cell;
use Livewire\Component;
use Carbon\Carbon;

class AdminCellMonitor extends Component
{
    public $viewDate;

    public function mount()
    {
        $this->setToday();
    }

    public function nextDay()
    {
        $this->viewDate = Carbon::parse($this->viewDate)->addDay()->format('Y-m-d');
    }

    public function prevDay()
    {
        $this->viewDate = Carbon::parse($this->viewDate)->subDay()->format('Y-m-d');
    }

    public function setToday()
    {
        $this->viewDate = now('Europe/Moscow')->format('Y-m-d');
    }

    public function render()
    {
        $viewDateObj = Carbon::parse($this->viewDate, 'Europe/Moscow')->startOfDay();
        $endOfDay = $viewDateObj->copy()->endOfDay();
        $now = now('Europe/Moscow');

        $cells = Cell::with(['bookings' => function($query) use ($viewDateObj, $endOfDay) {
            $query->where('started_at', '<=', $endOfDay)
                ->where('expires_at', '>=', $viewDateObj)
                ->where('status', '!=', 'cancelled')
                ->with('user');
        }])->get();

        $cells->each(function($cell) use ($now) {
            $cell->bookings->each(function($booking) use ($now) {
                $start = $booking->started_at->timezone('Europe/Moscow');
                $end = $booking->expires_at->timezone('Europe/Moscow');

                if ($booking->status === 'completed') {
                    $booking->display_status = 'completed';
                } elseif ($end->isPast()) {
                    $booking->display_status = 'completed';
                    $booking->is_auto_completed = true;
                } elseif ($start->isFuture()) {
                    $booking->display_status = 'pending';
                } else {
                    $booking->display_status = 'active';
                }
            });
        });

        return view('livewire.admin-cell-monitor', [
            'cells' => $cells,
            'currentDayStart' => $viewDateObj
        ]);
    }
}
