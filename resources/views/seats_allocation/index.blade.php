@extends('layouts.app')
@section('title', 'Assign Seats')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    
@endsection