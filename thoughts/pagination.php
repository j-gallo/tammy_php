<!-- Pagination links -->
<br />
<br />
<br />
<ul>
  <?php $i = 1;
    while($i <= $pages){
      if(isset($_GET['page'])){
        if($_GET['page'] == $i){
          echo "<li>$i</li>";  
        }else{
          echo "<li><a href='./index.php?page=$i'>$i</a></li>";
        }
      }elseif($i == 1){
        echo "<li>$i</li>";  
      }else{
        echo "<li><a href='./index.php?page=$i'>$i</a></li>";
      }
      $i++;
    }
  ?>
</ul>
