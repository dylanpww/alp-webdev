@extends('layout.main-layout')
@section('title', "Room Types")

@section('konten')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_red.css">

    <div class="container py-4">

        <div id="searchSection" class="mb-5 p-4 border rounded shadow-sm bg-light">

            <h3 class="mb-3 fw-bold">Search Available Rooms</h3>
            <form action="{{ route('rooms.search') }}" method="GET">
                <label for="dateRange" class="form-label fw-semibold">Choose Stay Dates:</label>
                <input id="dateRange" name="dates" class="form-control mb-3" placeholder="Select check-in and check-out">
                <button class="btn btn-primary fw-bold px-4 mt-2"style="background-color: #BA8B4E; border-color: #BA8B4E;">
                    Search
                </button>
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

        @foreach($types as $type)
            <div class="row mb-5">
                <div class="col-md-6">
                    @if($type->images->count())
                        <img id="mainImage-{{ $type->id }}" src="{{ asset('storage/' . $type->images->first()->url) }}"
                            class="img-fluid rounded shadow-sm mb-3" style="width: 100%; height: 350px; object-fit: cover;">
                    @endif
                    <div class="d-flex gap-2 overflow-auto pb-2">
                        @foreach($type->images as $img)
                            <img onclick="document.getElementById('mainImage-{{ $type->id }}').src='{{ asset('storage/' . $img->url) }}'"
                                src="{{ asset('storage/' . $img->url) }}" class="rounded border"
                                style="width: 120px; height: 90px; object-fit: cover; cursor: pointer;">
                        @endforeach

                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold">{{ $type->name }}</h2>
                    <div class="mb-3">Deskripsi :</div>
                    <div id="desc" class="tab-pane fade show active">
                        <p>{{ $type->description }}</p>
                        <p><strong>Rp {{ number_format($type['price_per_night'], 0, ',', '.') }}</strong> / night</p>
                    </div>
                    <a href="#searchSection" class="btn btn-success px-4 py-2 fw-bold mt-3" style="background-color: #BA8B4E; border-color: #BA8B4E;">Reserve now</a>
                    <a href="{{ route('types.show', $type->id) }}" class="btn btn-primary px-4 py-2 fw-bold mt-3" style="background-color: #BA8B4E; border-color: #BA8B4E;">View Details</a>
                </div>
            </div>
            <hr class="my-5">
        @endforeach
    </div>
@endsection