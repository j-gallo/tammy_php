<?php
  /*This function connects to the database. If any error occurs,
    control is passed to database_error.php */
  $dsn = 'mysql:host=localhost;dbname=crude';
  $username = ********;
  $password = ********;

  try{
      $db = new PDO($dsn,$username,$password);
  } catch (PDOException $e) {
      $error_message = $e->getMessage();
      include('database_error.php');
      exit();
  }
?>
