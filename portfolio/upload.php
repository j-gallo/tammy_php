<?php

//links to the necessary functions
  require('../model/database.php');
  require('../model/portfolio_db.php');

  /*if the image key is empty, no image was supplied in the portfolio
    upload form. display an error and exit. */
  if($_FILES['image']['name'] == ''){ 
    header('Location:./index.php?error=no_image');
  }
  
  /*these are the paths to the directories in which the image and thumbnail
    are to be stored.*/
  $image_path = "../images/portfolio/" . $_FILES['image']['name'];
  $thumb_path = "../images/portfolio/thumbs/" . $_FILES['image']['name'];

  /*get the image info from the uploaded file.*/
  $image_size = getimagesize($_FILES['image']['tmp_name']);

  /*the pre-defined size of the thumbnail*/
  $thumb_dim = array(170, 150);

  /*creates a blank image based on the type of image uploaded. */
  switch ($image_size[2]) {
    case IMAGETYPE_JPEG:
      $image_from = 'imagecreatefromjpeg';
      $image_to = 'imagejpeg';
      break;
    case IMAGETYPE_GIF:
      $image_from = 'imagecreatefromgif';
      $image_to = 'imagegif';
      break;
    case IMAGETYPE_PNG:
      $image_from = 'imagecreatefrompng';
      $image_to = 'imagepng';
      break;
    default:
      header('Location:./index.php?error=not_image');
      exit;
  }

  move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

  /*determines the aspect ratio of the source image and the thumbnail.*/
  $image_aspect = round($image_size[0]/$image_size[1], 1);
  $thumb_aspect = round($thumb_dim[0]/$thumb_dim[1], 1);

  /*if the aspect ratios of the thumbnail and supplied image are different,
    the proper resize of the source is determined along with the proper place
    on the source to start drawing the thumbnail. This creates a non-distorted
    cropped thumbnail.*/
  if($image_aspect < $thumb_aspect){
    $new_size = array($thumb_dim[0], ($thumb_dim[0]/$image_size[0]) * $image_size[1]);
    $image_pos = array(0, ($new_size[1] - $thumb_dim[1]) * ($image_size[1] / $new_size[1]) / 2);
  }elseif($image_aspect > $thumb_aspect){
    $new_size = array(($thumb_dim[1]/$image_size[1]) * $image_size[0], $thumb_dim[1]);
    $image_pos = array(($new_size[0] - $thumb_dim[0]) * ($image_size[0] / $new_size[0]) / 2, 0);
  }else{
    $new_size = array($thumb_dim[0], $thumb_dim[1]);
    $image_pos = array(0, 0);
  }

  $image = $image_from($image_path);

  $thumb = imagecreatetruecolor($thumb_dim[0], $thumb_dim[1]);

  imagecopyresampled($thumb, $image, 0, 0, $image_pos[0], $image_pos[1], $new_size[0], $new_size[1], $image_size[0], $image_size[1]);

  $image_to($thumb, $thumb_path);

  imagedestroy($image);

  //if a url was supplied, destroy the large image
  if( $_POST['url'] !== '' ){
    unlink($image_path);
    $image_path = '';
  }

  add_portfolio($_POST['title'], $_POST['year'], $thumb_path, $image_path, $_POST['url']);

  header('Location:./index.php');

?>
  
