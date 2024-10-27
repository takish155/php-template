<?php

namespace Framework;

use PDO;

class Database
{
  public $conn;

  /**
   * Constructor for database class
   * 
   * @param array $config
   */

  public function __construct($config)
  {
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];

    try {
      $this->conn = new PDO($dsn, $config["username"], $config["password"], $options);
    } catch (PDOException $err) {
      throw new Exception("Database connection failed: {$err->getMessage()}");
    }
  }

  /**
   * Query the database
   * 
   * @param string $query
   * @param array $params = []
   * 
   * @return PDOStatement
   * @throws PDOExcepetion
   * 
   */
  public function query($query, $params = [])
  {
    try {
      $sth = $this->conn->prepare($query);
      $sth->execute($params);
      return $sth;
    } catch (PDOException $err) {
      throw new Exception("Query failed to execute: {$err->getMessage()}");
    }
  }
}
