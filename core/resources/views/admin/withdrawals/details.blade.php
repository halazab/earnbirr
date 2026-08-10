@extends('admin.layouts.master')
@section('content')
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                {{ $pageTitle }}
                <a href="{{ route('admin.withdrawals.all') }}" class="btn btn-sm btn-outline-secondary float-end">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Transaction ID</th>
                        <td><span class="fw-bold">{{ $withdrawal->trx }}</span></td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>
                            <a href="{{ route('admin.users.detail', $withdrawal->user_id) }}" class="fw-bold">
                                {{ $withdrawal->user?->fullname() ?? 'N/A' }}
                            </a>
                            <div class="text-muted small">@</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Method</th>
                        <td>{{ $withdrawal->method?->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>{{ showAmount($withdrawal->amount) }}</td>
                    </tr>
                    <tr>
                        <th>Charge</th>
                        <td>{{ showAmount($withdrawal->charge) }}</td>
                    </tr>
                    <tr>
                        <th>Final Amount</th>
                        <td class="fw-bold">{{ showAmount($withdrawal->final_amount) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($withdrawal->status == 0)
                                <span class="badge bg-soft-warning">Pending</span>
                            @elseif($withdrawal->status == 1)
                                <span class="badge bg-soft-success">Approved</span>
                            @else
                                <span class="badge bg-soft-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    @if($withdrawal->user_data)
                    <tr>
                        <th>User Details</th>
                        <td>
                            @foreach($withdrawal->user_data as $key => $value)
                                <div><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</div>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>Date</th>
                        <td>{{ showDateTime($withdrawal->created_at) }}</td>
                    </tr>
                    @if($withdrawal->admin_note)
                    <tr>
                        <th>Admin Note</th>
                        <td>{{ $withdrawal->admin_note }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        @if($withdrawal->status == 0)
        <div class="card">
            <div class="card-header">Actions</div>
            <div class="card-body">
                <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check"></i> Approve Withdrawal
                    </button>
                </form>
                <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Admin Note</label>
                        <textarea name="admin_note" class="form-control" rows="2" placeholder="Optional reason"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Reject this withdrawal?')">
                        <i class="fas fa-times"></i> Reject Withdrawal
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-header">Information</div>
            <div class="card-body">
                <p class="mb-0 text-muted">This withdrawal has already been {{ $withdrawal->status == 1 ? 'approved' : 'rejected' }}.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
