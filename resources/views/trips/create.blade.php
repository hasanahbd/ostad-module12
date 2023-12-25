@extends('layouts.app')
@section('title', 'Create Trip')
@section('content')
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <h2>Create a New Trip</h2>
            <form action="{{ route('trips.store') }}" method="POST">
                @csrf 

                <div class="mb-3">
                    <label for="origin" class="form-label">Origin</label>
                    <select class="form-select" id="origin" name="origin_id" required>
                        <option value="">Select A Origin</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="destination" class="form-label">Destination</label>
                    <select class="form-select" id="destination" name="destination_id" required>
                        <option value="">Select A Origin</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control"  id="datepicker" name="date" required>
                </div>

                <button type="submit" class="btn btn-primary">Create Trip</button>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
@endsection
