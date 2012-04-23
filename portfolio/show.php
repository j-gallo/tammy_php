<?php 
  
 /*grabs the list of years in which portfolio pieces were created.*/
  $years = get_years();

  /*if a year has been selected, show the pieces that were created in 
    that year. If no year is selected, default to the current year.*/
  if (!isset($_GET['year'])){
    $selected_year = date(Y);
  }else{
    $selected_year = $_GET['year'];
  }

  $portfolio = show_portfolio($selected_year); 

  foreach ($years as $year){
    if ($year[0] == $selected_year){
      echo $year[0].' ';
    }else{
      echo "<a href='./index.php?year=" . $year[0] . "'>" . $year[0] . "</a>  ";
    }
  }

  echo '<br />';

  foreach ($portfolio as $portfolio){
    echo $portfolio['title'];
    if($portfolio['url'] == ''){
      echo $portfolio['url'];
      echo '<a href="' . $portfolio['image'] . '">';
      echo '<img src="' . $portfolio['thumb'] . '" /></a>';
    }elseif (preg_match('/http:\/\/www./', $portfolio['url'])){
      echo $portfolio['url'];
      echo '<a href="' . $portfolio['url'] . '">';
      echo '<img src="' . $portfolio['thumb']. '" /></a>';
    }elseif (!preg_match('/http:\/\//', $portfolio['url']) 
                && preg_match('/www./', $portfolio['url'])){
      echo $portfolio['url'];
      echo '<a href="http://'. $portfolio['url'] . '">';
      echo '<img src="' . $portfolio['thumb'] . '" /></a>';
    }else{
      echo $portfolio['url'];
      echo '<a href="http://www.' . $portfolio['url'] . '">';
      echo '<img src="' . $portfolio['thumb'] . '" /></a>';
    }
    if($_SESSION['logged_in'] === true){
      echo '  <a href="./index.php?action=delete&id=' . $portfolio['id'] . '">delete</a>  ';
    }
  }

?>
