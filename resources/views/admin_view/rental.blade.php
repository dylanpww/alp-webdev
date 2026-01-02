@extends('layout.main-layout')
@section('title', 'Rental')

@section('konten')

    <div class="container py-5">
        <div class="card shadow mb-5 border-0">
            <div class="card-header text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                <h5 class="mb-0 fw-bold">Motorcycle List</h5>
            </div>

            <div class="card-body">
                <div class="mb-3 text-end">
                    <a href="{{ route('rents.create') }}" class="btn text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                        + Add New Motorcycle
                    </a>
                </div>

                @if ($rents->isEmpty())
                    <p class="text-muted text-center py-3">No motorcycles available.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Price / Day</th>
                                    <th width="180">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rents as $rent)
                                    <tr>
                                        <td><strong>{{ $rent->id }}</strong></td>

                                        <td>
                                            @if ($rent->url)
                                                <img src="{{ asset('storage/' . $rent->url) }}"
                                                    alt="Motor Image" class="rounded"
                                                    style="width: 90px; height: 60px; object-fit: cover;">
                                            @else
                                                <span class="text-muted fst-italic">No Image</span>
                                            @endif
                                        </td>

                                        <td class="fw-bold">{{ $rent->name }}</td>

                                        <td>Rp {{ number_format($rent->price_per_day, 0, ',', '.') }}</td>

                                        <td>
                                            <a href="{{ route('rents.edit', $rent->id) }}"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('rents.destroy', $rent->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete this motorcycle?')"
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