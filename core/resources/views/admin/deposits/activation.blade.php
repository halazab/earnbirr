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
                <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.deposits.activation') }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.deposits.activation', ['status' => 'pending']) }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}" href="{{ route('admin.deposits.activation', ['status' => 'approved']) }}">Approved</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" href="{{ route('admin.deposits.activation', ['status' => 'rejected']) }}">Rejected</a>
            </li>
        </ul>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Trx</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Transaction ID</th>
                        <th>Receipt</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $d)
                    @php $info = json_decode($d->information ?? '{}', true); @endphp
                    <tr>
                        <td><span class="fw-bold">{{ $d->trx }}</span></td>
                        <td>{{ $d->user?->fullname() ?? 'N/A' }}</td>
                        <td>{{ showAmount($d->amount) }}</td>
                        <td>{{ ucfirst($d->method) }}</td>
                        <td>
                            @if(!empty($info['ref_code']))
                                <span class="fw-bold text-primary">{{ $info['ref_code'] }}</span>
                            @elseif($d->reference_code && $d->reference_code !== 'activation')
                                <span class="fw-bold text-primary">{{ $d->reference_code }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if(!empty($info['receipt_id']))
                                <a href="/uploads/{{ $info['receipt_id'] }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-image"></i> View</a>
                            @elseif(!empty($info['receipt']))
                                @php $receiptPath = storage_path('app/public/' . $info['receipt']); @endphp
                                @if(file_exists($receiptPath))
                                    <a href="/storage/{{ $info['receipt'] }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-image"></i> View</a>
                                @else
                                    <span class="text-muted">File not found</span>
                                @endif
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($d->status == 0)
                                <span class="badge bg-soft-warning">Pending</span>
                            @elseif($d->status == 1)
                                <span class="badge bg-soft-success">Activated</span>
                            @else
                                <span class="badge bg-soft-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ showDateTime($d->created_at) }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($d->status == 0)
                                <form action="{{ route('admin.deposits.activation.approve', $d->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success" title="Activate Account"><i class="fas fa-check"></i> Activate</button>
                                </form>
                                <form action="{{ route('admin.deposits.reject', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject this activation?')">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $d->id }}">
                                    <input type="hidden" name="admin_feedback" value="Activation fee rejected by admin.">
                                    <button class="btn btn-sm btn-danger" title="Reject"><i class="fas fa-times"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No activation fees found</td>
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
