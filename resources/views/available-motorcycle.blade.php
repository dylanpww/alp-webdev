@extends('layout.main-layout')
@section('title', 'Available Motorcycles')

@section('konten')
    <div class="container mt-4">

        <h2>Available Motorcycles</h2>
        <p>From <strong>{{ $start }}</strong> to <strong>{{ $end }}</strong></p>

        <div class="row mt-4">

            @forelse ($rents as $rent)
                <div class="col-md-4">
                    <div class="card mb-4 shadow h-100">

                        @if ($rent->url)
                            <img src="{{ asset('storage/' . $rent->url) }}" class="card-img-top"
                                style="height:200px; object-fit:cover;">
                        @else
                            <div class="bg-secondary text-white card-img-top d-flex align-items-center justify-content-center"
                                style="height: 200px;">No Image</div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h4>{{ $rent->name }}</h4>
                            <p><strong>Rp {{ number_format($rent->price_per_day, 0, ',', '.') }}</strong> / day</p>

                            <div class="mt-auto">
                                <form action="{{ route('reservations.createRental') }}" method="GET">
                                    <input type="hidden" name="rental_id" value="{{ $rent->id }}">
                                    <input type="hidden" name="start_date" value="{{ $start }}">
                                    <input type="hidden" name="end_date" value="{{ $end }}">

                                    <button class="btn btn-primary w-100"
                                        style="background-color: #BA8B4E; border-color: #BA8B4E;">
                                        Choose This Motor
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        No motorcycles available for these dates.
                    </div>
                    <div class="text-center">
                        <a href="{{ route('rents.rent') }}" class="btn btn-secondary">Back to Search</a>
                    </div>
                </div>
            @endforelse

        </div>

    </div>
@endsection
