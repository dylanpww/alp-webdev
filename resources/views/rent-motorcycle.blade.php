@extends('layout.main-layout')
@section('title', 'Motorcycle Rental')

@section('konten')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_red.css">

    <div class="container py-4">

        <div id="searchSection" class="mb-5 p-4 border rounded shadow-sm bg-light">
            <h3 class="mb-3 fw-bold">Search Available Motorcycle</h3>

            <form action="{{ route('rents.search') }}" method="GET">
                <label for="dateRange" class="form-label fw-semibold">Choose Rental Dates:</label>
                <input id="dateRange" name="dates" class="form-control mb-3" placeholder="Select rental dates">
                <button class="btn btn-primary fw-bold px-4 mt-2"
                    style="background-color: #BA8B4E; border-color: #BA8B4E;">Search</button>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#dateRange", {
                mode: "range",
                minDate: "today",
                dateFormat: "Y-m-d",
                showMonths: 2,
            });
        </script>

        @foreach ($rents as $rent)
            <div class="row mb-5">
                <div class="col-md-6">
                    @if ($rent->url)
                        <img src="{{ asset('storage/' . $rent->url) }}" alt="{{ $rent->name }}" class="img-thumbnail"
                            style="width: 100%; height: 350px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white p-5 text-center rounded d-flex align-items-center justify-content-center"
                            style="height: 350px;">
                            No Image Available
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <h2 class="fw-bold">{{ $rent->name }}</h2>
                    <div class="mb-3">
                        <strong>Price per day:</strong>
                        <p class="fs-5 fw-bold">Rp {{ number_format($rent->price_per_day, 0, ',', '.') }}</p>
                    </div>

                    <a href="#searchSection" class="btn btn-success px-4 py-2 fw-bold mt-3"
                        style="background-color: #BA8B4E; border-color: #BA8B4E;">
                        Reserve Now
                    </a>

                    <a href="{{ route('rents.show', $rent->id) }}" class="btn btn-outline-secondary px-4 py-2 fw-bold mt-3"
                        style="background-color: #BA8B4E; border-color: #BA8B4E; color:white">
                        View Details
                    </a>
                </div>
            </div>
            <hr class="my-5">
        @endforeach

    </div>
@endsection
