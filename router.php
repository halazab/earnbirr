<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$publicPath = __DIR__ . '/core/public' . $uri;
if ($uri !== '/' && file_exists($publicPath)) {
    return false;
}
require __DIR__ . '/index.php';
