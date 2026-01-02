@extends('layout.main-layout')
@section('title', 'Assign Room')

@section('konten')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Assign Room for Reservation #{{ $reservation->id }}</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Info Tamu --}}
                    <div class="alert alert-light border">
                        <strong>Guest:</strong> {{ $reservation->user->name }} <br>
                        <strong>Type:</strong> {{ $reservation->roomType->name ?? 'Unknown' }} <br>
                        <strong>Date:</strong> {{ $reservation->check_in_date }} to {{ $reservation->check_out_date }}
                        @if($reservation->extra_bed) 
                            <br> <span class="badge bg-warning text-dark">Requires Extra Bed</span>
                        @endif
                    </div>

                    <form action="{{ route('reservations.storeAssign', $reservation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">Select Available Room:</label>
                            
                            @if($availableRooms->isEmpty())
                                <div class="alert alert-danger">
                                    No rooms available for this type on these dates!
                                </div>
                            @else
                                <select name="room_id" class="form-select form-select-lg">
                                    <option value="" selected disabled>-- Choose a Room --</option>
                                    @foreach($availableRooms as $room)
                                        <option value="{{ $room->id }}">
                                            Room {{ $room->room_number }} 
                                            (Status: {{ $room->status }})
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancel</a>
                            @if(!$availableRooms->isEmpty())
                                <button type="submit" class="btn btn-success">Save Assignment</button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection