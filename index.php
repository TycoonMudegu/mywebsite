<?php

// Get the current URI
$uri = $_SERVER['REQUEST_URI'];

// Extract the path before the query string
$path = strstr($uri, '?', true) ?: $uri;

// Define the base directory
$baseDir = 'https://tycoontest-92caab624ce2.herokuapp.com';

// Map URIs to corresponding PHP files
$routes = [
    $baseDir . '/welcome' => 'home.php',
    $baseDir . '/about' => 'about.php',
    $baseDir . '/potfolio' => 'potfolio.php',
    $baseDir . '/Reachout' => 'reachout.php',

    $baseDir . '/flexing' => 'letsflex.php',
   
    // Add more routes as needed
];

// Check if the current URI is in the routes array
if (array_key_exists($path, $routes)) {
    require_once $routes[$path];
} elseif ($path == $baseDir . '/home' || $path == $baseDir . '/') {
    require_once 'home.php';
} else {
    // If no route matches, include the 404 page
    require_once '404.php';
}

?>
