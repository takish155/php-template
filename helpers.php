<?php

/**
 * Get the base path 
 * 
 * @param string $path
 * @return string
 */

function basePath($path = "")
{
  return __DIR__ . "/" . $path;
}

/**
 * Load the view
 * 
 * @param string $name
 * @param array $props = []
 * @return void
 */

function loadView($name, $props = [])
{
  $path = basePath("App/views/$name.view.php");

  if (file_exists($path)) {
    // Makes the props available in the view
    extract($props);
    require $path;
  } else {
    echo "Path of $name doesn't exist!";
  }
}

/**
 * Load the partials
 * 
 * @param string $partialName
 * @return void
 */

function loadPartials($partialName)
{
  $path = basePath("App/views/partials/$partialName.php");

  if (file_exists($path)) {
    require $path;
  } else {
    echo "Path of $partialName doesn't exist!";
  }
}

/**
 * Inspect the value
 * 
 * @param mixed $value
 * @return void
 */

function inspect($value)
{
  echo "<pre>";
  var_dump($value);
  echo "</pre>";
};

/**
 * Inspect the value and die
 * 
 * @param mixed $value
 * @return void
 */

function inspectAndDie($value)
{
  echo "<pre>";
  die(var_dump($value));
  echo "</pre>";
};

/**
 * Formats money into 1,000,000
 * 
 * @param string $money
 * @return string
 */

function formatMoney($money)
{
  return "￥" . number_format(floatval($money));
}
