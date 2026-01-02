@extends('layout.main-layout')
@section('title', 'All Reservations')

@section('konten')
    <div class="container py-5">
        <div class="card shadow mb-5 border-0">
            <div class="card-header text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;">
                <h5 class="mb-0 fw-bold">All Reservations</h5>
            </div>
            <div class="card-body">
                @if ($reservations->isEmpty())
                    <p class="text-muted text-center py-3">There is no booking history yet.</p>
                @else
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('reservations.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by name or email..." value="{{ request('search') }}">
                                    <button class="btn text-white" style="background-color: #BA8B4E; border-color: #BA8B4E;"
                                        type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Guest Info</th>
                                    <th>Type</th>
                                    <th>Payment</th>
                                    <th>Room / Action</th>
                                    <th>Dates</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $res)
                                    <tr>
                                        <td><strong>#{{ $res->id }}</strong></td>
                                        
                                        <td>
                                            @if ($res->user)
                                                <div class="fw-bold">{{ $res->user->name }}</div>
                                                <small class="text-muted">{{ $res->user->email }}</small><br>
                                                <small class="text-muted">{{ $res->user->phone ?? '-' }}</small> 
                                            @else
                                                <span class="text-muted fst-italic">User Deleted</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($res->type == 'Hotel')
                                                <span class="badge bg-info text-dark">Hotel</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Rental</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="badge bg-secondary">{{ $res->payment?->payment_method ?? '-' }}</span>
                                        </td>

                                        <td>
                                            @if ($res->type == 'Hotel')
                                                <div class="fw-bold text-dark">{{ $res->roomType->name ?? 'Unknown Type' }}</div>
                                                
                                                @if($res->extra_bed)
                                                    <span class="badge bg-light text-primary border border-primary mb-1">+ Extra Bed</span><br>
                                                @endif

                                                @if ($res->room_id)
                                                    <span class="badge bg-primary">Room {{ $res->room->room_number }}</span>
                                                    <div class="mt-1">
                                                        <a href="{{ route('reservations.assign', $res->id) }}" class="text-decoration-none small">Change Room</a>
                                                    </div>
                                                @else
                                                    @if (strtolower($res->status) == 'paid' || strtolower($res->status) == 'settlement')
                                                        <a href="{{ route('reservations.assign', $res->id) }}" class="btn btn-sm btn-warning fw-bold mt-1">
                                                            Assign Room
                                                        </a>
                                                    @else
                                                        <span class="badge bg-light text-secondary border">Waiting Payment</span>
                                                    @endif
                                                @endif

                                            @elseif($res->type == 'Rental' && $res->rental)
                                                <div class="fw-bold">{{ $res->rental->name }}</div>
                                                <small>{{ $res->rental->plate_number ?? '' }}</small>
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
                                            @php
                                                $status = strtolower($res->status);
                                            @endphp
                                            @if ($status == 'paid' || $status == 'settlement' || $status == 'capture')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($status == 'pending')
                                                <span class="badge bg-warning text-dark">Unpaid</span>
                                            @elseif($status == 'cancelled' || $status == 'expire' || $status == 'deny')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($res->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $res->notes ?? '-' }}
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
    </div>
@endsection