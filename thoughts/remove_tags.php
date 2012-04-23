<?php

  //load necessary functions
  require('../model/database.php');
  require('../model/tag_db.php');
  require('../model/blog_db.php');

  //get all of the tags for selected blog
  $tags = show_tags($_GET['id']);

  /*if 'tag' key of get array is set, remove
    the given tag from the blog*/
  if(isset($_GET['tag'])){
    remove_tag($_GET['tag'],$_GET['id']);
    header("Location: ./remove_tags.php?id=$_GET[id]");
  }

  //display header
  require('../layout/header.php');

?>

  Please click on a tag to remove it.
  <br />
  <br />

  <!-- if tags exsist, display all tags for given blog as links. Clicking the
       link will delete it. -->
  <?php if($tags != ''): ?>
    <?php foreach($tags as $tag) : ?>
      <a href="./remove_tags.php?id=<?php echo $_GET['id']; ?>&tag=<?php echo $tag[0]; ?>">
        <?php echo $tag[0]; ?></a>
    <?php endforeach ?>
  <?php endif ?>

  <!-- display footer -->
  <?php require('../layout/footer.php') ?>
