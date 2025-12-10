@extends('layout.main-layout')
@section('title', 'Edit Room Type')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0 fw-bold">Edit Room Type: {{ $type->name }}</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('types.update', $type->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PATCH') 

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Type Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $type->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price_per_night" class="form-label fw-bold">Price per Night (Rp)</label>
                                <input type="number" step="0.01" class="form-control @error('price_per_night') is-invalid @enderror"
                                    id="price_per_night" name="price_per_night" 
                                    value="{{ old('price_per_night', $type->price_per_night) }}" required>

                                @error('price_per_night')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" required>{{ old('description', $type->description) }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Current Images</label>

                                @if ($type->images->isEmpty())
                                    <p class="text-muted fst-italic small">No images uploaded yet.</p>
                                @else
                                    <div class="row g-2">
                                        @foreach ($type->images as $image)
                                            <div class="col-6 col-md-3">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $image->url) }}"
                                                        class="img-thumbnail w-100"
                                                        style="height: 100px; object-fit: cover;" alt="Type Image">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label fw-bold">Add More Images (Optional)</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                    id="images" name="images[]" multiple accept="image/*">
                                <div class="form-text text-muted">
                                    You can upload multiple files. New images will be added to the list.
                                </div>

                                @error('images')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('types.index') }}" class="btn btn-secondary">
                                    &laquo; Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Update Type
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection