<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeatAllocationRequest;
use App\Http\Requests\UpdateSeatAllocationRequest;
use App\Models\SeatAllocation;
use App\Models\User;
use Auth;


class SeatAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('seats_allocation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers=User::where('role','customer')->get();
        $seats = array();
        return view('seats_allocation.create',compact('customers','seats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeatAllocationRequest $request)
    {
        
        $request->validated();
        $passengers = isset($request->passenger) ? $request->passenger : Auth::user()->id;
        $seatsArray=explode(',',$request->selected_seats);
        foreach ($seatsArray as $seat) {
            SeatAllocation::create([
                'trip_id' => $request->trip_id,
                'seat_number' => $seat,
                'user_id' => $passengers,
                
            ]);
        }
        return redirect()->route('seat-allocation.index')->with('success','Seat allocated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SeatAllocation $seatAllocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeatAllocation $seatAllocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeatAllocationRequest $request, SeatAllocation $seatAllocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeatAllocation $seatAllocation)
    {
        //
    }
}
