<?php

  //load necessary functions
  require('../model/database.php');
  require('../model/tag_db.php');
  require('../model/blog_db.php');
  
  /*if the action key of the post array is set,
    perform an action based on its value.*/
  if(isset($_POST['action'])){
    /*if action key is set to 'create_blog',
      load the create_blog function*/
    switch($_POST['action']){
      case 'create_blog': 
        $title = $_POST['title'];
        $body = $_POST['content'];
        add_blog($title,$body);
        break;

        /*if action key is set to 'edit_blog',
         load the edit blog function*/
        case 'edit_blog':
        $title = $_POST['title'];
        $body = $_POST['content'];
        $id = $_POST['id'];
        edit_blog($title, $body, $id);
        break;
      case 'add_tag':
          $title = $_POST['title'];
          $blog_id = $_POST['id'];
          add_tag($blog_id, $title);
      break;
    }
  }

  //get the info for all of the blogs
  $blog_info = all_blogs(); 
  $blogs = $blog_info[0];
  $pages = $blog_info[1];

  //load the header
  require('../layout/header.php');

?>

  <?php require('./show.php'); ?>

  <?php require('./pagination.php'); ?>

<?php require('../layout/footer.php') ?>
