<?php include("./include/header.php") ?>
    <div class="fluid-container">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-md-5 p-3">
   <?php require("./include/navigation.php"); ?>
      </nav> <!--End nav-->
      
      <section id="main" class="mx-5">
      <h2 class="my-3">All Posts</h2>
      <?php 
      $status="published";
            $sql="select*from post";
            $statment=$PDO->prepare($sql);
      
            $statment->execute();
            while($row=$statment->fetch(PDO::FETCH_BOTH)):
              $post_id=$row["post_id"];
              $post_title=$row["post_title"];
              $post_desc=$row["post_desc"];
              $post_img=$row["post_img"];
              $post_date=$row["post_date"];
              $post_author=$row["post_author"];
              $post_cat_id=$row["post_cat_id"];
              $post_status=$row["post_status"];

            ?>
  
        <div class="row my-4 single-post">
          
          <img class="col col-lg-4 col-md-12" src="./img/<?php echo $post_img;?> " alt="Image">
          <div class="media-body col col-lg-8 col-md-12">
            <h5 class="mt-0"><a href="single.php?id=<?php echo $post_id;?>"><?php echo $post_title; ?></a></h5>
            <span class="posted">

              <a href="categories.php" class="category">
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
            
              </a> 
             

              Posted by <?php echo $post_author; ?> at <?php echo $post_date;?></span>
            <p>
              <?php echo $post_desc; ?>
            </p>
            <span><a href="single.php?id=<?php echo $post_id;?>" class="d-block">See more &rarr;</a></span>
          </div>
       
       
        </div>
        <?php endwhile;?>
      </section>
      
  
<?php 
require_once("./include/footer.php");?>