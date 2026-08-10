@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">{{ $pageTitle }}</div>
    <div class="card-body">
        <form action="{{ route('admin.setting.system') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Maintenance Mode</label>
                    <select name="maintenance_mode" class="form-control">
                        <option value="1" {{ gs('maintenance_mode') == 1 ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ gs('maintenance_mode') == 0 ? 'selected' : '' }}>Disabled</option>
                    </select>
                    <small class="text-muted">When enabled, only admins can access the site.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">OTP Expiration (minutes)</label>
                    <input type="number" name="otp_expiration" class="form-control" value="{{ gs('otp_expiration') ?? 5 }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Daily Claim Reward</label>
                    <input type="number" step="any" name="daily_claim_reward" class="form-control" value="{{ gs('daily_claim_reward') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Verification</label>
                    <select name="ev" class="form-control">
                        <option value="1" {{ gs('ev') == 1 ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ gs('ev') == 0 ? 'selected' : '' }}>Disabled</option>
                    </select>
                    <small class="text-muted">Require email verification on registration.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">KYC Verification</label>
                    <select name="kv" class="form-control">
                        <option value="1" {{ gs('kv') == 1 ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ gs('kv') == 0 ? 'selected' : '' }}>Disabled</option>
                    </select>
                    <small class="text-muted">Require KYC verification to access withdrawals.</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Update Settings</button>
        </form>
    </div>
</div>
@endsection
