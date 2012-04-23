<?php

  //include necessary functions
  require('../model/database.php');
  require('../model/admin_db.php');

  //start session to allow for 'logged in' status
  session_start();

  //if action is 'new', create a new admin with POST attributes.
  //display errors if form not filled out correctly.
  if($_POST['action'] == 'new'){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $check = create_admin($name, $password);
    if($check == 'error'){
      echo 'A new admin must have a username and password';
    }
  }

  //if action is 'login', activate 'logged in' status 
  //if login info is verified and redirect to home page. 
  //else, display error
  if ($_POST['action'] == 'login'){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $valid = login($name, $password);
    if ($valid){
      $_SESSION['logged_in'] = true;
      header('Location: .');
    }
    else{
      echo 'bad username or password!';
    } 
  }

  //if action is 'logout', deactivate 'logged in' status
  if ($_GET['action'] == 'logout'){
    $_SESSION = array();
    session_destroy();
    header('Location: ../');
  }

  //display header
  require('../layout/header.php');

  //display login form
  require('login.php');

  //display footer
  require('../layout/footer.php');

?>
