<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

foreach (['APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'APP_URL', 'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'SESSION_DRIVER', 'LOG_CHANNEL'] as $key) {
    $val = getenv($key);
    if ($val !== false && !isset($_ENV[$key])) {
        $_ENV[$key] = $val;
    }
}

$uri = $_SERVER['REQUEST_URI'] ?? '/';
if ($uri === '/') {
    header('Location: /index.php');
    exit;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';

if (file_exists($maintenance = __DIR__.'/core/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/core/vendor/autoload.php';

(require_once __DIR__.'/core/bootstrap/app.php')
    ->handleRequest(Request::capture());
