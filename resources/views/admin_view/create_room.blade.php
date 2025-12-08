@extends('layout.main-layout')
@section('title', 'Create Room | Manager Dashboard')
@section('konten')
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Add New Room</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                
                <div class="mb-3">
                    <label class="form-label">Room Number</label>
                    <input type="text" name="room_number" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" required>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <select name="type_id" class="form-select" required>
                        <option value="">Select Type</option>

                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control"></textarea>
                </div>


                <button type="submit" class="btn btn-success">Add Room</button>
            </form>
        </div>
    </div>
</div>
@endsection
