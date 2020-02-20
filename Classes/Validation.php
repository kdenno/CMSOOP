<?php
class Validation
{
  private $_errors = array(),
    $_pass = false;
  static $queries;
  public function __construct()
  {
    $connection = DB::getDb();
    self::$queries = new Queries($connection);
  }


  public function check($source, $rules = array())
  {
    foreach ($rules as $field => $items) {
      foreach ($items as $key => $value) {
        $posted_value = trim($source[$field]);
        if ($key === 'required' && empty($posted_value)) {
          $this->addErrors("{$field} is required");
        } else if (!empty($posted_value)) {
          switch ($key) {
            case 'min':
              if (strlen($posted_value) < $value) {
                $this->addErrors("{$field} should be atleast {$value} characters long");
              }
              break;
            case 'max':
              if (strlen($posted_value) > $value) {
                $this->addErrors("{$field} should not have more than {$value} characters");
              }
              break;
            case 'matches':
              if ($source[$value] !== $source[$field]) {
                $this->addErrors("Value in {$value} does not equal $field");
              }
              break;
            case 'unique':
              $check = self::$queries->get($value, array($field, '=', $posted_value));
              if ($check->count()) {
                $this->addErrors("{$posted_value} already exists");
              }
              break;
          }
        }
      }
    }
    if (empty($this->_errors)) {
      $this->_pass = true;
    }
    return $this;
  }
  private function addErrors($error)
  {
    $this->_errors[] = $error;
  }
  public function errors()
  {
    return $this->_errors;
  }
  public function pass()
  {
    return $this->_pass;
  }
}
