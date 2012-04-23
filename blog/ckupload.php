<?php

  /*Save image uploaded from WYSIWYG to destination folder. Then return image path to
    the WYSIWYG for display*/
  
  $image_path = "../images/blog/".time().'_'.$_FILES['upload']['name'];
  $return_path = "/tammy/images/blog/".time().'_'.$_FILES['upload']['name'];

  if(($_FILES['upload']['type'] != 'image/jpeg') AND ($_FILES['upload']['type'] != 'image/png') AND 
      ($_FILES['upload']['type'] != 'image/gif') AND ($_FILES['upload']['type'] != 'image/pjpeg')){
      echo 'File must be a JPEG, GIF, or PNG image.';
  }else{
    move_uploaded_file($_FILES['upload']['tmp_name'], $image_path);
    $funcNum = $_GET['CKEditorFuncNum'];
  }
  
  echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$return_path');</script>";

?>
