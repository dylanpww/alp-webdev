@extends('layout.main-layout')
@section('title', 'My Profile')

@section('konten')
    
    <div class="container pt-5">
        
        <div class="card shadow border-0 mb-5 rounded-3 overflow-hidden">
            <div class="card-header p-4 border-bottom" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                <h5 class="mb-0 fw-bold text-white">My Reservations</h5>
            </div>
            <div class="card-body p-0">
                @if ($reservations->isEmpty())
                    <div class="text-center py-5">
                        <p class="text-muted">You have no booking history yet.</p>
                        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary">Book Now</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">ID</th>
                                    <th>Type</th>
                                    <th>Item Details</th>
                                    <th>Dates</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($reservations as $res)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="font-monospace text-muted">#{{ $res->id }}</span>
                                        </td>
                                        <td>
                                            @if ($res->type == 'Hotel')
                                                <span class="badge rounded-pill bg-indigo text-white" style="background-color: #6610f2;">
                                                    Hotel
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-orange text-dark" style="background-color: #fd7e14;">
                                                    Rental
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($res->type == 'Hotel')
                                                @if($res->type_id)
                                                    <div class="fw-bold text-dark">{{ $res->roomType->name ?? 'Unknown Type' }}</div>
                                                    
                                                    @if($res->extra_bed)
                                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 mt-1">
                                                                Extra Bed
                                                        </span>
                                                    @endif

                                                    <div class="small text-muted mt-1">
                                                        @if($res->room_id)
                                                            Room {{ $res->room->room_number }}
                                                        @else
                                                            <em>Room Pending</em>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">Data Missing</span>
                                                @endif
                                            
                                            @elseif($res->type == 'Rental' && $res->rental)
                                                <div class="fw-bold">{{ $res->rental->name }}</div>
                                                <small class="text-muted">{{ $res->rental->plate_number ?? '' }}</small>
                                            @else
                                                <span class="text-muted fst-italic">Item Removed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column small">
                                                <span class="text-success">{{ date('d M Y', strtotime($res->check_in_date)) }}</span>
                                                <span class="text-danger">{{ date('d M Y', strtotime($res->check_out_date)) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match(strtolower($res->status)) {
                                                    'paid', 'settlement', 'capture' => 'success',
                                                    'pending' => 'warning',
                                                    'cancelled', 'expire', 'deny' => 'danger',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }} bg-opacity-25 text-{{ $statusClass }} px-3 py-2 rounded-2">
                                                {{ ucfirst($res->status) }}
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end fw-bold text-dark">
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


        <h4 class="mb-4 fw-bold text-secondary ps-2 border-start border-4 border-primary">Account Settings</h4>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100 rounded-3">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        Profile Information
                    </div>
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100 rounded-3">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        Update Password
                    </div>
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="card shadow-sm border-0 border-start border-danger border-3 rounded-3">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="text-danger fw-bold">Delete Account</h5>
                            <p class="text-muted small mb-0">Once your account is deleted, all of its resources and data will be permanently deleted. Please be certain.</p>
                        </div>
                        
                        <div class="ms-auto">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection