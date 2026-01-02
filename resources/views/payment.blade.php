@extends('layout.main-layout')
@section('title', "Complete Payment")

@section('konten')
    <div class="container py-5">
        <div class="row g-5">

            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing Address</h4>
                <div class="card p-4 shadow-sm">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" value="{{ Auth::user()->name ?? '' }}"
                                readonly>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ Auth::user()->email ?? '' }}"
                                readonly>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="extra_bed" value="1" id="extraBedCheck"
                                form="paymentForm" onchange="updateTotal()">
                            <label class="form-check-label" for="extraBedCheck">
                                Request Extra Bed (+ Rp 100.000 / night)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-lg-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text">Order Summary</span>
                </h4>

                <ul class="list-group mb-3 shadow-sm">

                    @if(isset($is_rental) && $is_rental)

                        <li class="list-group-item d-flex justify-content-between lh-sm bg-light">
                            <div>
                                <h6 class="my-0 fw-bold">Motorcycle Rental</h6>
                                <small class="text-muted">{{ $rental->name }}</small>
                            </div>
                            <span class="text-muted">Rp {{ number_format($rental->price_per_day, 0, ',', '.') }} /day</span>
                        </li>
                    @else

                        <li class="list-group-item d-flex justify-content-between lh-sm bg-light">
                            <div>
                                <h6 class="my-0 fw-bold">Hotel Reservation</h6>
                                <small class="text-muted">{{ $type->name }}</small>
                            </div>
                            <span class="text-muted">Rp {{ number_format($type->price_per_night, 0, ',', '.') }} /night</span>
                        </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Check-in / Start</h6>
                        </div>
                        <span class="text-muted">{{ $start_date }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Check-out / End</h6>
                        </div>
                        <span class="text-muted">{{ $end_date }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Duration</h6>
                        </div>
                        <span class="text-muted">{{ $days }} Days</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between bg-white">
                        <span class="fw-bold fs-5">Total (IDR)</span>
                        <strong class="fs-5">Rp {{ number_format($total_price, 0, ',', '.') }}</strong>
                    </li>
                </ul>
                <form id="paymentForm"
                    action="{{ (isset($is_rental) && $is_rental) ? route('reservations.storeRental') : route('reservations.storeRoom') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="check_in_date" value="{{ $start_date }}">
                    <input type="hidden" name="check_out_date" value="{{ $end_date }}">
                    <input type="hidden" name="total_price" id="inputTotalPrice" value="{{ $total_price }}">

                    @if(isset($is_rental) && $is_rental)
                        <input type="hidden" name="rental_id" value="{{ $rental->id }}">
                    @else
                        <input type="hidden" name="type_id" value="{{ $type->id }}">
                    @endif

                    <button class="w-100 btn btn-lg fw-bold" type="submit">
                        Confirm & Pay
                    </button>
                    <a href="{{ url()->previous() }}" class="w-100 btn text-white fw-bold mt-2"
                        style="background-color: #BA8B4E; border-color: #BA8B4E;">Cancel</a>
                </form>

            </div>
        </div>
    </div>
    <script>
    function updateTotal() {
        const checkbox = document.getElementById('extraBedCheck');
        const displayTotal = document.querySelector('strong.fs-5');
        const inputTotal = document.getElementById('inputTotalPrice');

        let basePrice = {{ $total_price }}; 
        let days = {{ $days ?? 1 }};
        let extraBedCost = 100000;

        let finalPrice = basePrice;
        
        if (checkbox.checked) {
            finalPrice = basePrice + (extraBedCost * days);
        }

        let formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(finalPrice);

        displayTotal.innerText = formattedPrice;
        inputTotal.value = finalPrice;
    }
</script>
@endsection