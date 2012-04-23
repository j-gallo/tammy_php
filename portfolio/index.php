<?php
/*this file is the index for the portfolio page*/

/*load the necessary functions*/
  require('../model/database.php');
  require('../model/portfolio_db.php');
  
  /*if action key of get array is 'delete', call the function to delete
    the portfolio entry. Then redirect back to the index so the data does
    not show up in the url*/
  if($_GET['action'] == 'delete'){
    delete_portfolio($_GET['id']);
    header('Location:./');
  }

  //display the header
  require('../layout/header.php');

  /*if the error key of the get array is set to 'not_image',
    something other than an image was sumbitted in the portfolio
    upload form.*/
  if($_GET['error'] == 'not_image'){
    echo "Image must be a JPEG, PNG, or GIF <br />";
  }

  /*if the error key of get array reads 'no_image', no image was supplied
    in the portfolio upload form.*/
  if($_GET['error'] == 'no_image'){
    echo "Please supply an image <br />";
  }

  /*if the user is logged in, show the portfolio upload form.*/
  if($_SESSION['logged_in'] === true){
    require('image_upload_form.php');
  }

  //include file to show portfolio entries
  include('./show.php');

  //includes footer file
  include('../layout/footer.php');
?>
