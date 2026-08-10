@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <span>{{ $pageTitle }}</span>
            <form action="" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm" style="width:250px">
                    <input type="text" name="search" class="form-control" placeholder="Trx, user or phone number" value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-tabs px-3 pt-3">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.deposits.all') }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.deposits.all', ['status' => 'pending']) }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}" href="{{ route('admin.deposits.all', ['status' => 'approved']) }}">Approved</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" href="{{ route('admin.deposits.all', ['status' => 'rejected']) }}">Rejected</a>
            </li>
        </ul>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Trx</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Charge</th>
                        <th>Final</th>
                        <th>Gateway</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $d)
                    <tr>
                        <td><span class="fw-bold">{{ $d->trx }}</span></td>
                        <td>{{ $d->user?->fullname() ?? 'N/A' }}</td>
                        <td>{{ showAmount($d->amount) }}</td>
                        <td>{{ showAmount($d->charge) }}</td>
                        <td>{{ showAmount($d->final_amount) }}</td>
                        <td>{{ $d->gateway ?? 'N/A' }}</td>
                        <td>
                            @if($d->status == 0)
                                <span class="badge bg-soft-warning">Pending</span>
                            @elseif($d->status == 1)
                                <span class="badge bg-soft-success">Approved</span>
                            @else
                                <span class="badge bg-soft-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ showDateTime($d->created_at) }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.deposits.details', $d->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($d->status == 0)
                                <form action="{{ route('admin.deposits.approve', $d->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success" title="Approve"><i class="fas fa-check"></i></button>
                                </form>
                                <form action="{{ route('admin.deposits.reject', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject this deposit?')">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $d->id }}">
                                    <input type="hidden" name="admin_feedback" value="Deposit rejected by admin.">
                                    <button class="btn btn-sm btn-danger" title="Reject"><i class="fas fa-times"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No deposits found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($deposits->hasPages())
    <div class="card-footer">
        {{ $deposits->links() }}
    </div>
    @endif
</div>
@endsection
