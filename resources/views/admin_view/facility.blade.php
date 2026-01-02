@extends('layout.main-layout')
@section('title', 'Facility')

@section('konten')

    <div class="container py-5">
        <div class="card shadow mb-5 border-0">
            <div class="card-header text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                <h5 class="mb-0 fw-bold">Facility List</h5>
            </div>

            <div class="card-body">
                <div class="mb-3 text-end">
                    <a href="{{ route('facility.create') }}" class="btn text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                        + Add New Facility
                    </a>
                </div>

                @if ($facilities->isEmpty())
                    <p class="text-muted text-center py-3">No facilities available.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th width="180">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facilities as $facility)
                                    <tr>
                                        <td><strong>{{ $facility->id }}</strong></td>

                                        <td>
                                            @if ($facility->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $facility->images->first()->url) }}"
                                                    alt="Facility Image" class="rounded"
                                                    style="width: 90px; height: 60px; object-fit: cover;">
                                            @else
                                                <span class="text-muted fst-italic">No Image</span>
                                            @endif
                                        </td>

                                        <td class="fw-bold">{{ $facility->name }}</td>

                                        <td>{{ Str::limit($facility->description, 80) }}</td>

                                        <td>
                                            <a href="{{ route('facility.edit', $facility->id) }}"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('facility.destroy', $facility->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete this facility?')"
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
