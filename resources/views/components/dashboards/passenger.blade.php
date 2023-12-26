@extends('layouts.app')
@section('title', 'Passenger Dashboard')
@section('content')
<div class="container">
    <h1>Booked Trips</h1>

    @foreach($allSeatsData as $tripData)
        <div class="card my-3">
            <div class="card-body">
                <h5 class="card-title">{{ $tripData['origin_city'] }} to {{ $tripData['destination_city'] }}</h5>
                <p class="card-text">Date: {{ $tripData['date'] }}</p>
                <p>Booked Seats:</p>
                <ul class="list-group list-group-flush">
                    @foreach($tripData['seats'] as $seat)
                        <li class="list-group-item">Seat Number: {{ $seat }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection
