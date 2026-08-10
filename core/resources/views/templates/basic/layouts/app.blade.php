<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', gs('site_name')) - {{ gs('site_name') }}</title>
    @if(gs('site_icon_url'))<link rel="icon" href="{{ gs('site_icon_url') }}">@endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981',
                        'primary-dark': '#059669',
                        secondary: '#3b82f6',
                    },
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
        }
        .glass { background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; display: flex; align-items: center; justify-content: center;
            z-index: 9999; transition: opacity 0.4s, visibility 0.4s;
        }
        .preloader.hidden { opacity: 0; visibility: hidden; }
        .preloader-spinner {
            width: 48px; height: 48px; border: 4px solid #e2e8f0;
            border-top-color: #10b981; border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        #scroll-top {
            position: fixed; bottom: 24px; right: 24px; width: 44px; height: 44px;
            border-radius: 12px; background: #10b981; color: #fff; border: none;
            display: none; align-items: center; justify-content: center;
            cursor: pointer; z-index: 50; box-shadow: 0 4px 12px rgba(16,185,129,0.3);
            transition: all 0.3s;
        }
        #scroll-top:hover { background: #059669; transform: translateY(-2px); }
        .card {
            background: #fff; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .btn-primary {
            background: #10b981; color: #fff; border-radius: 10px; padding: 12px 24px;
            font-weight: 600; font-size: 14px; transition: all 0.3s; border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover { background: #059669; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
        .btn-secondary {
            background: #3b82f6; color: #fff; border-radius: 10px; padding: 12px 24px;
            font-weight: 600; font-size: 14px; transition: all 0.3s; border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-secondary:hover { background: #2563eb; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(59,130,246,0.3); }
        .btn-outline {
            background: transparent; color: #10b981; border-radius: 10px; padding: 12px 24px;
            font-weight: 600; font-size: 14px; transition: all 0.3s; border: 2px solid #10b981; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-outline:hover { background: #10b981; color: #fff; }
        .form-input {
            width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 14px; transition: all 0.3s; background: #fff; outline: none;
        }
        .form-input:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.12); }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #475569; margin-bottom: 6px; }
        .form-error { color: #ef4444; font-size: 12px; margin-top: 4px; }
        .badge { display: inline-flex; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 500; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        @media (max-width: 640px) {
            .container { padding-left: 16px; padding-right: 16px; }
        }
    </style>
    @stack('style')
</head>
<body class="antialiased">

    <div class="preloader" id="preloader">
        <div class="preloader-spinner"></div>
    </div>

    @include('templates.basic.partials.header')

    <main>
        @yield('content')
    </main>

    @include('templates.basic.partials.footer')

    <button id="scroll-top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="fas fa-arrow-up"></i>
    </button>

    @includeIf('templates.basic.partials.notification')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            document.getElementById('preloader').classList.add('hidden');
        });
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('scroll-top');
            if (window.scrollY > 400) { btn.style.display = 'flex'; }
            else { btn.style.display = 'none'; }
        });
    </script>
    @stack('script')
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6a6de6a9dff2981d4a1ec581/1jv3cbra7';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
</body>
</html>
