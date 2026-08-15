<?php

$uri = $_SERVER['REQUEST_URI'] ?? '/';

// Raw health check - bypass Laravel entirely
if ($uri === '/health' || $uri === '/health/') {
    http_response_code(200);
    header('Content-Type: text/plain');
    echo 'OK';
    exit(0);
}

// Debug endpoint - shows startup log
if ($uri === '/debug' || $uri === '/debug/') {
    $logFile = __DIR__ . '/../storage/logs/startup.log';
    $phpErrors = __DIR__ . '/../storage/logs/php_errors.log';
    header('Content-Type: text/plain');
    echo "=== STARTUP LOG ===\n";
    echo file_exists($logFile) ? file_get_contents($logFile) : "No startup log found\n";
    echo "\n=== PHP ERRORS ===\n";
    echo file_exists($phpErrors) ? file_get_contents($phpErrors) : "No PHP error log found\n";
    echo "\n=== ENV TEST ===\n";
    echo "APP_DEBUG: " . (getenv('APP_DEBUG') ?: 'NOT SET') . "\n";
    echo "APP_KEY set: " . (getenv('APP_KEY') ? 'YES' : 'NO') . "\n";
    echo "DB_HOST: " . (getenv('DB_HOST') ?: 'NOT SET') . "\n";
    echo "DB_CONNECTION: " . (getenv('DB_CONNECTION') ?: 'NOT SET') . "\n";
    exit(0);
}

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../storage/logs/php_errors.log');

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    )->send();
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    error_log('FATAL: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    error_log('TRACE: ' . $e->getTraceAsString());
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "500 Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}
