<?php
require "../helpers.php";
require basePath("Router.php");


// Init Router
$router = new Router();


// Get Routes
require basePath("routes.php");

// Get URI and HTTP Method
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

// Route the request
$router->route($uri, $method);
