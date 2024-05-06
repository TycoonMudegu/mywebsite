<?php

// Get the current URI
$uri = $_SERVER['REQUEST_URI'];

// Extract the path before the query string
$path = strstr($uri, '?', true) ?: $uri;

// Map URIs to corresponding PHP files
$routes = [
    '/welcome' => 'home.php',
    '/about' => 'about.php',
    '/portfolio' => 'portfolio.php',
    '/reachout' => 'reachout.php',
    '/flexing' => 'letsflex.php',
    // Add more routes as needed
];

// Debugging
echo 'Current URI: ' . $uri . '<br>';
echo 'Path: ' . $path . '<br>';

// Check if the current URI is in the routes array
if (array_key_exists($path, $routes)) {
    require_once $routes[$path];
} elseif ($path == '/' || $path == '/home') {
    require_once 'home.php';
} else {
    // If no route matches, include the 404 page
    require_once '404.php';
}

?>
