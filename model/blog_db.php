<?php

/*this file contains functions which modify the blogs table in the database*/

/*this function takes two strings as parameters and adds them to a new row
  in the blogs table.*/
function add_blog($title, $content){
  global $db;
  if($title == '' || $content == ''){
    header('Location:../blog/index.php?error=blank');
    exit;
  }
  $query = "INSERT INTO blogs (title, content) Values ('$title', '$content')";
  $db->exec($query);
}

/*this function takes 2 strings and an int as parameters. It then grabs the blog
  matching the id supplied by the int parameter. The grabbed blog is then updated
  with the info in the other 2 parameters.*/
function edit_blog($title, $content, $id){
  global $db;
  if($title == '' || $content == ''){
    header("Location:../blog/edit.php?id=$id&error=blank");
    exit;
  }
  $query = "UPDATE blogs SET title='$title', content='$content' WHERE id = $id";
  $db->exec($query);
}

/*This function takes an integer as a parameter. It then uses that integer to 
  grab the blog with id matching that integer and returns the blog.*/
function get_blog($id){
  global $db;
  $query = "SELECT id, title, content FROM blogs WHERE id = $id";
  $blog = $db->query($query);
  $blog = $blog->fetch();
  return $blog;
}

/*this function counts all of the blogs and determines the amount of pages required to 
  show the blogs with only '$per_page' blogs per page. Based on the current page that is
  selected, the function grabs the blogs that would be on that page. This effectively
  grabs all the blogs and paginates them.*/
function all_blogs(){
  global $db;
  $per_page = 10;
  $query = "SELECT COUNT(id) FROM blogs";
  $hits = $db->query($query);
  $hits = $hits->fetch();
  $pages = ceil($hits[0] / $per_page);
  $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
  $db_start = ($page - 1) * $per_page;
  $query = "SELECT * FROM blogs ORDER by created_at DESC LIMIT $db_start, $per_page";
  $blogs = $db->query($query);
  return array($blogs, $pages);
}

/*this function grabs the blog that was created most recently and returns it.*/
function latest_blog() {
  global $db;
  $query = "SELECT * FROM blogs ORDER by created_at DESC LIMIT 1";
  $blog = $db->query($query);
  $blog = $blog->fetch();
  return $blog;
}

/*this function takes a blog id as a parameter. It deletes the blog matching the blog
  id and takes care of the tags accordingly. For instance, if all of the tags attached
  to the given blog are also attached to other blogs, the relationships are destroyed 
  but the tags remain. If no other blog has a tag that is attached to the given blog,
  both the relationship and the tag are deleted.*/
function delete_blog($id){
  global $db;

  $query = "SELECT tag_id FROM taggings WHERE blog_id = $id";
  $tag_ids = $db->query($query);

  foreach($tag_ids as $tag_id){
    $query = "SELECT COUNT(id) FROM taggings WHERE tag_id = $tag_id[tag_id]";
    $count = $db->query($query);
    $count = $count->fetch();
    if($count[0] == 1){
      $query = "DELETE FROM tags WHERE id = $tag_id[tag_id]";
      $db->exec($query);
    }
  }

  $query = "DELETE FROM blogs WHERE id = $id";
  $db->exec($query);

  $query = "DELETE FROM taggings WHERE blog_id = $id";
  $db->query($query);

}

?>
