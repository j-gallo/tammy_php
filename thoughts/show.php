<!-- this page displays the latest blogs and the most popular tags -->

<h1>Blog Posts</h1>

<!-- grab the most popular tags and display them -->
Popular Tags:
<?php
  $popular_tags = popular_tags();
  echo '<ul>';
  foreach($popular_tags as $p_tags){
    echo '<li>' . $p_tags . ' </li> '; 
  }
  echo '</ul>';
  ?>
<ul>

<!-- for each blog, display the title, the date of its creation,
     and the content. -->
<?php foreach ($blogs as $blog):  ?>

  <h1><?php echo $blog['title']; ?></h1>
  <h2><?php echo date("F j, Y", strtotime($blog['created_at'])); ?></h2>
  <h3><?php echo $blog['content']; ?></h3>

  <?php $blog_id = $blog['id']; ?>
  
  <?php if(isset($_SESSION['logged_in'])) : ?>
    <?php include("./tag_form.php"); ?>
    <a href='./delete_blog.php?id=<?php echo $blog['id'] ?>'>Delete</a>,
    <a href='../blog/edit.php?id=<?php echo $blog['id'] ?>'>Edit</a>,
    <a href='./remove_tags.php?id=<?php echo $blog['id'] ?>'>Remove tags</a><br />
  <?php endif ?>
  
  <?php $tags = show_tags($blog_id); ?>
  <?php if (isset($tags)) : ?>
    <?php foreach ($tags as $tag) : ?>
        <?php $tag_array[] = $tag[0] ?>
    <?php endforeach ?>
    <?php echo implode(', ', $tag_array); ?>
  <? endif ?>
  
  <?php $tag_array = array(); ?>

<?php endforeach ?>
