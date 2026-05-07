<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = ['user_id', 'cell_id', 'started_at', 'expires_at', 'status', 'pincode', 'finished_at', 'total_price', 'used_minutes'];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'finished_at' => 'datetime'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function cell() { return $this->belongsTo(Cell::class); }

    public function calculateTotalCost()
    {
        if (!$this->finished_at) {
            return $this->cell->cost;
        }

        $hours = $this->started_at->diffInHours($this->finished_at);
        $hours = $hours < 1 ? 1 : ceil($hours);

        return $hours * $this->cell->cost;
    }
    public function calculatePrice(): int
    {
        if ($this->status === 'cancelled' || $this->status === 'pending') {
            return 0;
        }

        $start = $this->started_at ?? now();
        $end = $this->finished_at ?? now();

        $minutes = max(60, $start->diffInMinutes($end, false));
        $hours = ceil($minutes / 60);

        return $this->cell->cost * $hours;
    }

    public function getDisplayStatusAttribute(): array
    {
        $now = now('Europe/Moscow');

        return match($this->status) {
            'pending' => $this->started_at?->isFuture()
                ? ['label' => 'Ожидает', 'color' => 'amber', 'icon' => 'clock']
                : ['label' => 'Активна', 'color' => 'emerald', 'icon' => 'key'],
            'active' => ['label' => 'Активна', 'color' => 'emerald', 'icon' => 'key'],
            'completed' => ['label' => 'Завершена', 'color' => 'slate', 'icon' => 'check'],
            'cancelled' => ['label' => 'Отменена', 'color' => 'rose', 'icon' => 'x'],
            default => ['label' => 'Неизвестно', 'color' => 'slate', 'icon' => 'help-circle'],
        };
    }
}
