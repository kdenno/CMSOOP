<?php
class User {
  private $_db, $_queries;
  public function __construct($user=null)
  {
   $this->_db = DB::getDb();
  }
  public function create($fields = array()) {
    $this->_queries = new Queries($this->_db);
    if(!$this->_queries->Insert('users', $fields)) {
      throw new Exception('There was a problem creating Account');
    }
  }
}

?>