<?php
  //include necessary functions
  require('../model/database.php');
  require('../model/blog_db.php');

  //display header
  require('../layout/header.php');

  //get info for the blog to be edited from URL.
  $blog = get_blog($_GET['id']);

  //if user submits an edited blog with a blank field, throw an error.
  if($_GET['error'] == 'blank'){
    echo "Can't leave title or content blank";
  }
?>

<!-- display blog edit form populated with info that is to be edited -->
<head>
  <script type='text/javascript' src='../ckeditor/ckeditor.js'></script>
</head>

<form method='post' action='../thoughts/' >

  <input type="hidden" name="action" value="edit_blog" />
  <input type="hidden" name="id" value="<?php echo $blog["id"]; ?>" />

  <label for='title'>This is the title of the blog</label>
  <br />
  <input id='title' type='input' name='title' value="<?php echo $blog['title']; ?>">
  <br />
  <label for='content'>This is the body of the blog</label>
  <br />
  <textarea id='content' type='input' name='content'><?php echo $blog['content']; ?></textarea>
  <br />
  <input type='submit' value='Submit' />
  
</form>

<!--convert Blog body input textarea to WYSIWYG -->
<script type='text/javascript'>
  CKEDITOR.replace( 'content' );
</script>

<!--display foter -->
<?php require('../layout/footer.php') ?>
