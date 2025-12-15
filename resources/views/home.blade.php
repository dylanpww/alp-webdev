@extends('layout.main-layout')
@section('title', 'Home Page')
@section('konten')

    <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            @foreach($images as $key => $image)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset($image) }}" class="d-block w-100" style="height: 450px; object-fit: cover;">
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="container my-5 text-center">
        <h1 class="display-4 fw-bold mb-3">Welcome to Sarang Comfort Stay, {{ $username ?? 'Guest' }}</h1>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="lead text-muted">
                    Nestled in the heart of Canggu, Sarang Comfort Stay offers a serene escape
                    just minutes away from the beach. Experience the perfect blend of relaxation
                    and convenience in a peaceful atmosphere designed to make your Bali getaway unforgettable.
                </p>
                <hr class="my-4 w-50 mx-auto">
                <p>
                    Located on Jl. Raya Semat, we are your quiet sanctuary close to the best cafes
                    and entertainment Canggu has to offer.
                </p>
                <a href="{{ route('types.book') }}" class="btn btn-primary btn-lg mt-3"
                    style="background-color: #BA8B4E; border-color: #BA8B4E; ">Book Your Stay</a>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center fw-bold mb-4">Our Facilities</h2>

        <div class="row g-4">
            @foreach($facilities as $facility)
                @php
                    $modalId = 'facilityModal-' . $facility->id;
                    $carouselId = 'facilityCarousel-' . $facility->id;
                @endphp

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0" role="button" data-bs-toggle="modal"
                        data-bs-target="#{{ $modalId }}">

                        @if($facility->images->count())
                            <img src="{{ asset('storage/' . $facility->images->first()->url) }}" class="card-img-top"
                                style="height: 220px; object-fit: cover;">
                        @endif

                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-2">{{ $facility->name }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.95rem;">
                                {{ Str::limit($facility->description, 100) }}
                            </p>
                            <p class="mt-2 text-primary small">Tap to see more details</p>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">{{ $facility->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                @if($facility->images->count())
                                    <div id="{{ $carouselId }}" class="carousel slide mb-3" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($facility->images as $idx => $img)
                                                <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $img->url) }}" class="d-block w-100"
                                                        style="height: 350px; object-fit: cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    </div>
                                @endif

                                <p class="mb-0" style="font-size: 0.95rem;">
                                    {{ $facility->description }}
                                </p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container-fluid p-20 mb-5">
        <div class="row g-0" style="min-height: 500px;">
            <div class="col-lg-6" style="height: 500px;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.3781132523764!2d115.1379455747759!3d-8.655541991391626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2478371ab6291%3A0xaf7e15926151d465!2sSarang%20Comfort%20Stay!5e0!3m2!1sen!2sid!4v1765777790679!5m2!1sen!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="col-lg-6 d-flex align-items-center justify-content-center bg-light text-dark"
                style="min-height: 500px;">
                <div class="p-5 text-center">
                    <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing: 3px;">Our Location</h6>
                    <h2 class="fw-bold mb-4">Sarang Comfort Stay</h2>

                    <p class="lead text-muted mb-4" style="font-family: serif; font-style: italic;">
                        "A serene escape in the heart of Canggu."
                    </p>

                    <hr class="w-25 mx-auto border-dark opacity-25 mb-4">

                    <div class="mb-3">

                        <p class="mb-0 fw-bold">Address:</p>
                        <p class="text-muted">
                            Jl. Raya Semat, Tibubeneng<br>
                            Kec. Kuta Utara, Kabupaten Badung<br>
                            Bali 80361, Indonesia
                        </p>
                    </div>

                    <div class="mb-3">
                        <p class="mb-0 fw-bold">Email:</p>
                        <p class="text-muted">sarangcomfortstay@gmail.com</p>
                    </div>

                    <div>
                        <p class="mb-0 fw-bold">Phone:</p>
                        <p class="text-muted">+62 812 3456 7890</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection