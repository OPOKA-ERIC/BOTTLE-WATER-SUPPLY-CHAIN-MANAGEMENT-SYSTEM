<?php
/**
 * Simple Check Script
 */
echo "<h1>Water Supply - Debug</h1>";

// Check if vendor exists
if (is_dir(__DIR__ . '/vendor')) {
    echo "<p>vendor/ EXISTS</p>";
} else {
    echo "<p>vendor/ MISSING</p>";
}

// Check if artisan exists
if (file_exists(__DIR__ . '/artisan')) {
    echo "<p>artisan EXISTS</p>";
} else {
    echo "<p>artisan MISSING</p>";
}

// Check exec
echo "<p>exec enabled: " . (function_exists('exec') ? 'YES' : 'NO') . "</p>";
echo "<p>shell_exec enabled: " . (function_exists('shell_exec') ? 'YES' : 'NO') . "</p>";

// Try to find composer
$paths = [
    '/usr/local/bin/composer',
    '/usr/bin/composer',
    __DIR__ . '/composer.phar'
];
foreach ($paths as $p) {
    echo "<p>Composer at $p: " . (file_exists($p) ? 'YES' : 'NO') . "</p>";
}

phpinfo();
?>
