<?php

  //include necessary functions
  require('./model/database.php'); 
  require('./model/blog_db.php'); 
  
  //Display the header
  require('./layout/header.php'); 

?>

  <!-- Grab the info from the latest blog and display it on the page -->
  <?php $blog=latest_blog(); ?>
  <h1> Disjointed Thoughts by: Tammy Portnoy </h1>
  <h1><?php echo $blog['title']; ?></h1>
  <h2><?php echo date('F, j, Y', strtotime($blog['created_at'])); ?></h2>
  <h3><?php echo $blog['content']; ?></h3>
  
  <!-- display the twitter feed from Tammy's twitter profile -->
  <?php include('./twitter/twitter.php'); ?>

  <!-- display the footer -->
  <?php require('./layout/footer.php') ?>
