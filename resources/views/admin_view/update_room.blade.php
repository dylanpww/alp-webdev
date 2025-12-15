@extends('layout.main-layout')
@section('title', 'Edit Room')

@section('konten')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="m-0">Edit Room: {{ $room->room_number }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="fw-bold">Room Number</label>
                                <input type="text" name="room_number" class="form-control"
                                    value="{{ old('room_number', $room->room_number) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Room Type</label>
                                <select name="type_id" class="form-select" required>
                                    <option value="" disabled>Select Type...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}" {{ $room->type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Status</label>
                                <select name="is_booked" class="form-select" required>
                                    <option value="0" {{ $room->is_booked == 0 ? 'selected' : '' }}>
                                        Available (Open for Booking)
                                    </option>
                                    <option value="1" {{ $room->is_booked == 1 ? 'selected' : '' }}>
                                        Maintenance (Close Room)
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
                                <button class="btn btn-primary">Update Room</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection