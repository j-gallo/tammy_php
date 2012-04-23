<!-- this is the form to add tags to the blog -->

<?php global $blog_id; ?>

<form method='POST' action='./index.php'>
  <input type='hidden' name='action' value='add_tag'>
  <input type='hidden' name='id' value='<?php echo $blog_id; ?>'>
  <label for='tag'>New tag</label>
  <input type='input' name='title' />
  <input type='submit' value='create' />
</form>
