@extends('layout.main-layout')
@section('title', 'Create Room | Manager Dashboard')
@section('konten')
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Add New Motorcycle</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('rents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                
                <div class="mb-3">
                    <label class="form-label">Motorcycle name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Price per day</label>
                    <input type="number" step="0.01" name="price_per_day" class="form-control" required>
                </div>

                <div class="mb-3">
                        <label>Type Images</label>
                        <input type="file" name="images" class="form-control">
                        <small class="text-muted">only 1 picture</small>
                    </div>
                


                <button type="submit" class="btn btn-success">Add motorcycle</button>
            </form>
        </div>
    </div>
</div>
@endsection
