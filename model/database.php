<?php
  /*This function connects to the database. If any error occurs,
    control is passed to database_error.php */
  $dsn = 'mysql:host=localhost;dbname=crudea5_jgallo';
  $username = 'crudea5_jgallo';
  $password = 'jj8687';

  try{
      $db = new PDO($dsn,$username,$password);
  } catch (PDOException $e) {
      $error_message = $e->getMessage();
      include('database_error.php');
      exit();
  }
?>
