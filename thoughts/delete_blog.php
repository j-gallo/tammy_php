<?php

  /*this file grabs the blog id from the url and
    then submits that id to the delete_blog function.
    it then redirects to the controller. */

  require('../model/database.php');
  require('../model/blog_db.php');

  delete_blog($_GET['id']);

  header('Location:./');

?>
