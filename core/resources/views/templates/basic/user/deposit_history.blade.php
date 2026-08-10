@extends('templates.basic.layouts.app')

@section('title', 'Deposit History')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Deposit History</h1>
                <p class="text-gray-500 text-sm mt-1">Track all your deposit transactions</p>
            </div>
            <a href="{{ route('user.deposit.index') }}" class="mt-4 sm:mt-0 btn-primary text-sm !py-2.5 !px-5">
                <i class="fas fa-plus"></i> New Deposit
            </a>
        </div>

        <div class="card overflow-hidden">
            @if(isset($deposits) && $deposits->count())
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
                            @foreach($deposits as $deposit)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="font-mono text-xs font-medium text-gray-900">{{ $deposit->trx }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600">{{ $deposit->method ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="font-medium text-gray-900">{{ showAmount($deposit->amount) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600">{{ showAmount($deposit->charge ?? 0) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        @if($deposit->status == Status::PAYMENT_SUCCESS)
                                            <span class="badge badge-success">Success</span>
                                        @elseif($deposit->status == Status::PAYMENT_PENDING)
                                            <span class="badge badge-pending">Pending</span>
                                        @elseif($deposit->status == Status::PAYMENT_REJECTED)
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600 text-xs whitespace-nowrap">{{ showDateTime($deposit->created_at) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(method_exists($deposits, 'links'))
                    <div class="p-4 lg:p-6 border-t border-gray-100">
                        {{ $deposits->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-history text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No Deposits Yet</h3>
                    <p class="text-sm text-gray-500">Make your first deposit to get started.</p>
                    <a href="{{ route('user.deposit.index') }}" class="btn-primary mt-5">Deposit Now</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
