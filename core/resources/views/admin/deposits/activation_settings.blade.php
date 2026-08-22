@extends('admin.layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-check me-2"></i> {{ $pageTitle }}
            </div>
            <div class="card-body">
                <p class="text-muted small mb-4">Edit the payment instructions shown to users on the Account Activation page.</p>

                <form action="{{ route('admin.deposits.activation.settings.update') }}" method="POST">
                    @csrf

                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-credit-card me-1"></i> Payment Number</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label">TeleBirr Phone Number</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                   value="{{ old('phone_number', $method->phone_number ?? '') }}" placeholder="e.g. 0901512995" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Account Name</label>
                            <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror"
                                   value="{{ old('account_name', $method->account_name ?? '') }}" placeholder="e.g. Samuel Aragaw" required>
                            @error('account_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-coins me-1"></i> Activation Fee</h6>
                    <div class="mb-4">
                        <label class="form-label">Fee Amount (ETB)</label>
                        <input type="number" step="any" name="activation_fee" class="form-control @error('activation_fee') is-invalid @enderror"
                               value="{{ old('activation_fee', $setting->activation_fee ?? 250) }}" min="1" required>
                        @error('activation_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Amount users must pay to activate their account.</small>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3"><i class="fas fa-eye me-1"></i> Preview</h6>
                    <div class="border rounded-3 p-4 bg-light mb-4" style="max-width:400px;">
                        <div class="text-center mb-3">
                            <strong class="fs-6">Telebirr</strong>
                        </div>
                        <div class="small text-dark">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">ተሌብር ቁጥር:</span>
                                <span class="fw-bold" id="preview-phone">{{ $method->phone_number ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">መጠሪያ ስም:</span>
                                <span class="fw-bold" id="preview-name">{{ $method->account_name ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">የሚላከው መጠን:</span>
                                <span class="fw-bold text-success" id="preview-fee">{{ number_format($setting->activation_fee ?? 250, 2) }} ብር</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">ቴሌብር ሪማርክ:</span>
                                <span class="fw-bold">Earnbirr ቅድመ-ክፍያ</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $('input[name="phone_number"]').on('input', function() {
        $('#preview-phone').text($(this).val() || 'N/A');
    });
    $('input[name="account_name"]').on('input', function() {
        $('#preview-name').text($(this).val() || 'N/A');
    });
    $('input[name="activation_fee"]').on('input', function() {
        const val = parseFloat($(this).val()) || 0;
        $('#preview-fee').text(val.toLocaleString('en', {minimumFractionDigits:2, maximumFractionDigits:2}) + ' ብር');
    });
</script>
@endpush
