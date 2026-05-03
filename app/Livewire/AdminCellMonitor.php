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

        $cells = Cell::with(['bookings' => function($query) use ($viewDateObj, $endOfDay) {
            $query->where('started_at', '<=', $endOfDay)
                ->where('expires_at', '>=', $viewDateObj)
                ->with('user'); // ← Явно загружаем пользователя
        }])->get();

        return view('livewire.admin-cell-monitor', [
            'cells' => $cells,
            'currentDayStart' => $viewDateObj
        ]);
    }
}
