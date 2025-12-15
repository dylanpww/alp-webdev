@extends('layout.main-layout')
@section('title', 'Edit User Role')

@section('konten')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="m-0">Edit User Role: {{ $user->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label class="fw-bold">Full Name</label>
                                <input type="text" class="form-control bg-light" 
                                    value="{{ $user->name }}" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Email Address</label>
                                <input type="text" class="form-control bg-light" 
                                    value="{{ $user->email }}" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Role Access</label>
                                <select name="role" class="form-select border-primary" required>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                                        User (Customer)
                                    </option>
                                    <option value="receptionist" {{ $user->role == 'receptionist' ? 'selected' : '' }}>
                                        Receptionist
                                    </option>
                                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>
                                        Manager
                                    </option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                                <button class="btn btn-primary">Update Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection