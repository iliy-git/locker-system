<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cell extends Model
{
    protected $fillable = [
        'cell_number',
        'type',
        'width',
        'height',
        'depth',
        'status',
        'hardware_id',
        'cost',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable()
    {
        return !$this->bookings()->where('status', 'active')->exists()
            && $this->status === 'active';
    }
}
