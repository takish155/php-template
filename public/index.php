<?php
require __DIR__ . "/../vendor/autoload.php";
require "../helpers.php";

use Framework\Router;


// Auto loader (Loads all file in Framework if exist)
// spl_autoload_register(function ($class) {
//   $path = basePath("Framework/$class.php");
//   if (file_exists($path)) {
//     require $path;
//   }
// });

// Init Router
$router = new Router();

// Get Routes
require basePath("routes.php");

// Get URI and HTTP Method
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Route the request
$router->route($uri);
