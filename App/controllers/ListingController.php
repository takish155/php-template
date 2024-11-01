<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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

  /**
   * Store the data in the database
   * 
   * @return void
   */
  public function store()
  {
    $allowedFields = [
      "title",
      "description",
      "salary",
      "tags",
      "company",
      "address",
      "city",
      "prefecture",
      "phone",
      "email",
      "requirements",
      "benefits"
    ];

    $requiredFields = [
      "title",
      "description",
      "email",
      "city",
      "prefecture"
    ];

    // Filters to only have allowed fields
    $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

    // Default value for userId (no session yet)
    $newListingData["userId"] = "1";

    // Sanitizes the data
    $newListingData = array_map("sanitize", $newListingData);

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
        $errors[$field] = ucfirst($field) . " is required!";
      }
    };

    if (!empty($errors)) {
      loadView(
        "listings/create",
        [
          "errors" => $errors,
          "listing" => $newListingData,
        ]
      );
      exit;
    }

    $fields = [];

    foreach ($newListingData as $field => $value) {
      $fields[] = $field;
    }

    $fields = implode(", ", $fields);

    $values = [];

    foreach ($newListingData as $field => $value) {
      if (!$value) {
        $newListingData[$field] = null;
      }
      $values[] = ":$field";
    }

    $values = implode(", ", $values);

    $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

    $this->db->query($query, $newListingData);

    $_SESSION["success_message"] = "Successfuly created a listing!";

    redirect("/listings");
  }

  /**
   * Deletes the listing
   *
   * @param array $params
   * @return void
   */
  public function destroy($params)
  {
    $listing = $this->db->query("SELECT * FROM listings where id = :id", $params)->fetch();

    if (!$listing) {
      ErrorController::notFound("Listing not found!");
      return;
    }

    $this->db->query("DELETE FROM listings where id = :id", $params);

    $_SESSION["success_message"] = "Listing successfully removed!";
    redirect("/listings");
  }

  /**
   * Show the listing edit form
   *
   * @param strubg $params
   * @return void
   */

  public function edit($params)
  {
    $id = htmlspecialchars($params["id"]);


    $info = $this->db->query("SELECT * FROM listings WHERE id = :id", ["id" => $id])->fetch();

    if (!$info) {
      ErrorController::notFound("Listing not found!");
      return;
    }


    loadView("listings/edit", [
      "info" => $info,
    ]);
  }

  /**
   * Update a listing
   * 
   * @param array $params
   * @return void
   */

  public function update($params)
  {
    $id = htmlspecialchars($params["id"]);


    $info = $this->db->query("SELECT * FROM listings WHERE id = :id", ["id" => $id])->fetch();

    if (!$info) {
      ErrorController::notFound("Listing not found!");
      return;
    }

    $allowedFields = [
      "title",
      "description",
      "salary",
      "tags",
      "company",
      "address",
      "city",
      "prefecture",
      "phone",
      "email",
      "requirements",
      "benefits"
    ];

    $updateValues = [];

    // Filters to only have allowed fields
    $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

    // Sanitizes the value
    $updateValues = array_map("sanitize", $updateValues);

    $requiredFields = [
      "title",
      "description",
      "email",
      "city",
      "prefecture"
    ];

    $errors = [];

    // Checks if theres error
    foreach ($requiredFields as $field) {
      if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
        $errors[$field] = ucfirst($field) . " is required!";
      }
    };

    // If error exist, load listing form back
    if (!empty($errors)) {
      loadView("listings/edit", [
        "info" => $info,
        "errors" => $errors,
      ]);
      exit;
    }

    $updateFields = [];

    // Prepares field for query
    foreach (array_keys($updateValues) as $field) {
      $updateFields[] = "{$field} = :{$field}";
    }

    $updateFields = implode(", ", $updateFields);


    $updateValues["id"] = $info->id;
    $updateQuery = "UPDATE listings SET $updateFields WHERE id = :id";

    $this->db->query($updateQuery, $updateValues)->fetch();

    // Adds flash message
    $_SESSION["success_message"] = "Successfuly updated the listing!";


    redirect("/listings/edit/$info->id");
  }
}
