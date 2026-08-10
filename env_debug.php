<?php
echo "<h2>$_ENV vs getenv</h2>";
echo "<h3>\$_ENV:</h3><pre>";
foreach (['APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'DB_DATABASE', 'DB_HOST'] as $k) {
    echo "$k: " . (isset($_ENV[$k]) ? $_ENV[$k] : 'NOT SET') . "\n";
}
echo "</pre><h3>getenv():</h3><pre>";
foreach (['APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'DB_DATABASE', 'DB_HOST'] as $k) {
    $v = getenv($k);
    echo "$k: " . ($v === false ? 'NOT SET' : $v) . "\n";
}
echo "</pre>";
