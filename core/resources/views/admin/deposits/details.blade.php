@extends('admin.layouts.master')
@section('content')
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                {{ $pageTitle }}
                <a href="{{ route('admin.deposits.all') }}" class="btn btn-sm btn-outline-secondary float-end">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Transaction ID</th>
                        <td><span class="fw-bold">{{ $deposit->trx }}</span></td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>
                            <a href="{{ route('admin.users.detail', $deposit->user_id) }}" class="fw-bold">
                                {{ $deposit->user?->fullname() ?? 'N/A' }}
                            </a>
                            <div class="text-muted small">@</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Gateway</th>
                        <td>{{ $deposit->gateway ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>{{ showAmount($deposit->amount) }}</td>
                    </tr>
                    <tr>
                        <th>Charge</th>
                        <td>{{ showAmount($deposit->charge) }}</td>
                    </tr>
                    <tr>
                        <th>Final Amount</th>
                        <td class="fw-bold">{{ showAmount($deposit->final_amount) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($deposit->status == 0)
                                <span class="badge bg-soft-warning">Pending</span>
                            @elseif($deposit->status == 1)
                                <span class="badge bg-soft-success">Approved</span>
                            @else
                                <span class="badge bg-soft-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ showDateTime($deposit->created_at) }}</td>
                    </tr>
                    @if($deposit->admin_note)
                    <tr>
                        <th>Admin Note</th>
                        <td>{{ $deposit->admin_note }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        @if($deposit->status == 0)
        <div class="card">
            <div class="card-header">Actions</div>
            <div class="card-body">
                <form action="{{ route('admin.deposits.approve', $deposit->id) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check"></i> Approve Deposit
                    </button>
                </form>
                <form action="{{ route('admin.deposits.reject', $deposit->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $deposit->id }}">
                    <div class="mb-2">
                        <label class="form-label">Admin Feedback</label>
                        <textarea name="admin_feedback" class="form-control" rows="2" placeholder="Reason for rejection" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Reject this deposit?')">
                        <i class="fas fa-times"></i> Reject Deposit
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-header">Information</div>
            <div class="card-body">
                <p class="mb-0 text-muted">This deposit has already been {{ $deposit->status == 1 ? 'approved' : 'rejected' }}.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
