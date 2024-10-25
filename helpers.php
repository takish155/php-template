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
 * @return void
 */

function loadView($name)
{
  $path = basePath("views/$name.view.php");

  if (file_exists($path)) {
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
  $path = basePath("views/partials/$partialName.php");

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
