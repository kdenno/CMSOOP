<?php
class Session
{
  public static function put($name, $value)
  {
    // create session and return it
    return $_SESSION[$name] = $value;
  }
  public static function get($name)
  {
    return $_SESSION[$name];
  }
  public static function delete($name)
  {
    if(self::exists($name)){
      unset($_SESSION[$name]);

    }
  }
  public static function exists($name)
  {
    return (isset($_SESSION[$name])) ? true : false;
  }
}
