@extends('layout.main-layout')
@section('title', 'Pay Now')

@section('konten')
<div class="container py-5 text-center">
    <div class="card shadow mx-auto p-5" style="max-width: 500px;">
        <h2 class="text-success mb-3">Booking Created!</h2>
        <p>Your Order ID: {{ $reservation->id }}</p>
        <h3 class="fw-bold">Rp {{ number_format($reservation->total_price) }}</h3>
        
        <button id="pay-button" class="btn btn-primary btn-lg mt-4 w-100">Pay Now</button>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert("Payment Success!");
                window.location.href = "{{ route('home') }}";
            },
            onPending: function(result){
                alert("Waiting for your payment!");
                window.location.href = "{{ route('home') }}";
            },
            onError: function(result){
                alert("Payment failed!");
                window.location.href = "{{ route('home') }}";
            }
        });
    };
</script>
@endsection