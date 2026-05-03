<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = ['user_id', 'cell_id', 'started_at', 'expires_at', 'status', 'pincode', 'finished_at'];

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
}
