@extends('templates.basic.layouts.app')

@section('title', 'Withdrawal History')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Withdrawal History</h1>
                <p class="text-gray-500 text-sm mt-1">Track your withdrawal requests</p>
            </div>
            <a href="{{ route('user.withdraw.index') }}" class="mt-4 sm:mt-0 btn-primary text-sm !py-2.5 !px-5">
                <i class="fas fa-plus"></i> New Withdrawal
            </a>
        </div>

        <div class="card overflow-hidden">
            @if(isset($withdrawals) && $withdrawals->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Trx</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Method</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Amount</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Charge</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdrawals as $withdraw)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="font-mono text-xs font-medium text-gray-900">{{ $withdraw->trx }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600">{{ $withdraw->method->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="font-medium text-gray-900">{{ showAmount($withdraw->amount) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600">{{ showAmount($withdraw->charge ?? 0) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        @if($withdraw->status == Status::WITHDRAWAL_PENDING)
                                            <span class="badge badge-pending">Pending</span>
                                        @elseif($withdraw->status == Status::WITHDRAWAL_APPROVED)
                                            <span class="badge badge-success">Approved</span>
                                        @elseif($withdraw->status == Status::WITHDRAWAL_REJECTED)
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600 text-xs whitespace-nowrap">{{ showDateTime($withdraw->created_at) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(method_exists($withdrawals, 'links'))
                    <div class="p-4 lg:p-6 border-t border-gray-100">
                        {{ $withdrawals->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No Withdrawals Yet</h3>
                    <p class="text-sm text-gray-500">Your withdrawal requests will appear here.</p>
                    <a href="{{ route('user.withdraw.index') }}" class="btn-primary mt-5">Withdraw Now</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
