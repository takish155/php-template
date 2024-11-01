<?php

namespace Framework;

class Validation
{
  /**
   * Validates string
   *
   * @param string $value
   * @param int $min
   * @param int $max
   * @return bool
   */
  public static function string($value, $min = 1, $max = INF)
  {
    $value = trim($value);
    $length = strlen($value);

    return $length >= $min && $length <= $max;
  }

  /**
   * Validates email
   * 
   * @param string $email
   * @return mixed
   */

  public static function email($value)
  {
    $value = trim($value);

    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  /**
   * Check if matches
   * 
   * @param string $value1
   * @param string $value2
   * @return bool
   */

  public static function match($value1, $value2)
  {
    $value1 = trim($value1);
    $value2 = trim($value2);

    return $value1 === $value2;
  }
}
