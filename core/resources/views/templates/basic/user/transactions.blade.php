@extends('templates.basic.layouts.app')

@section('title', 'Transactions')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Transaction History</h1>
                <p class="text-gray-500 text-sm mt-1">All your financial activities in one place</p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center gap-3">
                <div class="card px-4 py-2.5 text-sm">
                    <span class="text-gray-500">Balance: </span>
                    <span class="font-bold text-emerald-500">{{ showAmount(auth()->user()->balance) }}</span>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            @if(isset($transactions) && $transactions->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Trx ID</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Amount</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Charge</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Post Balance</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Type</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Remark</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $trx)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="font-mono text-xs font-medium text-gray-900">{{ $trx->trx }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="font-medium {{ $trx->type == '+' ? 'text-emerald-500' : 'text-red-500' }}">
                                            {{ $trx->type }}{{ showAmount($trx->amount) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600">{{ showAmount($trx->charge) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="font-medium text-gray-900">{{ showAmount($trx->post_balance) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        @if($trx->type == '+')
                                            <span class="badge badge-success">Credit</span>
                                        @else
                                            <span class="badge badge-danger">Debit</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600 capitalize">{{ $trx->remark }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600 text-xs whitespace-nowrap">{{ showDateTime($trx->created_at) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(method_exists($transactions, 'links'))
                    <div class="p-4 lg:p-6 border-t border-gray-100">
                        {{ $transactions->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exchange-alt text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No Transactions</h3>
                    <p class="text-sm text-gray-500">Your transaction history will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
