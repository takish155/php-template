<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

class Router
{
  protected $routes = [];

  /**
   * Add new route
   *
   * @param string $method
   * @param string $uri
   * @param string $action
   * @return void
   */
  private function registerRoute($method, $uri, $action, $middleware = [])
  {
    list($controller, $controllerMethod) = explode("@", $action);

    array_push($this->routes, [
      "method" => $method,
      "uri" => $uri,
      "controller" => $controller,
      "controllerMethod" => $controllerMethod,
      "middleware" => $middleware,
    ]);
  }

  /**
   * Add a GET routes
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */

  public function get($uri, $controller, $middleware = [])
  {
    $this->registerRoute("GET", $uri, $controller, $middleware);
  }

  /**
   * Add a POST routes
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */

  public function post($uri, $controller, $middleware = [])
  {
    $this->registerRoute("POST", $uri, $controller, $middleware);
  }

  /**
   * Add a PUT routes
   * @param string $uri
   * @param string $controller
   * @param string $middleware
   * @return void
   */

  public function put($uri, $controller, $middleware = [])
  {
    $this->registerRoute("PUT", $uri, $controller, $middleware);
  }

  /**
   * Add a DELETE routes
   * @param string $uri
   * @param string $controller
   * @return void
   */

  public function delete($uri, $controller, $middleware  = [])
  {
    $this->registerRoute("DELETE", $uri, $controller, $middleware);
  }

  public function route($uri)
  {
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($requestMethod === "POST" && isset($_POST["_method"])) {
      $requestMethod = strtoupper($_POST["_method"]);
    }



    foreach ($this->routes as $route) {
      // Split the current URI into segments
      $uriSegment = explode("/", trim($uri, "/"));


      // Split every URI into segments
      $routeSegments = explode("/", trim($route["uri"], "/"));

      $match = true;

      if (count($uriSegment) === count($routeSegments) && strtoupper($route['method'] === $requestMethod)) {
        $params = [];
        $match = true;

        // Checks if there are same route length
        for ($i = 0; $i < count($routeSegments); $i++) {
          // Checks for match in the URL and parameter
          if ($routeSegments[$i] !== $uriSegment[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
            $match = false;
            break;
          }

          // Checks for params and adds to the $params
          if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
            $params[$matches[1]] = $uriSegment[$i];
          }
        }

        if ($match) {
          foreach ($route["middleware"] as $middleware) {
            (new Authorize())->handle($middleware);
          }

          // Extract controller and controller method
          $controller = "App\\Controllers\\" . $route["controller"];
          $controllerMethod = $route["controllerMethod"];

          // Init the controller and call method
          $controllerInstance = new $controller();
          $controllerInstance->$controllerMethod($params);
          return;
        };
      }



      // if ($route["uri"] === $uri && $route["method"] === $method) {
      //   // Extract controller and controller method
      //   $controller = "App\\Controllers\\" . $route["controller"];
      //   $controllerMethod = $route["controllerMethod"];

      //   // Init the controller and call method
      //   $controllerInstance = new $controller();
      //   $controllerInstance->$controllerMethod();
      //   return;
      // }
    }

    ErrorController::notFound("Page not found, try checking your URL");
  }
}
