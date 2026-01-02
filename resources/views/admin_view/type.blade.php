@extends('layout.main-layout')
@section('title', 'Type ')

@section('konten')

    <div class="container py-5">
        <div class="card shadow mb-5 border-0">
            <div class="card-header text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                <h5 class="mb-0 fw-bold">Room Type List</h5>
            </div>

            <div class="card-body">
                <div class="mb-3 text-end">
                    <a href="{{ route('types.create') }}" class="btn" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                        + Add New Type
                    </a>
                </div>

                @if ($types->isEmpty())
                    <p class="text-muted text-center py-3">No room types available.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Price / Night</th>
                                    <th>Description</th>
                                    <th width="180">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                    <tr>
                                        <td><strong>{{ $loop->iteration }}</strong></td>

                                        <td class="fw-bold">{{ $type->name }}</td>

                                        <td>Rp {{ number_format($type->price_per_night, 0, ',', '.') }}</td>

                                        <td>{{ Str::limit($type->description, 60) }}</td>

                                        <td>
                                            <a href="{{ route('types.edit', $type->id) }}" class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('types.destroy', $type->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete this type?')"
                                                    class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
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
