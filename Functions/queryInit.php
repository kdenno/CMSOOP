<?php
function InitQueries()
{
  $connection = DB::getDb();
  $queries = new Queries($connection);
  return $view = new ViewController($queries);
}
