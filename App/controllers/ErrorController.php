<?php

namespace App\Controllers;



class ErrorController
{
  /**
   * Shows a 404 not found page
   *
   * @param string $message
   * @return void
   */

  public static function notFound($message = "Resource not found")
  {
    http_response_code(404);

    return loadView("error", [
      "status" => 404,
      "message" => $message
    ]);
  }

  /**
   * Shows a 403 unauthorized page
   * 
   * @param string $message
   * @return void
   */

  public static function unauthorized($message = "You are not allowed to view this page")
  {
    http_response_code(401);

    return loadView("error", [
      "status" => 401,
      "message" => $message,
    ]);
  }
}
