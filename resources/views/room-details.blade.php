@extends('layout.main-layout')
@section('title', $room->type_name . ' Details')

@section('konten')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $room->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $room->type_name }}" style="width: 100%; height: 400px; object-fit: cover;">
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $room->type_name }}</h2>
            <h4 class="text-success">Rp {{ number_format($room->price, 0, ',', '.') }} <small class="text-muted fs-6">/ night</small></h4>
            
            <hr>

            <h5 class="fw-bold">Description</h5>
            <p class="text-muted">{{ $room->description }}</p>

            <div class="card bg-light border-0 p-3 mt-4">
                <form action="{{ route('types.index') }}" method="GET">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        Book This Room Type
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="fw-bold mb-3">Ratings & Reviews</h4>
            
            <div class="d-flex align-items-center mb-4">
                <h1 class="fw-bold m-0 me-2">{{ number_format($room->average_rating, 1) }}</h1>
                <div>
                    <div class="text-warning fs-5">
                        @for ($i = 1; $i <= 5; $i++)
                            @if($i <= round($room->average_rating)) ★ @else ☆ @endif
                        @endfor
                    </div>
                    <small class="text-muted">{{ $room->reviews->count() }} reviews</small>
                </div>
            </div>

            @auth
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Leave a Review</h5>
                        <form action="{{ route('ratings.store', $room->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <select name="rating" class="form-select w-auto">
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Good</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Comment</label>
                                <textarea name="comment" class="form-control" rows="3" required placeholder="Share your experience..."></textarea>
                            </div>
                            <button class="btn btn-success">Submit Review</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    Please <a href="{{ route('login') }}" class="fw-bold">login</a> to leave a review.
                </div>
            @endauth

            <div class="mt-4">
                @forelse ($room->reviews as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                            <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                        </div>
                        <div class="text-warning mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating) ★ @else ☆ @endif
                            @endfor
                        </div>
                        <p class="mb-0 text-secondary">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-muted fst-italic">No reviews yet for this room type.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection