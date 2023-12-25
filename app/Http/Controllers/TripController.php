<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Models\Trip;
use App\Models\Location;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['admin'])->except(['tripsByDate','bookedSeats']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::all();
        return view('trips.index',compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        return view('trips.create',compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTripRequest $request)
    {
        $request->validated();
        $trip = Trip::create([
            'origin_id' => $request->origin_id,
            'destination_id' => $request->destination_id,
            'date' => $request->date,
        ]);
        return redirect()->route('trips.index',$trip)->with('success','Trip created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }

    public function tripsByDate(Request $request)
    {
        $date=$request->tripDate;
        $returnData = Trip::getTripsDataByDate($date);
        return json_encode($returnData);

    }

    public function bookedSeats(Request $request)
    {
        
        $tripId = $request->trip;
        $trip = Trip::find($tripId);
        if(!$trip)
        {
            return response()->json(['message'=>'Trip not found'],404);
        }
        $bookedSeats = $trip->notAvailableSeats();
        return  json_encode($bookedSeats);
    }
}
