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
                <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.withdrawals.all') }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.withdrawals.all', ['status' => 'pending']) }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}" href="{{ route('admin.withdrawals.all', ['status' => 'approved']) }}">Approved</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" href="{{ route('admin.withdrawals.all', ['status' => 'rejected']) }}">Rejected</a>
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
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $w)
                    <tr>
                        <td><span class="fw-bold">{{ $w->trx }}</span></td>
                        <td>{{ $w->user?->fullname() ?? 'N/A' }}</td>
                        <td>{{ showAmount($w->amount) }}</td>
                        <td>{{ showAmount($w->charge) }}</td>
                        <td>{{ showAmount($w->final_amount) }}</td>
                        <td>{{ $w->method?->name ?? 'N/A' }}</td>
                        <td>
                            @if($w->status == 0)
                                <span class="badge bg-soft-warning">Pending</span>
                            @elseif($w->status == 1)
                                <span class="badge bg-soft-success">Approved</span>
                            @else
                                <span class="badge bg-soft-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ showDateTime($w->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.withdrawals.details', $w->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No withdrawals found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($withdrawals->hasPages())
    <div class="card-footer">
        {{ $withdrawals->links() }}
    </div>
    @endif
</div>
@endsection
