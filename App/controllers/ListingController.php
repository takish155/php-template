<?php

namespace App\Controllers;

use Framework\Database;

class ListingController
{
  protected $db;

  public function __construct()
  {
    $config = require basePath("config/db.php");
    $this->db = new Database($config);
  }

  public function index()
  {
    $listings = $this->db->query("SELECT * FROM listings")->fetchAll();
    loadView("listings/index", ["listings" => $listings]);
  }

  public function show($params)
  {
    $id = htmlspecialchars($params["id"]);


    $info = $this->db->query("SELECT * FROM listings WHERE id = :id", ["id" => $id])->fetch();

    if (!$info) {
      ErrorController::notFound("Listing not found!");
      return;
    }

    loadView("listings/show", [
      "info" => $info,
    ]);
  }

  public function create()
  {
    loadView("listings/create");
  }
}
