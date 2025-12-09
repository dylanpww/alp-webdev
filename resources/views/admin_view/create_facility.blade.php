@extends('layout.main-layout')

@section('title', 'Create Facility')

@section('konten')
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="m-0">Create New Facility</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('facility.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Facility Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Facility Images</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                        <small class="text-muted">You can upload multiple images</small>
                    </div>

                    <button class="btn" style="background-color: #BA8B4E; border-color: #BA8B4E;">Create Facility</button>
                </form>

            </div>
        </div>
    </div>
@endsection