@extends('layout.main-layout')
@section('title', 'Edit Motorcycle')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0 fw-bold">Edit Motorcycle: {{ $rent->name }}</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('rents.update', $rent->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PATCH') 

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Motorcycle Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $rent->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price_per_day" class="form-label fw-bold">Price per Day (Rp)</label>
                                <input type="number" class="form-control @error('price_per_day') is-invalid @enderror"
                                    id="price_per_day" name="price_per_day" 
                                    value="{{ old('price_per_day', $rent->price_per_day) }}" required>

                                @error('price_per_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Current Image</label>

                                @if ($rent->url)
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('storage/' . $rent->url) }}"
                                            class="img-thumbnail"
                                            style="height: 150px; object-fit: cover;" alt="Motor Image">
                                    </div>
                                @else
                                    <p class="text-muted fst-italic small">No image uploaded yet.</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label fw-bold">Change Image (Optional)</label>
                                <input type="file" class="form-control @error('images') is-invalid @enderror"
                                    id="images" name="images[]" accept="image/*">
                                
                                <div class="form-text text-muted">
                                    Upload a new file to replace the current image. Leave empty to keep the current one.
                                </div>

                                @error('images')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('rents.index') }}" class="btn btn-secondary">
                                    &laquo; Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Update Motorcycle
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection