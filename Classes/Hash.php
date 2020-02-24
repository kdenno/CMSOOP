
<?php
class Hash
{
  public static function generate($string, $salt = '')
  {
    return hash('sha256', $string . $salt);
  }
  public static function salt($length) {
    return openssl_random_pseudo_bytes($length);

  }
}
?>