<?php
require "../helpers.php";
// require loadView("home");



$uri = $_SERVER["REQUEST_URI"];

require basePath("router.php");
