@extends('layout.main-layout')
@section('title', 'Manage Users')

@section('konten')
<div class="container py-5">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">User List</h5>
        </div>
        
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('users.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                placeholder="Search by name or email..." 
                                value="{{ request('search') }}">
                            <button class="btn text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Current Role</th>
                            <th>Registered At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'manager')
                                    <span class="badge bg-danger">Manager</span>
                                @elseif($user->role == 'receptionist')
                                    <span class="badge bg-warning text-dark">Receptionist</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                                    Change Role
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection