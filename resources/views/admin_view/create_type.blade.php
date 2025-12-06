@extends('layout.main-layout')

@section('title', 'Create Room Type')

@section('konten')
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="m-0">Create New Room Type</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('types.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Type Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Type Images</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                        <small class="text-muted">You can upload multiple images</small>
                    </div>

                    <button class="btn btn-primary">Create Type</button>
                </form>

            </div>
        </div>
    </div>
@endsection