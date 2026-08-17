@extends('templates.basic.layouts.app')

@section('title', 'Account Activation')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Account Activation</h1>
            <p class="text-gray-500 text-sm mt-1">Pay the one-time fee to unlock all tasks</p>
        </div>

        @if($pendingDeposit)
            <div class="card p-6 lg:p-8 text-center">
                <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Payment Pending Approval</h2>
                <p class="text-gray-500 text-sm mb-4">Your activation fee payment is waiting for admin approval.</p>
                <div class="bg-yellow-50 rounded-xl p-4 text-left text-sm">
                    <p class="text-gray-600"><strong>Transaction:</strong> {{ $pendingDeposit->trx }}</p>
                    <p class="text-gray-600"><strong>Amount:</strong> {{ showAmount($pendingDeposit->final_amount) }}</p>
                    <p class="text-gray-600"><strong>Method:</strong> {{ ucfirst($pendingDeposit->method) }}</p>
                    <p class="text-gray-600"><strong>Status:</strong> <span class="text-yellow-600 font-medium">Pending</span></p>
                </div>
            </div>
        @else
            <div class="card overflow-hidden">
                {{-- TeleBirr Header --}}
                <div class="p-5 text-center border-b border-gray-100">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        @include('templates.basic.partials.telebirr-logo')
                        <span class="text-xl font-bold text-gray-900">TeleBirr</span>
                    </div>
                </div>

                {{-- Payment Instructions --}}
                <div class="p-5 bg-gray-50 text-sm text-gray-600 space-y-3">
                    <p class="font-bold text-gray-900">⚡️Earnbirr ቅድመ-ምዝገባ (250 ብር)</p>

                    <div class="bg-white rounded-xl p-3 border border-gray-200 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">ተሌብር ቁጥር:</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-gray-900" id="phone-display">0992534646</span>
                                <button type="button" onclick="copyText('0990781902', this)" class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-emerald-100 hover:text-emerald-500 transition-colors flex-shrink-0">
                                    <i class="fas fa-copy text-xs"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">መጠሪያ ስም:</span>
                            <span class="font-bold text-gray-900">Samuel Aragaw</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">የሚላከው መጠን:</span>
                            <span class="font-bold text-emerald-600">250.00 ብር</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">ቴሌብር ሪማርክ:</span>
                            <span class="font-bold text-gray-900">Earnbirr ቅድመ-ክፍያ</span>
                        </div>
                    </div>
                </div>

                {{-- How to Pay --}}
                <div class="p-5 text-sm text-gray-600 space-y-3">
                    <p class="font-bold text-gray-900">የክፍያ ቅደም ተከተል:</p>
                    <div class="flex items-start gap-2">
                        <span class="text-emerald-500 font-bold">1.</span>
                        <p>ከላይ ባለው ቁጥር 250 ብር ያስተላልፉ።</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-emerald-500 font-bold">2.</span>
                        <p>የደረሰኝ ስክሪንሾት ወይም ቴሌብር ቼክ (Transaction ID) ከታች ባለው ፎርም ላይ ያስገቡ።</p>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('user.activation') }}" enctype="multipart/form-data" class="p-5">
                    @csrf

                    <input type="hidden" name="method_id" value="{{ $methods->first()->id ?? '' }}">

                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-900">Transaction ID</label>
                        <input type="text" name="reference_code" class="form-input" placeholder="e.g. ABCD123456" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-900">Upload Receipt <span class="text-gray-400 text-xs font-normal">(optional)</span></label>
                        <input type="file" name="receipt" class="form-input">
                        <p class="text-xs text-gray-400 mt-1">Screenshot of the transaction. Max 5MB.</p>
                    </div>

                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-xl transition-colors text-base">
                        <i class="fas fa-check-circle mr-2"></i> PAY & ACTIVATE
                    </button>
                </form>
            </div>

            <div class="card p-6 mt-6">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle text-emerald-500"></i> What you get after activation
                </h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-xs"></i> Access to all available tasks</li>
                    <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-xs"></i> Higher earning potential</li>
                    <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-xs"></i> Priority support</li>
                    <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-xs"></i> Daily claim rewards</li>
                </ul>
            </div>
        @endif
    </div>
</section>

@push('script')
<script>
function copyText(text, btn) {
    navigator.clipboard.writeText(text);
    btn.innerHTML = '<i class="fas fa-check text-xs text-emerald-500"></i>';
    setTimeout(() => { btn.innerHTML = '<i class="fas fa-copy text-xs"></i>'; }, 2000);
}
</script>
@endpush
@endsection
