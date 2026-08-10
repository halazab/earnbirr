@extends('admin.layouts.master')

@section('content')
<div class="page-content">
    <div class="main-title">
        <h3><i class="fas fa-envelope"></i> Email / SMTP Settings</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.setting.smtp.update') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>SMTP Host <span class="text-danger">*</span></label>
                            <input type="text" name="mail_host" class="form-control" value="{{ $setting->mail_host ?? 'smtp.gmail.com' }}" placeholder="smtp.gmail.com" required>
                            <small class="text-muted">Gmail: smtp.gmail.com | Outlook: smtp-mail.outlook.com</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>SMTP Port <span class="text-danger">*</span></label>
                            <input type="number" name="mail_port" class="form-control" value="{{ $setting->mail_port ?? 587 }}" required>
                            <small class="text-muted">Gmail/Outlook: 587 | SSL: 465</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username (Email) <span class="text-danger">*</span></label>
                            <input type="email" name="mail_username" class="form-control" value="{{ $setting->mail_username ?? '' }}" placeholder="yourname@gmail.com" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password (App Password) <span class="text-danger">*</span></label>
                            <input type="password" name="mail_password" class="form-control" value="{{ $setting->mail_password ?? '' }}" placeholder="16-character app password" required>
                            <small class="text-muted">Generate at myaccount.google.com/apppasswords</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Encryption</label>
                            <select name="mail_encryption" class="form-control">
                                <option value="tls" {{ ($setting->mail_encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS (Recommended)</option>
                                <option value="ssl" {{ ($setting->mail_encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="none" {{ ($setting->mail_encryption ?? '') == 'none' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>From Email Address</label>
                            <input type="email" name="mail_from_address" class="form-control" value="{{ $setting->mail_from_address ?? ($setting->mail_username ?? '') }}" placeholder="hello@earnbirr.com">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>From Name</label>
                            <input type="text" name="mail_from_name" class="form-control" value="{{ $setting->mail_from_name ?? 'EarnBirr' }}" placeholder="EarnBirr">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save SMTP Settings</button>
                    <button type="button" class="btn btn-success ml-2" onclick="testEmail()"><i class="fas fa-paper-plane"></i> Send Test Email</button>
                </div>
            </form>

            <hr>

            <div class="mt-3">
                <h6><i class="fas fa-info-circle text-info"></i> Gmail Setup Instructions</h6>
                <ol class="text-muted" style="font-size: 0.85rem;">
                    <li>Go to <a href="https://myaccount.google.com/security" target="_blank">Google Account Security</a></li>
                    <li>Enable <strong>2-Step Verification</strong> (required for app passwords)</li>
                    <li>Go to <a href="https://myaccount.google.com/apppasswords" target="_blank">App Passwords</a></li>
                    <li>Select <strong>Mail</strong> and <strong>Other (Custom name)</strong>, enter "EarnBirr"</li>
                    <li>Copy the 16-character password and paste it above</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<script>
function testEmail() {
    var email = prompt('Enter your email address to send a test email:');
    if (email) {
        fetch('{{ route("admin.setting.smtp.test") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Test email sent successfully! Check your inbox.');
            } else {
                alert('Error: ' + (data.message || 'Failed to send test email.'));
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}
</script>
@endsection
