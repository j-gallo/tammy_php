<!-- display form for blog creation -->

<head>
  <script type='text/javascript' src='../ckeditor/ckeditor.js'></script>
</head>

<form method='post' action='../thoughts/' >

  <input type="hidden" name="action" value="create_blog" />

  <label for='title'>This is the title of the blog</label>
  <br />
  <input id='title' type='input' name='title'>
  <br />
  <label for='content'>This is the body of the blog</label>
  <br />
  <textarea id='content' type='input' name='content'></textarea>
  <br />
  <input type='submit' value='Submit' />
  
</form>

<!-- convert blog body textarea form field to WYSIWYG -->

<script type='text/javascript'>
  CKEDITOR.replace( 'content' );
</script>

<!-- display footer -->
<?php require('../layout/footer.php') ?>
