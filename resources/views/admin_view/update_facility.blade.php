@extends('layout.main-layout')
@section('title', 'Edit Facility')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0 fw-bold">Edit Facility: {{ $facility->name }}</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('facility.update', $facility->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PATCH') 

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Facility Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $facility->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" required>{{ old('description', $facility->description) }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Current Images</label>

                                @if ($facility->images->isEmpty())
                                    <p class="text-muted fst-italic small">No images uploaded yet.</p>
                                @else
                                    <div class="row g-2">
                                        @foreach ($facility->images as $image)
                                            <div class="col-6 col-md-3">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $image->url) }}"
                                                        class="img-thumbnail w-100"
                                                        style="height: 100px; object-fit: cover;" alt="Facility Image">
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
                                <a href="{{ route('facility.index') }}" class="btn btn-secondary">
                                    &laquo; Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Update Facility
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
