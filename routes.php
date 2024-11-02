<?php


// return [
//   "/" => "controllers/home.php",
//   "/listings" => "controllers/listings/index.php",
//   "/listings/create" => "controllers/listings/create.php",
//   "404" => "controllers/error/404.php"
// ];



$router->get("/", "HomeController@index");

$router->get("/listings", "ListingController@index");
$router->get("/listings/create", "ListingController@create");
$router->get("/listings/{id}", "ListingController@show");
$router->put("/listings/{id}", "ListingController@update");
$router->get("/listings/edit/{id}", "ListingController@edit");

$router->post("/listings", "ListingController@store");
$router->delete("/listings/{id}", "ListingController@destroy");

$router->get("/auth/register", "UserController@create");
$router->get("/auth/login", "UserController@login");

$router->post("/auth/register", "UserController@store");


// $router->get("/listings/create", "controllers/listings/create.php");
// $router->get("/listing", "controllers/listings/show.php");
