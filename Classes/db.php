<?php
require "Config/config.php";
class DB
{
  static $connection = null;
  public static function getDb()
  {
    if (!self::$connection) {
      // connect to database
      try {
        // return self::$connection = mysqli_connect(Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/pass'), Config::get('mysql/dbname'));
        self::$connection = new PDO('mysql:host='.Config::get('mysql/host').'; dbname='.Config::get('mysql/dbname'), Config::get('mysql/username'), Config::get('mysql/pass'));
      } catch (PDOException $e) {
        die("Failed to connect to database " . $e->getMessage());
      }
    }
      return self::$connection;
  
  }
}
