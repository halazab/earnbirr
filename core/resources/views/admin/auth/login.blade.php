<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ gs('site_name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @if(gs('site_icon_url'))<link rel="icon" href="{{ gs('site_icon_url') }}">@endif
    <style>
        :root { --base: #10b981; --base-dark: #059669; }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 420px;
            max-width: 95%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-card h2 { font-weight: 800; color: #0f172a; margin-bottom: 5px; }
        .login-card .subtitle { color: #64748b; margin-bottom: 30px; }
        .login-card .logo { text-align: center; margin-bottom: 30px; }
        .login-card .logo h1 { font-weight: 800; font-size: 28px; }
        .login-card .logo span { color: var(--base); }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 12px 16px;
            font-size: 14px;
        }
        .form-control:focus { border-color: var(--base); box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
        .form-label { font-weight: 600; font-size: 13px; color: #475569; }
        .btn-login {
            background: var(--base);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            color: #fff;
            transition: all 0.2s;
        }
        .btn-login:hover { background: var(--base-dark); transform: translateY(-1px); }
        .alert { border-radius: 10px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            @if(gs('site_logo_url'))
                <img src="{{ gs('site_logo_url') }}" alt="{{ gs('site_name') }}" style="max-height: 50px;" class="img-fluid mb-2">
            @else
                <h1><span>{{ substr(gs('site_name'), 0, 4) }}</span>{{ substr(gs('site_name'), 4) }}</h1>
            @endif
            <p class="subtitle">Admin Panel</p>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Enter your username">
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Enter your password">
            </div>
            <button type="submit" class="btn-login">Sign In</button>
        </form>
    </div>
</body>
</html>
