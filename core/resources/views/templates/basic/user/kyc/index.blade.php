@extends('templates.basic.layouts.app')

@section('title', $pageTitle)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
                <i class="fas fa-id-card text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">KYC Verification</h1>
            <p class="text-gray-500 text-sm mt-1">Verify your identity to unlock all features</p>
        </div>

        @if($user->kv == 1)
            <div class="card p-6 text-center">
                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Already Verified</h2>
                <p class="text-gray-500 text-sm">Your identity has been verified successfully.</p>
            </div>
        @elseif($user->kv == 2)
            <div class="card p-6 text-center">
                <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Pending Review</h2>
                <p class="text-gray-500 text-sm">Your KYC documents are being reviewed by our team.</p>
            </div>
        @else
            <div class="card p-6 lg:p-8">
                <form method="POST" action="{{ route('user.kyc.submit') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="firstname" class="form-input" value="{{ old('firstname', $user->firstname) }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-input" value="{{ old('lastname', $user->lastname) }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->mobile) }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Country</label>
                            <select name="country" class="form-input" required>
                                <option value="">Select Country</option>
                                <option value="Ethiopia" {{ old('country') == 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
                                <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-input" value="{{ old('address') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-input" value="{{ old('city') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">State / Region</label>
                            <input type="text" name="state" class="form-input" value="{{ old('state') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">ZIP / Postal Code</label>
                            <input type="text" name="zip" class="form-input" value="{{ old('zip') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">ID Type</label>
                            <select name="id_type" id="id_type" class="form-input" required onchange="toggleIdUploads()">
                                <option value="">Select ID Type</option>
                                <option value="passport" {{ old('id_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                <option value="national_id" {{ old('id_type') == 'national_id' ? 'selected' : '' }}>National ID</option>
                                <option value="driving_license" {{ old('id_type') == 'driving_license' ? 'selected' : '' }}>Driving License</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">ID Number</label>
                            <input type="text" name="id_number" class="form-input" value="{{ old('id_number') }}" required>
                        </div>
                        <div class="col-12" id="upload_front">
                            <label class="form-label" id="front_label">Upload ID Photo (Front)</label>
                            <input type="file" name="id_front" class="form-input" accept="image/jpeg,image/png,image/jpg" required>
                            <p class="text-xs text-gray-400 mt-1">Max 5MB. JPG or PNG.</p>
                        </div>
                        <div class="col-12" id="upload_back" style="display:none">
                            <label class="form-label" id="back_label">Upload ID Photo (Back)</label>
                            <input type="file" name="id_back" class="form-input" accept="image/jpeg,image/png,image/jpg">
                            <p class="text-xs text-gray-400 mt-1">Max 5MB. JPG or PNG.</p>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full mt-6 justify-center">
                        <i class="fas fa-paper-plane"></i> Submit for Review
                    </button>
                </form>
            </div>

            <script>
            function toggleIdUploads() {
                const type = document.getElementById('id_type').value;
                const front = document.getElementById('upload_front');
                const back = document.getElementById('upload_back');
                const frontLabel = document.getElementById('front_label');
                const backLabel = document.getElementById('back_label');
                const backInput = back.querySelector('input[name="id_back"]');
                if (type === 'passport') {
                    frontLabel.textContent = 'Upload Passport Photo';
                    back.style.display = 'none';
                    backInput.required = false;
                } else if (type === 'national_id' || type === 'driving_license') {
                    frontLabel.textContent = 'Upload ID Photo (Front)';
                    backLabel.textContent = 'Upload ID Photo (Back)';
                    back.style.display = 'block';
                }
            }
            </script>
        @endif
    </div>
</section>
@endsection