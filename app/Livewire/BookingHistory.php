<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookingHistory extends Component
{
    public function render()
    {
        return view('livewire.booking-history', [
            'history' => Booking::with('cell')
                ->where('user_id', auth()->id())
//                ->where('status', 'completed')
                ->latest('finished_at')
                ->get()
        ]);
    }
}
