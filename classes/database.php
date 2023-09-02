<?php
class database
{
  private $servername = 'localhost';
  private $username = 'root';
  private $password = '';
  private $dbname = 'etrack';
  public $last_id;
  public $last_ballot;
  public $result = array();
  public $mysqli = '';

  public function __construct()
  {
    $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
  }



  public function pullLastRowModified($table, $column)
  {
    $sql = "SELECT * FROM $table WHERE id = $this->last_id";
    $result = $this->mysqli->query($sql);

    $row = $result->fetch_assoc();
    return $row[$column];
  }

  public function isExisted($table, $para = array())
  {
    $args = array();
    $where = '';

    foreach ($para as $key => $value) {

      $args[] = "$key = '$value'";

      $where = implode(' && ', $args);
    }

    $select = " SELECT * FROM $table WHERE $where";
    $check = $this->mysqli->query($select);

    // gets the id of the  selected row
    while ($row = $check->fetch_assoc()) {
      $this->last_ballot = $this->last_id = $row['id'];
    }

    if (!$check) {
      die('Invalid query: ' . $this->mysqli->error);
    } else if (mysqli_num_rows($check) > 0) {
      // there is a data in the table
      return true;
    } else {
      return false;
    }
  }

  public function insertData($table, $para = array())
  {
    $table_columns = implode(',', array_keys($para));
    $table_value = implode("','", $para);

    $insert = "INSERT INTO $table($table_columns)  VALUES('$table_value')";

    if ($this->mysqli->query($insert) === TRUE) {
      $this->last_id = $this->mysqli->insert_id;
    } else {
      die('Invalid query: ' . $this->mysqli->error);
    }
  }

  // public function updateData($table, $para = array(), $column, $value_id)
  // {
  //   $args = array();

  //   foreach ($para as $key => $value) {
  //     $args[] = "$key = '$value'";
  //   }

  //   $sql = "UPDATE  $table SET " . implode(',', $args);

  //   if(is_int($value)) {
  //     $sql .= " WHERE $column = $value_id";
  //   }else{
  //     $sql .= " WHERE $column = '$value_id'";

  //   }
  //   $update = $this->mysqli->query($sql);
  //   $this->last_id = $value_id;


  // }

  public function insertImage($name, $table, $column, $path)
  {
    $img_name = $_FILES["$name"]['name'];
    $img_size = $_FILES["$name"]['size'];
    $tmp_name = $_FILES["$name"]['tmp_name'];
    $error = $_FILES["$name"]['error'];



    if ($error === 0) {
      $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_ex_lc = strtolower($img_ex);

      $allowed_exs = array('jpg', 'jpeg', 'png');

      if (in_array($img_ex_lc, $allowed_exs)) {
        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;

        $img_upload_path = $path . $new_img_name;

        move_uploaded_file($tmp_name, $img_upload_path);

        $update = "UPDATE $table SET $column = '$new_img_name' WHERE id = $this->last_id";
        return $this->mysqli->query($update);
      }else {
        return false;
      }

      
    }
  }

  public function updateImage($name, $table, $column, $path)
  {
    $img_name = $_FILES["$name"]['name'];
    $img_size = $_FILES["$name"]['size'];
    $tmp_name = $_FILES["$name"]['tmp_name'];
    $error = $_FILES["$name"]['error'];



    if ($error === 0) {
      $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_ex_lc = strtolower($img_ex);

      $allowed_exs = array('jpg', 'jpeg', 'png');

      if (in_array($img_ex_lc, $allowed_exs)) {

        $result = $this->select($table, '*', ['id' => $this->last_id]);
        $row = mysqli_fetch_assoc($result);
        echo $path . $row["$column"];
        unlink("$path" . $row["$column"]);
        

        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;

        $img_upload_path = "$path" . $new_img_name;

        move_uploaded_file($tmp_name, $img_upload_path);

        $update = "UPDATE $table SET $column = '$new_img_name' WHERE id = $this->last_id";
        return $this->mysqli->query($update);
      }else {
        return false;
      }
    }
  }

