@extends('layout.main-layout')
@section('title', "Motorcycle Rental")

@section('konten')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_red.css">

    <div class="container py-4">

        
        
        <div id="searchSection" class="mb-5 p-4 border rounded shadow-sm bg-light">
            <h3 class="mb-3 fw-bold">Search Motorcycle Availability</h3>

            <form action="{{ route('rents.search') }}" method="GET">
                <label for="dateRange" class="form-label fw-semibold">Choose Rental Dates:</label>
                <input id="dateRange" name="dates" class="form-control mb-3" placeholder="Select rental dates">
                <button class="btn btn-primary fw-bold px-4 mt-2" style="background-color: #BA8B4E; border-color: #BA8B4E;">Search</button>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#dateRange", {
                mode: "range",
                minDate: "today",
                dateFormat: "d-m-Y",
                showMonths: 2,
            });
        </script>

        
        @foreach ($rents as $rent)
            <div class="row mb-5">
                <div class="col-md-6">

                    
                    @if ($rent->url)
                        <img src="{{ asset('storage/' . $rent->url) }}" alt="Motorcycle Image" class="img-thumbnail"
                            style="width: 100%; height: 300px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white p-5 text-center rounded">
                            No Image Available
                        </div>
                    @endif

                </div>

                <div class="col-md-6">
                    <h2 class="fw-bold">{{ $rent->name }}</h2>

                    <div class="mt-3">
                        <strong>Price per day:</strong>
                        <p class="fs-5 fw-bold">Rp {{ number_format($rent->price_per_day, 0, ',', '.') }}</p>
                    </div>

                    <a href="#searchSection" class="btn btn-success px-4 py-2 fw-bold mt-3 "style="background-color: #BA8B4E; border-color: #BA8B4E;">
                        Reserve Now
                    </a>
                </div>
            </div>

            <hr class="my-5">
        @endforeach
        

    </div>
@endsection