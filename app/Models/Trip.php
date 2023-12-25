<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SeatAllocation;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = ['origin_id','destination_id','date'];

    public function originCity()
    {
        return $this->belongsTo(Location::class,'origin_id');
    }
    
    public function destinationCity()
    {
        return $this->belongsTo(Location::class,'destination_id');
    }

    public function scopeByDate($query,$date)
    {
        return $query->where('date',$date)
        ->with(['originCity','destinationCity']);
    }

    public static function getTripsDataByDate($date)
    {
        $trips = self::byDate($date)->get();

        return $trips->map(function ($trip) {
            return [
                'trip_id' => $trip->id,
                'origin' => $trip->originCity->name,
                'destination' => $trip->destinationCity->name,
            ];
        });
    }

    public function seats()
    {
        return $this->hasMany(SeatAllocation::class);
    }

    public function notAvailableSeats()
    {
        $allBookedSeats= $this->seats()->notAvailableSeats();
        return $allBookedSeats->pluck('seat_number')->toArray();
    }

}
