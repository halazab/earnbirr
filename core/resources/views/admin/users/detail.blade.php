@extends('admin.layouts.master')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">User Information</div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ getImage(getFilePath('userProfile'), $user->image) }}" class="rounded-circle" width="100" height="100" alt="">
                    <h5 class="mt-3 mb-0">{{ $user->fullname() }}</h5>
                    <span class="text-muted">@</span>{{ $user->username }}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Email</span>
                        <span>{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Mobile</span>
                        <span>{{ $user->mobile ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Balance</span>
                        <span class="fw-bold">{{ showAmount($user->balance) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Status</span>
                        @if($user->status == 1)
                            <span class="badge bg-soft-success">Active</span>
                        @else
                            <span class="badge bg-soft-danger">Banned</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>KYC</span>
                        @if($user->kv == 1)
                            <span class="badge bg-soft-success">Verified</span>
                        @elseif($user->kv == 2)
                            <span class="badge bg-soft-warning">Pending</span>
                        @else
                            <span class="badge bg-soft-secondary">Not Submitted</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Joined</span>
                        <span>{{ showDateTime($user->created_at) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Daily Claim</span>
                        @php $lastClaim = $user->dailyClaims()->latest()->first(); @endphp
                        @if($lastClaim && $lastClaim->created_at->isToday())
                            <span class="badge bg-soft-success">Claimed Today</span>
                        @else
                            <span class="badge bg-soft-secondary">Not Claimed</span>
                        @endif
                    </li>
                </ul>
                @if($user->kv > 0 && ($user->kyc_id_front_data || $user->kyc_id_back_data))
                <div class="mt-3">
                    <h6>KYC Documents</h6>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        @if($user->kyc_id_front_data)
                        <a href="data:{{ $user->kyc_id_front_type }};base64,{{ $user->kyc_id_front_data }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-id-card"></i> Front</a>
                        @endif
                        @if($user->kyc_id_back_data)
                        <a href="data:{{ $user->kyc_id_back_type }};base64,{{ $user->kyc_id_back_data }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-id-card"></i> Back</a>
                        @endif
                    </div>
                    @if($user->kv == 2)
                    <div class="mt-2">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="kv" value="1">
                            <button class="btn btn-sm btn-success">Approve KYC</button>
                        </form>
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject KYC?')">
                            @csrf
                            <input type="hidden" name="kv" value="0">
                            <button class="btn btn-sm btn-danger">Reject KYC</button>
                        </form>
                    </div>
                    @endif
                </div>
                @endif
                @php $lastClaim = $user->dailyClaims()->latest()->first(); @endphp
                @if($lastClaim && $lastClaim->created_at->isToday())
                <div class="mt-3 pt-3 border-top">
                    <form action="{{ route('admin.users.reset.daily.claim', $user->id) }}" method="POST" onsubmit="return confirm('Reset daily claim for this user?')">
                        @csrf
                        <button class="btn btn-sm btn-outline-warning w-100"><i class="fas fa-undo"></i> Reset Daily Claim</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="row g-4 mb-4">
            <div class="col-sm-4">
                <div class="stat-card">
                    <div class="icon" style="background:#d1fae5;color:#065f46;">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="label">Total Deposit</div>
                    <div class="value">{{ showAmount($totalDeposit) }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stat-card">
                    <div class="icon" style="background:#fee2e2;color:#991b1b;">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="label">Total Withdraw</div>
                    <div class="value">{{ showAmount($totalWithdraw) }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stat-card">
                    <div class="icon" style="background:#dbeafe;color:#1e40af;">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="label">Transactions</div>
                    <div class="value">{{ $transactionCount }}</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Recent Transactions</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Trx</th>
                                <th>Amount</th>
                                <th>Charge</th>
                                <th>Post Balance</th>
                                <th>Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $t)
                            <tr>
                                <td><span class="fw-bold">{{ $t->trx }}</span></td>
                                <td>{{ showAmount($t->amount) }}</td>
                                <td>{{ showAmount($t->charge) }}</td>
                                <td>{{ showAmount($t->post_balance) }}</td>
                                <td>
                                    @if($t->type == '+')
                                        <span class="badge bg-soft-success">+</span>
                                    @else
                                        <span class="badge bg-soft-danger">-</span>
                                    @endif
                                </td>
                                <td>{{ showDateTime($t->created_at) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No transactions yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">Add Balance</div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.add.sub.balance', $user->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="credit">
                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <input type="number" step="any" name="amount" class="form-control" required placeholder="Enter amount">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Details</label>
                                <input type="text" name="details" class="form-control" required placeholder="Reason for adding balance">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Add Balance</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">Deduct Balance</div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.add.sub.balance', $user->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="debit">
                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <input type="number" step="any" name="amount" class="form-control" required placeholder="Enter amount">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Details</label>
                                <input type="text" name="details" class="form-control" required placeholder="Reason for deducting balance">
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Deduct Balance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
