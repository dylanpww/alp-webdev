@extends('layout.main-layout')
@section('title', "Available Rooms")

@section('konten')
    <div class="container mt-4">

        <h2>Available Room Types</h2>
        <p>From <strong>{{ $start }}</strong> to <strong>{{ $end }}</strong></p>

        <div class="row mt-4">

            @forelse ($types as $type)
                <div class="col-md-4">
                    <div class="card mb-4 shadow">

                        <img src="{{ asset('storage/' . $type['image']) }}" class="card-img-top"
                            style="height:200px;object-fit:cover;">

                        <div class="card-body">
                            <h4>{{ $type['type_name'] }}</h4>
                            <p><strong>Rp {{ number_format($type['price'], 0, ',', '.') }}</strong> / night</p>
                            <p>{{ $type['count'] }} rooms available</p>

                            <form action="{{ route('reservations.createRental') }}" method="GET">
                                <input type="hidden" name="type_id" value="{{ $type['id'] }}">
                                <input type="hidden" name="start_date" value="{{ $start }}">
                                <input type="hidden" name="end_date" value="{{ $end }}">

                                <button class="btn btn-primary w-100" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                                    Choose This Type
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @empty
                <p>No rooms available for these dates.</p>
            @endforelse

        </div>

    </div>
@endsection