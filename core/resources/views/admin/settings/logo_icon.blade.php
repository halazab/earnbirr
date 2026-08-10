@php $setting = gs(); @endphp
@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">{{ $pageTitle }}</div>
    <div class="card-body">
        <form action="{{ route('admin.setting.logo.icon') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Site Logo URL</label>
                    <input type="url" name="site_logo_url" class="form-control" value="{{ $setting->site_logo_url }}" placeholder="https://example.com/logo.png">
                    <small class="text-muted">Paste a direct URL to your logo image (recommended size: 200x50px)</small>
                    @if($setting->site_logo_url)
                        <div class="mt-3 p-3 border rounded bg-light">
                            <p class="text-muted small mb-2">Preview:</p>
                            <img src="{{ $setting->site_logo_url }}" alt="Site Logo" style="max-height: 50px;" class="img-fluid">
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Site Icon / Favicon URL</label>
                    <input type="url" name="site_icon_url" class="form-control" value="{{ $setting->site_icon_url }}" placeholder="https://example.com/favicon.ico">
                    <small class="text-muted">Paste a direct URL to your favicon (recommended: 32x32px)</small>
                    @if($setting->site_icon_url)
                        <div class="mt-3 p-3 border rounded bg-light">
                            <p class="text-muted small mb-2">Preview:</p>
                            <img src="{{ $setting->site_icon_url }}" alt="Site Icon" style="max-height: 32px;" class="img-fluid">
                        </div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Update Logo & Icon</button>
        </form>
    </div>
</div>
@endsection
