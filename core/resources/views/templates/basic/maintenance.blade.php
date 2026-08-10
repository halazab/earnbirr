<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Under Maintenance - {{ gs('site_name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#10b981', 'primary-dark': '#059669', secondary: '#3b82f6' },
                    fontFamily: { inter: ['Inter', 'sans-serif'] },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="font-inter antialiased bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full text-center">
        <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center mx-auto mb-8 shadow-lg shadow-emerald-200">
            <i class="fas fa-tools text-4xl text-white"></i>
        </div>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4">Under Maintenance</h1>
        <p class="text-gray-500 text-lg leading-relaxed">We're currently performing scheduled maintenance to improve your experience. We'll be back shortly!</p>
        <div class="flex items-center justify-center gap-3 mt-8">
            <div class="w-3 h-3 rounded-full bg-emerald-500 animate-bounce" style="animation-delay:0s"></div>
            <div class="w-3 h-3 rounded-full bg-emerald-500 animate-bounce" style="animation-delay:0.2s"></div>
            <div class="w-3 h-3 rounded-full bg-emerald-500 animate-bounce" style="animation-delay:0.4s"></div>
        </div>
        <p class="mt-8 text-sm text-gray-400">&copy; {{ date('Y') }} {{ gs('site_name') }}. All rights reserved.</p>
    </div>
</body>
</html>
