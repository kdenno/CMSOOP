<?php
require 'Config/config.php';
if (Input::exists()) {
  $validate = new Validation();
  $validate->check($_POST, array(
    'username' => array(
      'required' => true,
      'min' => 2,
      'max' => 20,
      'unique' => 'users'
    ),
    'password' => array(
      'required' => true,
      'min' => 6

    ),
    'password_again' => array(
      'required' => true,
      'matches' => 'password'
    ),
    'name' => array(
      'required' => true,
      'min' => 2,
      'max' => 50
    )
  ));
  if($validate->pass()) {
    // register user
    echo 'passed';

  }else {
    // output errors
    var_dump($validate->errors());
  }
}

?>
<form action="" method="POST">
<div>
    <label for="name">Name</label>
    <input type="text" name="name" id="name" autocomplete="off" value ="<?php echo Input::get('name'); ?>">
  </div>
  <div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" autocomplete="off" value="<?php echo Input::get('username'); ?>">
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" autocomplete="off">
  </div>
  <div>
    <label for="password_again">Enter Your password again</label>
    <input type="password" name="password_again" id="password_again" autocomplete="off">
  </div>


  <div>
    <input type="submit" value="Register">
  </div>


</form>