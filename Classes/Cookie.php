<?php
class Cookie
{
  public static function exists($name)
  {
    return (isset($_COOKIE[$name])) ? true : false;
  }
  public static function get($name)
  {
    return $_COOKIE[$name];
  }
  public static function put($name, $value, $expiry)
  {
    if (setcookie($name, $value, time() + $expiry, '/')) {
      return true;
    }
    return false;
  }
  public static  function delete($name)
  {
    // cookies are not like sessions. to delete them you dont just unset them, you set them to a -ve number;
    self::put($name, '', time() - 1);
  }
}
