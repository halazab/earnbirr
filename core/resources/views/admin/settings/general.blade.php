@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">{{ $pageTitle }}</div>
    <div class="card-body">
        <form action="{{ route('admin.setting.general') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Site Name</label>
                    <input type="text" name="site_name" class="form-control" value="{{ gs('site_name') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Currency Text</label>
                    <input type="text" name="cur_text" class="form-control" value="{{ gs('cur_text') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Currency Symbol</label>
                    <input type="text" name="cur_sym" class="form-control" value="{{ gs('cur_sym') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Base Color</label>
                    <input type="color" name="base_color" class="form-control form-control-color" value="{{ gs('base_color') ?? '#10b981' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Secondary Color</label>
                    <input type="color" name="secondary_color" class="form-control form-control-color" value="{{ gs('secondary_color') ?? '#3b82f6' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Minimum Withdraw</label>
                    <input type="number" step="any" name="min_withdraw" class="form-control" value="{{ gs('min_withdraw') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Maximum Withdraw</label>
                    <input type="number" step="any" name="max_withdraw" class="form-control" value="{{ gs('max_withdraw') ?? 65000 }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Activation Fee</label>
                    <input type="number" step="any" name="activation_fee" class="form-control" value="{{ gs('activation_fee') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Referral Bonus (ETB)</label>
                    <input type="number" step="any" name="referral_bonus" class="form-control" value="{{ gs('referral_bonus') ?? 100 }}" required>
                    <small class="text-muted">Amount paid per referral</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Email Verification</label>
                    <select name="ev" class="form-control">
                        <option value="1" {{ gs('ev') == 1 ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ gs('ev') == 0 ? 'selected' : '' }}>Disabled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">KYC Verification</label>
                    <select name="kv" class="form-control">
                        <option value="1" {{ gs('kv') == 1 ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ gs('kv') == 0 ? 'selected' : '' }}>Disabled</option>
                    </select>
                </div>
            </div>

            <div class="mt-5 pt-4 border-top">
                <h5 class="fw-bold mb-4">Footer Content</h5>
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label">Footer Description / Tagline</label>
                        <textarea name="footer_text" class="form-control" rows="2">{{ gs('footer_text') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Address</label>
                        <input type="text" name="footer_address" class="form-control" value="{{ gs('footer_address') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="footer_email" class="form-control" value="{{ gs('footer_email') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="footer_phone" class="form-control" value="{{ gs('footer_phone') }}">
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 border-top">
                <h5 class="fw-bold mb-4">Social Media Links</h5>
                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label">Telegram</label>
                        <input type="url" name="social_telegram" class="form-control" value="{{ gs('social_telegram') }}" placeholder="https://t.me/...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Facebook</label>
                        <input type="url" name="social_facebook" class="form-control" value="{{ gs('social_facebook') }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Twitter</label>
                        <input type="url" name="social_twitter" class="form-control" value="{{ gs('social_twitter') }}" placeholder="https://twitter.com/...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Instagram</label>
                        <input type="url" name="social_instagram" class="form-control" value="{{ gs('social_instagram') }}" placeholder="https://instagram.com/...">
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 border-top">
                <h5 class="fw-bold mb-4">Telegram Bot Notifications</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Bot Token</label>
                        <input type="text" name="telegram_bot_token" class="form-control" value="{{ gs('telegram_bot_token') }}" placeholder="123456:ABC-DEF1234ghIkl-zyx57W2v1u123456789">
                        <small class="text-muted">Get from @BotFather on Telegram</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Chat ID</label>
                        <input type="text" name="telegram_chat_id" class="form-control" value="{{ gs('telegram_chat_id') }}" placeholder="-1001234567890">
                        <small class="text-muted">Group or channel chat ID</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update Settings</button>
        </form>
    </div>
</div>
@endsection
