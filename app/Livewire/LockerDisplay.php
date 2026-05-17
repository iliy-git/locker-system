<?php

namespace App\Livewire;

use App\Models\Cell;
use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LockerDisplay extends Component
{
    public $step = 1;
    public $selectedType = null;
    public $startTime;
    public $endTime;

    public function mount()
    {
        $this->setDefaultTimes();
    }

    private function setDefaultTimes()
    {
        // Дефолт: прямо сейчас и через час
        $this->startTime = now('Europe/Moscow')->format('Y-m-d H:i');
        $this->endTime = now('Europe/Moscow')->addHour()->format('Y-m-d H:i');
    }

    public function rules()
    {
        return [
            'startTime' => 'required|date_format:Y-m-d H:i',
            'endTime' => 'required|date_format:Y-m-d H:i|after:startTime',
        ];
    }

    public function messages()
    {
        return [
            'endTime.after' => 'Время выезда должно быть позже времени заезда',
        ];
    }

    public function goToSize()
    {
        $this->validate();
        $this->step = 2;
    }

    public function selectType($type)
    {
        if (!$this->isTypeAvailable($type, $this->startTime, $this->endTime)) {
            session()->flash('error', 'Ячейка уже занята на это время');
            return;
        }

        $this->selectedType = $type;
        $this->step = 3;
    }

    public function confirmBooking()
    {
        $this->validate();

        $cell = Cell::where('type', $this->selectedType)
            ->whereDoesntHave('bookings', fn($q) => $q
                ->whereIn('status', ['active', 'pending']) // ← только активные брони блокируют
                ->where('started_at', '<', $this->endTime)
                ->where('expires_at', '>', $this->startTime)
            )
            ->first();

        if (!$cell) {
            session()->flash('error', 'Нет свободных ячеек на выбранный период');
            $this->step = 2;
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

    public function resetToStep1()
    {
        $this->setDefaultTimes();
        $this->selectedType = null;
        $this->step = 1;
    }

    public function isTypeAvailable($type, $start, $end)
    {
        $total = Cell::where('type', $type)->count();

        $occupied = Booking::whereHas('cell', fn($q) => $q->where('type', $type))
            ->whereIn('status', ['active', 'pending'])
            ->where(function ($q) use ($start, $end) {
                $q->where('started_at', '<', $end)->where('expires_at', '>', $start);
            })->count();

        return $total > $occupied;
    }
    public function getCellDimensions($type)
    {
        $cells = Cell::where('type', $type)
            ->where('status', 'active')
            ->select('width', 'height', 'depth')
            ->get();

        if ($cells->isEmpty()) {
            return [
                'display' => '—',
                'min' => ['w' => null, 'h' => null, 'd' => null],
                'max' => ['w' => null, 'h' => null, 'd' => null],
                'isUniform' => true,
            ];
        }

        // Находим мин/макс значения по каждому измерению
        $min = [
            'w' => $cells->min('width'),
            'h' => $cells->min('height'),
            'd' => $cells->min('depth'),
        ];
        $max = [
            'w' => $cells->max('width'),
            'h' => $cells->max('height'),
            'd' => $cells->max('depth'),
        ];

        $isUniform = $min['w'] === $max['w'] && $min['h'] === $max['h'] && $min['d'] === $max['d'];

        if ($isUniform) {
            $display = "{$min['w']} × {$min['h']} × {$min['d']} см";
        } else {
            $display = "от {$min['w']}×{$min['h']}×{$min['d']} до {$max['w']}×{$max['h']}×{$max['d']} см";
        }

        return [
            'display' => $display,
            'min' => $min,
            'max' => $max,
            'isUniform' => $isUniform,
            'volume_min' => $min['w'] * $min['h'] * $min['d'] / 1000,
            'volume_max' => $max['w'] * $max['h'] * $max['d'] / 1000,
        ];
    }

    public function render()
    {
        return view('livewire.locker-display');
    }
}
