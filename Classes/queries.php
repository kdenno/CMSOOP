<?php
class Queries
{
  public $_pdo,
    $error = false,
    $count,
    $results,
    $query;
  public function __construct($connection)
  {
    $this->_pdo = $connection;
  }

  public function query($sql, $params = array())
  {
    // reset the error 
    $this->error = false;
    $this->query = $this->_pdo->prepare($sql);
    if (count($params)) {
      $x = 1;
      foreach ($params as $param) {
        $this->query->bindValue($x, $param);
        $x++;
      }
      // execute the query
      if ($this->query->execute()) {
        $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
        $this->count = $this->query->rowCount();
      } else {
        $this->error = true;
      }
    }
    return $this;
  }


  private function action($action, $table, $where = array())
  {
    if (count($where) === 3) {
      $allowedOperators = array('=', '>', '<', '>=', '<=');
      $field = $where[0];
      $operator = $where[1];
      $value = $where[2];
      if (in_array($operator, $allowedOperators)) {
        $sql = " {$action} FROM {$table} WHERE {$field} {$operator} ? ";
        if (!$this->query($sql, array($value))->error()) {
          return $this;
        }
      }
    }
    return false;
  }
  public function get($table, $where)
  {
    return $this->action('SELECT *', $table, $where);
  }
  public function getAll($table)
  {
    // reset the error 
    $this->error = false;
    $query = "SELECT * FROM {$table}";
    $this->query = $this->_pdo->prepare($query);
    if ($this->query->execute()) {
      $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
      $this->count = $this->query->rowCount();
    } else {
      $this->error = true;
    };

    return $this;
  }
  public function Insert($table, $fields = array())
  {
    if (count($fields)) {
      $keys = array_keys($fields);
      $values = '';
      $x = 1;
      foreach ($fields as $field) {
        $values .= '?';
        if ($x < count($fields)) {
          $values .= ', ';
        }
        $x++;
      }
      $sql = "INSERT INTO {$table}(`" . implode('`, `', $keys) . "`) VALUES ({$values})";
      if (!$this->query($sql, $fields)->error()) {
        return true;
      }
      return false;
    }
  }
  public function Update($table, $id, $fields)
  {
    $set = '';
    $x = 1;
    if (count($fields)) {
      foreach ($fields as $field => $value) {
        $set .= "{$field}=?";
        if ($x < count($fields)) {
          $set .= ', ';
        }
        $x++;
      }
      $sql = "UPDATE {$table} SET {$set} WHERE id={$id}";
      if (!$this->query($sql, $fields)->error()) {
        return true;
      }

      return false;
    }
  }
  public function IncreaseComments($post_id)
  {
    $sql = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = ?";
    if (!$this->query($sql, array($post_id))->error()) {
      return true;
    }
    return false;
  }
  public function getResults()
  {
    return $this->results;
  }
  public function first()
  {
    return $this->getResults()[0];
  }
  public function delete($table, $where)
  {
    return $this->action('DELETE', $table, $where);
  }

  public function otherQueries($post_id)
  {
    $query = "SELECT * FROM comment WHERE comment_post_id = ? AND comment_status = 'approved' ORDER BY comment_id DESC";
    if (!$this->query($query, array($post_id))->error()) {
      return $this;
    }
  }

  public function error()
  {
    return $this->error;
  }
  public function count()
  {
    return $this->count;
  }
}
