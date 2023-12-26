<?php

namespace App\View\Components\dashboards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Auth;
class passenger extends Component
{
    /**
     * Create a new component instance.
     */
    public $allSeatsData;

    public function __construct()
    {
        $this->allSeatsData = $this->bookedSeatDetails(Auth::user()->allBookedSeats()->get());
        
        
    }

    protected function bookedSeatDetails($allBookedSeats)
    {
        $allData=[];
        foreach($allBookedSeats as $seat){
            if(!array_key_exists($seat->trip_id,$allData)){
                $allData[$seat->trip_id]=[
                    'origin_city'=>$seat->trip->originCity->name,
                    'destination_city'=>$seat->trip->destinationCity->name,
                    'date'=>$seat->trip->date,
                    'seats'=>[$seat->seat_number]
                ];
            }
            else{
                $allData[$seat->trip_id]['seats'][]=$seat->seat_number;
            }
        }
        return $allData;
    }

    public function render()
    {
        return view('components.dashboards.passenger');
    }
}