  public function deleteImage ($photo_url, $path) {
    if(isset($_GET["$photo_url"])){
      unlink($path . $_GET["$photo_url"]);
    }
  }

  // public function select($table, $rows = '*', $column = null, $value = null)
  // {
  //   if ($column != null && $value != null) {
  //     if (is_int($value)) {
  //     $sql = "SELECT $rows FROM $table WHERE $column = $value";
  //     } else {
  //       $sql = "SELECT $rows FROM $table WHERE $column = '$value'";
  //     }
  //   } else {
  //     $sql = "SELECT $rows FROM $table";
  //   }

  //   return $this->mysqli->query($sql);
  // }


  public function delete($table, $id)
  {

    $sql = "DELETE FROM $table";
    $sql .= " WHERE $id ";
    return $this->mysqli->query($sql);
  }

  public function __destruct()
  {
    $this->mysqli->close();
  }


  public function updateData($table, $para = array(), $where = array(), $operator = 'AND')
  {
    $args = array();

    foreach ($para as $key => $value) {
      $args[] = "$key = '$value'";
    }

    $where_args = array();
    foreach ($where as $key => $value) {
      $where_args[] = "$key = '$value'";
    }

    $sql = "UPDATE  $table SET " . implode(', ', $args);

    if (!empty($where)) {
      $sql .= " WHERE " . implode(" $operator ", $where_args);
    }

    $this->last_id = $value;
    return $this->mysqli->query($sql);
  }

  public function advanceUpdateData($table, $para = array(), $where = '')
  {
    $args = array();

    foreach ($para as $key => $value) {
      $args[] = "$key = '$value'";
    }

    $sql = "UPDATE  $table SET " . implode(', ', $args);

    if ($where != '') {
      $sql .= " WHERE $where";
    }

    $this->last_id = $value;
    return $this->mysqli->query($sql);
  }



  public function incrementData($table, $column, $where = array(), $operator = 'AND') {

    $where_args = array();
    foreach($where as $key => $value) {
      $where_args[] = "$key = $value";
      $this->last_id = $value;
    }

    $sql = "UPDATE $table SET $column = $column + 1";

    if (!empty($where)) {
      $sql .= " WHERE " . implode(" $operator ", $where_args);
    }
    
    return $this->mysqli->query($sql);

  }

  public function select($table, $rows = '*', $where = array(), $operator = 'AND')
  {
    if (empty($where)) {
      $sql = "SELECT $rows FROM $table";
      return $this->mysqli->query($sql);
    }

    $args = array();

    foreach ($where as $key => $value) {
      if (is_int($value)) {
        $args[] = "$key = $value";
      } else {
        $args[] = "$key = '$value'";
      }
    }

    $sql = "SELECT $rows FROM $table WHERE " . implode(" $operator ", $args);
    return $this->mysqli->query($sql);
  }

  public function selectDistinct($table, $rows = '*', $where = array(), $operator = 'AND')
  {
    if (empty($where)) {
      $sql = "SELECT DISTINCT $rows FROM $table";
      return $this->mysqli->query($sql);
    }

    $args = array();

    foreach ($where as $key => $value) {
      if (is_int($value)) {
        $args[] = "$key = $value";
      } else {
        $args[] = "$key = '$value'";
      }
    }

    $sql = "SELECT DISTINCT $rows FROM $table WHERE " . implode(" $operator ", $args);
    return $this->mysqli->query($sql);
  }


  public function advanceSelect($table, $rows = '*', $where = '')
  {
    if ($where == '') {
      $sql = "SELECT $rows FROM $table";
      return $this->mysqli->query($sql);
    } else if($where != '') {
      $sql = "SELECT $rows FROM $table WHERE $where";
      return $this->mysqli->query($sql);
    }
  }
}
