<?php

require basePath("Database.php");
$config = require basePath("config/db.php");
$db = new Database($config);

$id = $_GET["id"] ?? "";


$info = $db->query("SELECT * FROM listings WHERE id = :id", ["id" => $id])->fetch();


loadView("listings/show", [
  "info" => $info
]);
