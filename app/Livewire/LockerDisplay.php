<?php

namespace App\Livewire;

use App\Models\Cell;
use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LockerDisplay extends Component
{
    public $step = 1; // Теперь 1 шаг — это время
    public $selectedType = null;
    public $startTime;
    public $endTime;

    public function mount()
    {
        // Устанавливаем дефолт: через 10 мин на 1 час
        $this->startTime = now('Europe/Moscow')->addMinutes(10)->format('Y-m-d H:i');
        $this->endTime = now('Europe/Moscow')->addMinutes(70)->format('Y-m-d H:i');
    }

    public function goToSize()
    {
        $this->validate([
            'startTime' => 'required|after_or_equal:' . now('Europe/Moscow')->addMinutes(9)->format('Y-m-d H:i'),
            'endTime' => 'required|after:startTime',
        ]);

        $this->step = 2; // Переходим к выбору размера
    }

    public function selectType($type)
    {
        // Проверяем еще раз перед выбором, на случай если кто-то успел занять
        if (!$this->isTypeAvailable($type, $this->startTime, $this->endTime)) {
            session()->flash('error', 'К сожалению, эта ячейка уже занята на выбранное время.');
            return;
        }

        $this->selectedType = $type;
        $this->step = 3; // Переходим к финалу
    }

    public function isTypeAvailable($type, $start, $end)
    {
        $totalCells = Cell::where('type', $type)->count();

        $occupiedCount = Booking::whereHas('cell', function($q) use ($type) {
            $q->where('type', $type);
        })
            ->where('status', '!=', 'completed')
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('started_at', '<', $end)
                        ->where('expires_at', '>', $start);
                });
            })
            ->count();

        return $totalCells > $occupiedCount;
    }

    public function confirmBooking()
    {
        // Ищем ячейку, у которой НЕТ пересекающихся броней на это время
        $cell = Cell::where('type', $this->selectedType)
            ->whereDoesntHave('bookings', function($q) {
                $q->where('status', '!=', 'completed')
                    ->where('started_at', '<', $this->endTime)
                    ->where('expires_at', '>', $this->startTime);
            })
            ->first();

        if (!$cell) {
            session()->flash('error', 'Свободных ячеек не осталось.');
            return;
        }

        Booking::create([
            'user_id' => Auth::id(),
            'cell_id' => $cell->id,
            'started_at' => Carbon::parse($this->startTime),
            'expires_at' => Carbon::parse($this->endTime),
            'status' => 'active',
            'pincode' => rand(1000, 9999),
        ]);

        return redirect()->route('dashboard', ['view' => 'my-cells']);
    }

    public function render() {
        return view('livewire.locker-display');
    }
}
