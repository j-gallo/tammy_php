<?php
  //display header
  require('../layout/header.php');

  //if a blog was submitted with a blank form field, throw an error.
  if($_GET['error'] == 'blank'){
    echo "Can't leave title or content blank";
  }

  //include blog creation form
  require('./form.php');
?>

