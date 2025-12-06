@extends('layout.main-layout')
@section('title', 'Room Status')

@section('konten')

<style>
    .floor {
        width: 400px;
        padding: 20px;
        border: 4px solid #333;
        border-radius: 12px;
        background: #f5f5f5;
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 columns */
        gap: 12px;
    }

    .room-box {
        height: 90px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        font-size: 20px;
        border: 3px solid #222;
        background: #d9ffd9; /* available = green */
    }

    .room-box.booked {
        background: #ffb3b3; /* booked = red */
    }
</style>

<div class="container py-4">
    <h2 class="fw-bold mb-3">Room Status</h2>

    <div class="floor">
        @foreach ($rooms as $room)
            <div class="room-box {{ $room->is_booked ? 'booked' : '' }}">
                {{ $room->room_number }}
            </div>
        @endforeach
    </div>
</div>

@endsection
