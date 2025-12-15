@extends('layout.main-layout')
@section('title', 'My Profile')

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
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Payment Method</th>
                                    <th>Item Details</th>
                                    <th>Dates</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $res)
                                    <tr>
                                        <td><strong>#{{ $res->id }}</strong></td>
                                        <td>
                                            @if ($res->user)
                                                <strong>{{ $res->user->name }}</strong>
                                            @else
                                                <span class="text-muted fst-italic">User Deleted</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($res->user)
                                                <strong>{{ $res->user->email }}</strong>
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
                                            <span class="badge bg-secondary">{{ $res->payment?->payment_method ?? '-'}}</span>
                                        </td>
                                        <td>
                                            @if ($res->type == 'Hotel' && $res->room)
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


                                            @if ($res->status == 'Paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($res->status == 'Pending')
                                                <span class="badge bg-warning text-dark">Unpaid</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $res->status }}</span>
                                            @endif
                                            
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