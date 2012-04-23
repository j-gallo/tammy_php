<?php
/*This file is a collection of functions that modify the
  tags table in the database.*/

/*this function takes as parameters a blog id and a tag title.
  first, the blog matching the given id is selected from the database.
  Then a relationship is made between the given blog and the tag matching
  the title that was supplied. If the given tag doesn't exist, it is created.
  If the given blog is already related to the given tag, an error is reported.*/
function add_tag($blog_id, $title) {
  global $db;
  // Check first to see if tag already exsists.
  $query = 'SELECT id FROM tags WHERE title = :title';
  $stmt = $db->prepare($query);
  $stmt->bindValue(':title', $title);
  $stmt->execute();
  $tag = $stmt->fetch(PDO::FETCH_BOTH);
  $stmt->closeCursor();
  
  // If tag exists, add a relationship in the taggings table between
  // the tag and the blog.
  if ($tag) {
    // If the relationship between the tag and the blog exists, the blog 
    // already has the given tag and need not be tagged again. Output error.
    $query = 'SELECT id FROM taggings WHERE tag_id = :tag_id AND blog_id = :blog_id';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':tag_id', $tag['id']);
    $stmt->bindValue(':blog_id', $blog_id);
    $stmt->execute();
    $tagged = $stmt->fetch(PDO::FETCH_BOTH);
    $stmt->closeCursor();
    if ($tagged){
      echo 'This blog already has that tag!!';
      exit();
    }

    // If no relationship exists, create one
    $query = 'INSERT INTO taggings (blog_id, tag_id) VALUES (:blog_id, :tag_id)';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':blog_id', $blog_id);
    $stmt->bindValue(':tag_id', $tag['id']);
    $stmt->execute();
    $stmt->closeCursor();
  }

  // If the tag doesn't exist, create it along with the relationship to the blog in the 
  // taggings table.
  else{
    // create the tag
    $query = 'INSERT INTO tags (title) VALUES (:title)';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':title', $title);
    $stmt->execute();
    $stmt->closeCursor();

    // grab the tag id
    $query = 'SELECT id FROM tags WHERE title = :title';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':title', $title);
    $stmt->execute();
    $tag = $stmt->fetch(PDO::FETCH_BOTH);
    $stmt->closeCursor();
    
    // add the relationship to the taggings table
    $query = 'INSERT INTO taggings (blog_id, tag_id) VALUES (:blog_id, :tag_id)';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':blog_id', $blog_id);
    $stmt->bindValue(':tag_id', $tag['id']);
    $stmt->execute();
    $stmt->closeCursor();
  }

}

/*this function takes a blog id as a parameter. All of the tags which are 
  related to the given blog are grabbed from the database and returned in
  an array to be displayed on the page.*/
function show_tags($blog_id){
  global $db;
  //grab the ids of all tags related to the given blog
  $query = 'SELECT tag_id FROM taggings WHERE blog_id = :blog_id';
  $stmt = $db->prepare($query);
  $stmt->bindValue(':blog_id', $blog_id);
  $stmt->execute();
  $tag_ids = $stmt->fetchAll(PDO::FETCH_NUM);
  $stmt->closeCursor();

  //grab the tags matching the retrieved ids
  foreach ($tag_ids as $tag_id){
    $query = 'SELECT title FROM tags WHERE id = :tag_id';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':tag_id', $tag_id[0]);
    $stmt->execute();
    $tags[] = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
  }
  if(isset($tags)){
    return($tags);
  }
}

/*this function takes a tag title as a parameter. The tag matching
  the title is grabbed from the database. Then, using that tag's id,
  The taggings table is checked for instances of the given tag. If the
  tag appears multiple times in the taggings table, the relationship is
  deleted. If the tag appears only once, the relationship and the tag itslef
  is deleted.*/
function remove_tag($title, $blog_id){
  global $db;
  $query = "SELECT id FROM tags WHERE title = '$title'";
  $tag_id = $db->query($query);
  $tag_id = $tag_id->fetch();

    $query = "SELECT COUNT(id) FROM taggings WHERE tag_id = $tag_id[0]";
    $count = $db->query($query);
    $count = $count->fetch();
    if($count[0] === 1){
      $query = "DELETE FROM tags WHERE id = $tag_id[0]";
      $db->exec($query);
    }

  $query = "DELETE FROM taggings WHERE (tag_id = $tag_id[0] AND blog_id = $blog_id)";
  $db->exec($query);

}


/*this function grabs the 10 most popular tags, sorts them by popularity,
  and returns them in an array.*/
function popular_tags(){
  global $db;
  //first grab all of the tag ids from the taggings table
  $query = 'SELECT tag_id from taggings';
  $stmt = $db->prepare($query);
  $stmt->execute();
  $tag_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $count = $stmt->rowCount();
  $stmt->closeCursor();

  $ids = array();

  /*this block loops through all of the tag ids that were returned from
    querying the taggings table. When a new tag id appears, a new key 
    in the array 'ids' is created. If a tag id appears more than once,
    the array key matching the id is found and 1 is added to its value.
    when the loop is finished, ids is an array containing keys that match
    the tag ids with values equal to the number of times they appear in the
    taggings table (the number of different blogs containing said tag).*/
  foreach($tag_ids as $tag_ids){
    foreach($tag_ids as $tag_id){
      if($key = array_keys($ids, $tag_id)){
        $ids[$key] += 1;
      }
      else{
        $ids[$tag_id] += 1;
      }
    }
  }

  arsort($ids);
  
  $ids = array_slice($ids, 0, 10, 'preserve_keys');

  $tags = array();

  echo '<br />';
  foreach($ids as $id=>$occurence){
    $query = 'SELECT title FROM tags WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $tag_holder = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    $tags[] = $tag_holder[0];
  }

  return($tags);

}

?>
