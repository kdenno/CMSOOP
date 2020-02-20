<?php
class ViewController {
  public $queries;
  public function __construct($queryObj)
  {
    $this->queries = $queryObj;
  }
  // public function setViewObj($param, $value) {
  //   $this->$param = $value;

  // }
  public function render($param) {
    require VIEWS.'users/'.$param.'.php';
  }
}
?>