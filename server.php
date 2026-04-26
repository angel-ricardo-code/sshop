<?php
// Simple router for PHP built-in server to properly serve Laravel
// Requests for existing static files in /public are served directly.
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($file)) {
    return false; // serve the requested resource as-is
}
require_once __DIR__ . '/public/index.php';
