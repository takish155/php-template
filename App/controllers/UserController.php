<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;


class UserController
{
  protected $db;

  public function __construct()
  {
    $config = require basePath("config/db.php");
    $this->db = new Database($config);
  }

  /**
   * Shows the login page
   * 
   * @return void
   */
  public function login()
  {
    loadView("users/login");
  }

  /**
   * Shows the registration page
   * 
   * @return void
   */
  public function create()
  {
    loadView("users/create");
  }

  /**
   * Stores user in the database
   * 
   * @return void
   */

  public function store()
  {
    $name = htmlspecialchars($_POST["name"] ?? "");
    $email = htmlspecialchars($_POST["email"] ?? "");
    $city = htmlspecialchars($_POST["city"] ?? "");
    $prefecture = htmlspecialchars($_POST["prefecture"] ?? "");
    $password = htmlspecialchars($_POST["password"] ?? "");
    $passwordConfirmation = htmlspecialchars($_POST["password_confirmation"] ?? "");

    $errors = [];

    // Validation
    if (!Validation::email($email)) {
      $errors["email"] = "Please enter a valid email.";
    }

    if (!Validation::string($name, 2, 50)) {
      $errors["name"] = "Name must be between 2 and 50 characters!";
    }

    if (!Validation::string($password, 6, 50)) {
      $errors["password"] = "Password must be between 2 and 50 characters!";
    }

    if (!Validation::match($password, $passwordConfirmation)) {
      $errors["password_confirmation"] = "Password do not match!";
    }


    if (!empty($errors)) {
      loadView("users/create", [
        "errors" => $errors,
        "user" => [
          "name" => $name,
          "email" => $email,
          "city" => $city,
          "prefecture" => $prefecture,
          "password" => $password,
          "password_confirmation" => $passwordConfirmation
        ]
      ]);

      return;
    }

    // Checks the DB for same email
    $params = ["email" => $email];
    $user = $this->db->query("SELECT * FROM users WHERE email = :email", $params)->fetch();

    if ($user) {
      $errors["email"] = "That email already exists!";
      loadView("users/create", [
        "errors" => $errors,
        "user" => [
          "name" => $name,
          "email" => $email,
          "city" => $city,
          "prefecture" => $prefecture,
          "password" => $password,
          "password_confirmation" => $passwordConfirmation
        ]
      ]);

      return;
    }

    $params = [
      "name" => $name,
      "email" => $email,
      "city" => $city,
      "prefecture" => $prefecture,
      "password" => password_hash($password, PASSWORD_DEFAULT),
    ];

    $this->db->query("
    INSERT INTO users (name, email, city, prefecture, password) 
    VALUES (:name, :email, :city, :prefecture, :password)
    ", $params)->fetch();

    // Get user id
    $userId = $this->db->conn->lastInsertId();

    Session::authenticate($userId, $name, $email, $city, $prefecture);
  }

  /**
   * Logout a user and kill session
   * 
   * @return void
   */

  public function logout()
  {
    Session::clearAll();

    $params = session_get_cookie_params();
    setcookie("PHPSESSID", "", time() - 864, $params["path"]);

    redirect("/");
  }

  /**
   * Authenticate a user with email and password
   * 
   * @return void
   */
  public function authenticate()
  {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $errors = [];

    if (!Validation::email($email)) {
      $errors["email"] = "Please enter a valid email!";
    }

    if (!Validation::string($password, 6, 50)) {
      $errors["password"] = "Password must be at least 6 characters!";
    }

    if (!empty($errors)) {
      loadView("users/login", [
        "errors" => $errors,
        "user" => [
          "email" => $email,
          "password" => $password,
        ],
      ]);
      return;
    }

    // Check for email
    $user = $this->db->query("SELECT * FROM users WHERE email = :email", [
      "email" => $email,
    ])->fetch();

    if (!$user) {
      $errors["email"] = "Incorrect credentials";

      loadView("users/login", [
        "errors" => $errors,
        "user" => [
          "email" => $email,
          "password" => $password,
        ],
      ]);
      return;
    }

    // Check if password is correct
    if (!password_verify($password, $user->password)) {
      $errors["email"] = "Incorrect credentials";

      loadView("users/login", [
        "errors" => $errors,
        "user" => [
          "email" => $email,
          "password" => $password,
        ],
      ]);
      return;
    }

    Session::authenticate($user->userId, $user->name, $user->email, $user->city, $user->prefecture);
  }
}
