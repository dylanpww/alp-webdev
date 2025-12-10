@extends('layout.main-layout')
@section('title', 'Rooms')

@section('konten')
<div class="container py-5">
    <div class="card shadow mb-5 border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 fw-bold">Room List</h5>
        </div>

        <div class="card-body">
            <div class="mb-3 text-end">
                <a href="{{ route('rooms.create') }}" class="btn btn-success">
                    + Add New Room
                </a>
            </div>

            @if($rooms->isEmpty())
                <p class="text-muted text-center py-3">No rooms available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Room Number</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $room->room_number }}</td>
                                    
                                    {{-- Menampilkan Nama Tipe dari Relasi --}}
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $room->type ? $room->type->name : 'No Type' }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($room->status == 'Available')
                                            <span class="badge bg-success">Available</span>
                                        @elseif($room->status == 'Occupied')
                                            <span class="badge bg-danger">Occupied</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Maintenance</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        
                                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete room?')" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection