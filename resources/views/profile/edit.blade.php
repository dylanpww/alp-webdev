@extends('layout.main-layout')
@section('title', 'My Profile')

@section('konten')
<div class="container py-5">
    <div class="card shadow mb-5 border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 fw-bold">My Reservations</h5>
        </div>
        <div class="card-body">
            @if($reservations->isEmpty())
                <p class="text-muted text-center py-3">You have no booking history yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Item Details</th>
                                <th>Dates</th>
                                <th>Status</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $res)
                                <tr>
                                    <td><strong>#{{ $res->id }}</strong></td>
                                    <td>
                                        @if($res->type == 'Hotel')
                                            <span class="badge bg-info text-dark">Hotel</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Rental</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($res->type == 'Hotel' && $res->room)
                                            <div class="fw-bold">{{ $res->room->type->name ?? 'Room' }}</div>
                                            <small class="text-muted">Room {{ $res->room->room_number }}</small>
                                        @elseif($res->type == 'Rental' && $res->rental)
                                            <div class="fw-bold">{{ $res->rental->name }}</div>
                                        @else
                                            <span class="text-muted fst-italic">Item Removed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small">
                                            {{ date('d M Y', strtotime($res->check_in_date)) }} <br> 
                                            <i class="bi bi-arrow-down-short text-muted"></i> <br> 
                                            {{ date('d M Y', strtotime($res->check_out_date)) }}
                                        </div>
                                    </td>
                                    <td>

                                        {{-- masih ga bisa ganti status karena belom di up online, jadi midtrans ga bisa ngasi notif real time --}}
                                        {{-- @if($res->status == 'Paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($res->status == 'Pending')
                                            <span class="badge bg-warning text-dark">Unpaid</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $res->status }}</span>
                                        @endif --}}
                                        <span class="badge bg-success">Paid</span>
                                    </td>
                                    <td class="fw-bold">
                                        Rp {{ number_format($res->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <hr class="my-5">

    <h4 class="mb-4 fw-bold text-secondary">Account Settings</h4>

    <div class="row g-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    Profile Information
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    Update Password
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card shadow-sm border-0 border-danger">
                <div class="card-header bg-danger text-white fw-bold">
                    Delete Account
                </div>
                <div class="card-body">
                    <p class="text-muted small">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

</div>
@endsection