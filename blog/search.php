<?php require_once("./include/header.php");?>
    <div class="fluid-container">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-md-5 p-3">
      <?php require_once("./include/navigation.php");?>
      </nav> <!--End nav-->
<?php
if(isset($_POST["zt_search"])){
  
  $key=$_POST["zt_search"];
  $url="http://localhost/blog/search.php?key=".$key;
  header("Location: {$url}");
  
}
$status="Published";
$post_per_page=1;
$sqltwo="select*from post where post_title like :post_title and post_status=:post_status;";
$stm=$PDO->prepare($sqltwo);
$title='%'.$_GET["key"].'%';
$stm->bindParam(":post_title",$title,PDO::PARAM_STR);
$stm->bindParam(":post_status",$status,PDO::PARAM_STR);
$stm->execute();
$count_row=$stm->rowCount();
if(isset($_GET["page"])){
  $page=$_GET["page"];
  if($page==1){
    $page_id=0;
  }else{
    $page_id=($post_per_page*$page)- $post_per_page;
  }
}else{
  $page=1;
  $page_id=0;
}
$totale_pager=ceil($count_row/$post_per_page);

?>
      <section id="main" class="mx-5">
        <h2 class="my-3">Search Result: <?php echo isset($_GET["key"])?$_GET["key"]:"";?></h2>
        <?php 
        $status="published";
        $sql="select*from post where post_title like :post_title and post_status=:post_status";
        $statment=$PDO->prepare($sql);
        $title='%'.$_GET["key"].'%';
        $statment->bindParam(":post_title",$title,PDO::PARAM_STR);
        $statment->bindParam(":post_status",$status,PDO::PARAM_STR);
        $statment->execute();
       $rowCount=$statment->rowCount();
       if($rowCount!=0):
        while($row=$statment->fetch(PDO::FETCH_BOTH)){
          $post_id=$row["post_id"];
          $post_title=$row["post_title"];
          $post_desc=$row["post_desc"];
          $post_img=$row["post_img"];
          $post_date=$row["post_date"];
          $post_author=$row["post_author"];
          $post_cat_id=$row["post_cat_id"];
          $post_status=$row["post_status"];
          
        
          }
       
        
        ?>
        <div class="row my-4 single-post">
          <img class="col col-lg-4 col-md-12" src="./img/<?php echo $post_img ;?>" alt="Image">
          <div class="media-body col col-lg-8 col-md-12">
            <h5 class="mt-0"><a href="#"> </a></h5>
            <span class="posted"><a href="categories.php" class="category">
            <?php 
              $sqltwo="select ct.cat_title from categories ct inner join Post pt on ct.cat_id=pt.post_cat_id where pt.post_id=:post_id;";
              $statmentwo=$PDO->prepare($sqltwo);
              $statmentwo->bindParam(":post_id",$post_id,PDO::PARAM_INT);
              $statmentwo->execute();
              while($rowtwo=$statmentwo->fetch(PDO::FETCH_ASSOC)){
                $cat_title=$rowtwo["cat_title"];
                echo $cat_title;
              }  
              ?>
            </a> Posted <?php echo $post_author; ?> by Jan at <?php echo $post_date; ?> <datagrid></datagrid></span>
            <p>
            <?php echo $post_desc; ?>
            </p>
            <span><a href="single.php?id=<?php echo $post_id;?>" class="d-block">See more &rarr;</a></span>
          </div>
        </div>
      </section>
<?php endif;
if($rowCount==0){
  echo "<div class='alert alert-danger'>Not Found !</div>";
}

?>
   <?php if($totale_pager>$post_per_page):?>
      <ul class="pagination px-5">
        <?php 
        if($page_id==0):
        ?>
        <li class="page-item disabled"> <a class="page-link" href="#" tabindex="-1">Previous</a></li>
        <?php endif;
        if($page_id!=0):
        ?>
<li class="page-item "> <a class="page-link" href="search.php?key=<?php echo $_GET["key"] ;?>&page=<?php echo $page_id;?>" tabindex="-1">Previous</a></li>
<?php endif; ?>
        <?php for($i=1;$i<$totale_pager;$i++):
          if($i==$page_id+1): ?>
        <li class="page-item active"><a class="page-link" href="search.php?key=<?php echo $_GET["key"] ;?>&page=<?php echo $i;?>"><?php echo $i; ?></a></li>
      <?php 
      endif;
      if($i!=$page_id+1):
       ?>
       <li class="page-item "><a class="page-link" href="search.php?key=<?php echo $_GET["key"]; ?>&page=<?php echo $i;?>"><?php echo $i; ?></a></li>
       <?php endif; ?>
      
      
        <?php endfor; ?>
        <?php if($page_id+1==$totale_pager):?>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
        <?php endif;?>
        <?php if($page_id+1<$totale_pager):?>
          <li class="page-item">
          <a class="page-link" href="search.php?key=<?php echo $_GET["key"]; ?>&page=<?php echo $page_id+2;?>">Next</a>
        </li>
        <?php endif;?>
      </ul>

     <?php endif; ?>

   <?php require_once("./include/footer.php");?>