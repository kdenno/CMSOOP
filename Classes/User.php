<?php
class User
{
  private $_db, $_queries, $_userdata, $_sessionName;
  public $isLoggedIn = false;
  public function __construct($user = null)
  {
    $this->_db = DB::getDb();
    $this->_queries = new Queries($this->_db);
    $this->_sessionName = Config::get('session/session_name');
    if (!$user) {
      if (Session::exists($this->_sessionName)) {
        $userid = Session::get($this->_sessionName);
        if ($this->find($userid)) {
          $this->isLoggedIn = true;
        } else {
        }
      }
    } else {
      // user id is defined, find the user
      $this->find($user);
    }
  }
  public function create($fields = array())
  {
    // $this->_queries = new Queries($this->_db);
    if (!$this->_queries->Insert('users', $fields)) {
      throw new Exception('There was a problem creating Account');
    }
  }
  public function find($user = null)
  {
    if ($user) {
      $field = (is_numeric($user)) ? 'id' : 'username';
      $data = $this->_queries->get('users', array($field, '=', $user));
      if ($data->count()) {
        $this->_userdata = $data->first();
        return true;
      }
    }
    return false;
  }
  public function login($username = null, $password = null)
  {
    $user = $this->find($username);
    if ($user) {
      // check passwords 
      if ($this->userdata()->password === Hash::generate($password, $this->userdata()->salt)) {
        // log the user in 
        Session::put($this->_sessionName, $this->userdata()->id);
        return true;
      }
    }
    return false;
  }
  public function userdata()
  {
    return $this->_userdata;
  }
  public function isLoggedIn()
  {
    return $this->isLoggedIn;
  }
}
