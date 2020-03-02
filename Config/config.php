<?php
// $db['db_host'] = "localhost";
// $db['db_pass'] = "";
// $db['db_user'] = "root";
// $db['db_name'] = "cmsopp";
// foreach ($db as $key => $value) {
//   define(strtoupper($key), $value);
// }
if (!isset($_SESSION)) {
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
    'session_name' => 'user',
    'token_name' => 'token'
  )
);
spl_autoload_register(function ($class) {
  require_once 'Classes/' . $class . '.php';
});
require_once 'Functions/sanitize.php';
require_once 'Functions/queryInit.php';
// check if user asked to be remembered and is not logged in so we can log them in
if (Cookie::exists(Config::get('remember/cookie_name') && !Session::get(Config::get('session/session_name')))) {
  $queryObj = new Queries(DB::getDb());
  $hashCheck = $queryObj->get('users_sessions', array('hash', '=', Cookie::get(Config::get('remember/cookie_name'))));
  if ($hashCheck->count()) {
    // hash matches, log user in
    $user = new User($hashCheck->first()->user_id);
    $user->login();
  }
}
