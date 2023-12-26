@extends('layouts.app')
@section('title', 'Assign Seats')
@section('styles')
    <style>
        .seat {
            width: 60px;
            height: 60px;
            margin: 3px;
            border: 1px solid #ddd;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
        }

        .booked {
            background-color: red;
            color: white;
        }

        .available {
            background-color: #28a745;
            /* Bootstrap success color */
            color: white;
        }

        .selected {
            background-color: #0751ff;
            /* Bootstrap warning color */
            color: white;
        }

        .bus-row {
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <h2 class="text-center">Bus Seat Allocation</h2>

    <div class="bus-layout">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @php
            $totalSeats = 36;
            $seatsPerRow = 4;
            $seatCounter = 1;
        @endphp
        <form action="{{ route('seat-allocation.store') }}" method="POST" id="sealtAllocationForm">
            @csrf

            <div class="row">
                <div class="col-md-6 ms-5">
                    @if (Auth::user() && Auth::user()->role == 'admin')
                        <div class="mb-3 col-6">
                            <label for="passenger" class="form-label">Passenger</label>
                            <select class="form-select" id="passenger" name="passenger" required>
                                <option value="">Select Passenger</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="mb-3 col-6">
                        <label for="tripDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="tripDate" name="tripDate" required
                            min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="tripId" class="form-label">Trips</label>
                        <select class="form-select" id="tripId" name="trip_id" required>
                        </select>
                    </div>
                </div>
    
                <div class="col-md 6">
                    @while ($seatCounter <= $totalSeats)
                        <div class="bus-row mb-2 d-none">
                            @for ($i = 0; $i < $seatsPerRow && $seatCounter <= $totalSeats; $i++)
                                @php
                                    $isBooked = true;
                                    // $isBooked = $seats->contains('seat_number', $seatCounter);
                                @endphp
    
                                <div id="{{ $seatCounter }}" data-id={{ $seatCounter }} class="seat available selectSeat">
                                    {{ $seatCounter++ }}
                                </div>
                            @endfor
                        </div>
                    @endwhile
                    <input type="hidden" name="selected_seats" id="selectedSeats">
                    <div id="submitButtonClass" class="text-center d-none">
                        <button class="btn btn-info" id="submitForm" type="submit">
                            @if (Auth::user() && Auth::user()->role == 'admin')
                                Assign Seats
                            @else
                                Book Seat
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="module">
        var selectedSeats = [];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            }
        });
        $(document).on('click', "#submitForm", function(e) {
            e.preventDefault();
            if (selectedSeats.length == 0) {
                alert('Please select at least one seat');
                return;
            }
            $("#selectedSeats").val(selectedSeats);
            $("#sealtAllocationForm").submit();
        })
        $(document).on('change', "#tripDate", function() {
            var tripDate = $(this).val();
            $.ajax({
                url: "{{ route('trips-by-date') }}",
                type: "POST",
                data: {
                    tripDate: tripDate,
                },
                success: function(response) {
                    let trips = JSON.parse(response);
                    let options = '<option value="">Select A Trip</option>';
                    trips.forEach(trip => {
                        options +=
                            `<option value="${trip.trip_id}">${trip.origin} To ${trip.destination}</option>`;
                    });
                    $("#tripId").html(options);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        })
        $(document).on('change', "#tripId", function() {
            var tripId = $(this).val();
            $.ajax({
                url: "{{ route('get-booked-seats') }}",
                type: "POST",
                data: {
                    trip: tripId,
                },
                success: function(response) {
                    $(".bus-row").removeClass('d-none');
                    $(".seat").removeClass('booked').removeClass('selected').addClass('available')
                        .addClass('selectSeat');
                    selectedSeats = [];
                    let allBookedSeats = JSON.parse(response);
                    allBookedSeats.forEach(seat => {
                        $(`#${seat}`).removeClass('available').removeClass('selectSeat')
                            .addClass('booked');
                    });

                },
                error: function(response) {
                    console.log(response);
                }
            });
        })

        $(document).on('click', ".selectSeat", function() {
            if ($(this).hasClass('booked')) {
                alert('This seat is already booked');
                return;
            } else {
                let seatNumber = $(this).data('id');
                if (selectedSeats.includes(seatNumber)) {
                    selectedSeats = selectedSeats.filter(seat => seat != seatNumber);
                    $(this).removeClass('selected').addClass('available');
                } else {
                    selectedSeats.push(seatNumber);
                    $(this).addClass('selected').removeClass('available');
                }
            }
            if (selectedSeats.length > 0) {
                $("#submitButtonClass").removeClass('d-none');
            } else {
                $("#submitButtonClass").addClass('d-none');
            }
        })
    </script>
@endsection
