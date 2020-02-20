<?php
class AppController{
  public $view;
  public function init() {
  
    // initialize db connection
    $connection = DB::getDb();
    $queries = new Queries($connection);
    $this->view = new ViewController($queries);
    // bring queries object to the view context
    // $this->view->setViewObj('queries', $queries);
    // render views
   $this->view->render('default');

  }
}

?>