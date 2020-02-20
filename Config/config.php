<?php
// $db['db_host'] = "localhost";
// $db['db_pass'] = "";
// $db['db_user'] = "root";
// $db['db_name'] = "cmsopp";
// foreach ($db as $key => $value) {
//   define(strtoupper($key), $value);
// }
if(!isset($_SESSION)) {
  session_start();
}

$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'pass' => '',
    'dbname' => 'cmsopp'
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  'session' => array(
    'session_name' => 'user'
  )
);
spl_autoload_register(function ($class) {
  require_once 'Classes/' . $class . '.php';
});
require_once 'Functions/sanitize.php';
require_once 'Functions/queryInit.php';

