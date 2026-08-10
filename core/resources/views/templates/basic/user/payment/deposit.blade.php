@extends('templates.basic.layouts.app')

@section('title', 'Deposit')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Deposit Funds</h1>
            <p class="text-gray-500 text-sm mt-1">Add money to your wallet</p>
        </div>

        <div class="card overflow-hidden">
            @forelse($methods as $m)
            <div class="border-b border-gray-100 last:border-b-0">
                {{-- Method Header --}}
                <div class="p-5 text-center">
                    @if($m->image_data)
                        <img src="data:{{ $m->image_type }};base64,{{ $m->image_data }}" class="h-10 mx-auto mb-2 object-contain" alt="{{ $m->name }}">
                    @elseif(stripos($m->name, 'telebirr') !== false)
                        <div class="flex items-center justify-center gap-2 mb-2">
                            @include('templates.basic.partials.telebirr-logo')
                            <span class="text-xl font-bold text-gray-900">TeleBirr</span>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-money-bill text-gray-500 text-xl"></i>
                        </div>
                    @endif
                </div>

                {{-- Info Table --}}
                <div class="divide-y divide-gray-100 text-center text-sm">
                    <div class="py-3">
                        <p class="text-gray-500">Service Fee</p>
                        <p class="font-medium text-gray-900">Free</p>
                    </div>
                    <div class="py-3">
                        <p class="text-gray-500">Process Time</p>
                        <p class="font-medium text-gray-900">Instant</p>
                    </div>
                </div>

                {{-- Step-by-Step Instructions --}}
                @if($m->phone_number)
                <div class="p-5 bg-gray-50 text-sm text-gray-600 space-y-3">
                    <p class="font-medium text-gray-900">How to deposit:</p>
                    <div class="flex items-start gap-2">
                        <span class="text-emerald-500 font-bold">1.</span>
                        <p>Copy the mobile number below</p>
                    </div>
                    <div class="bg-white rounded-xl p-3 border border-gray-200 flex items-center gap-2">
                        <input type="text" value="{{ $m->phone_number }}" readonly class="flex-1 text-sm bg-transparent border-0 outline-none font-mono text-gray-900" id="phone-{{ $m->id }}">
                        <button type="button" onclick="copyPhone('{{ $m->id }}')" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-emerald-100 hover:text-emerald-500 transition-colors flex-shrink-0">
                            <i class="fas fa-copy text-xs"></i>
                        </button>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-emerald-500 font-bold">2.</span>
                        <p>Go to <strong>TeleBirr app</strong>, choose <strong>"Send Money to Individual"</strong>, paste the number and make the transfer</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-emerald-500 font-bold">3.</span>
                        <p>Copy the <strong>transaction number</strong> and paste it below</p>
                    </div>
                </div>
                @endif

                {{-- Deposit Form --}}
                <form method="POST" action="{{ route('user.deposit.insert') }}" class="p-5">
                    @csrf
                    <input type="hidden" name="method_id" value="{{ $m->id }}">

                    {{-- Transaction ID --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-900">Transaction ID</label>
                        <input type="text" name="reference_code" class="form-input" placeholder="e.g. ABCD123456" required>
                    </div>

                    {{-- Amount --}}
                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-900">Amount (ETB)</label>
                        <input type="number" name="amount" class="form-input text-center text-lg font-bold" placeholder="Enter amount" required>
                    </div>

                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-xl transition-colors text-base">
                        DEPOSIT
                    </button>
                </form>
            </div>
            @empty
            <div class="p-8 text-center text-gray-400">
                <i class="fas fa-wallet text-3xl mb-3"></i>
                <p>No deposit methods available right now.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@push('script')
<script>
function copyPhone(id) {
    const input = document.getElementById('phone-' + id);
    navigator.clipboard.writeText(input.value);
    const btn = input.nextElementSibling;
    btn.innerHTML = '<i class="fas fa-check text-xs text-emerald-500"></i>';
    setTimeout(() => { btn.innerHTML = '<i class="fas fa-copy text-xs"></i>'; }, 2000);
}
</script>
@endpush
@endsection
