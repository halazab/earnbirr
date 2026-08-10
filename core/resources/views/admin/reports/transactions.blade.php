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
                <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}" style="width:160px">
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Trx</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Charge</th>
                        <th>Post Balance</th>
                        <th>Type</th>
                        <th>Remark</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td><span class="fw-bold">{{ $t->trx }}</span></td>
                        <td>{{ $t->user?->fullname() ?? 'N/A' }}</td>
                        <td>{{ showAmount($t->amount) }}</td>
                        <td>{{ showAmount($t->charge) }}</td>
                        <td>{{ showAmount($t->post_balance) }}</td>
                        <td>
                            @if($t->type == '+')
                                <span class="badge bg-soft-success">Credit</span>
                            @else
                                <span class="badge bg-soft-danger">Debit</span>
                            @endif
                        </td>
                        <td>{{ strLimit($t->remark, 30) }}</td>
                        <td>{{ showDateTime($t->created_at) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No transactions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
