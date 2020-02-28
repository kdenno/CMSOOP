<?php
require_once 'Config/config.php';
if (Input::exists()) {
  if (Token::check(Input::get('token'))) {
    $validate = new Validation();
    $validation = $validate->check(
      array(
        'username' => array('required' => true),
        'password' => array('required' => true)
      )
    );
    if ($validation->pass()) {
      // log user in
      $user = new User();
      $login = $user->login(Input::get('username'), Input::get('password'));
      if ($login) {
        echo 'success';
      } else {
        echo '<p>Sorry Login Failed. </p>';
      }
    } else {
      foreach ($validation->errors() as $error) {
        echo $error . '<br>';
      }
    }
  }
}
?>
<form action="" method="POST">
  <div>
    <label for="username">Username</label>
    <input type="text" name="username">
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" name="password">
  </div>
  <div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  </div>
  <div>
    <input type="submit" value="Log In">
  </div>


</form>