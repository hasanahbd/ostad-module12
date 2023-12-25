<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatAllocation extends Model
{
    use HasFactory;
    protected $fillable = ['trip_id','seat_number','user_id','is_booked'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    public function scopeNotAvailableSeats($query)
    {
        return $query->where('is_booked', 'booked');
    }

}
