<?php require_once("./include/header.php"); ?>
    <div class="fluid-container">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-md-5 p-3">
      <?php require_once("./include/navigation.php");?>
      </nav> <!--End nav-->

<?php 
if(isset($_GET["id"])){
  $id= $_GET["id"];
  $sql="select*from categories where cat_id=:cat_id";
  $statment=$PDO->prepare($sql);
  $statment->bindParam(":cat_id",$id,PDO::PARAM_INT);
  $statment->execute();
  $rowCount=$statment->rowCount();
  if($rowCount==0){
    echo "<div class='alert alert-danger'>Page not Found!</div>";
  }else{
    while($cat=$statment->fetch(PDO::FETCH_BOTH)){
      $cat_id=$cat["cat_id"];
      $cat_title=$cat["cat_title"];
    }
  }
}
?>

      <section id="main" class="mx-5">
        <h2 class="my-3">Category:<?php echo"$cat_title";?></h2>
        <?php 
         $post_cat_id=$cat_id;
        $sqlthree="select *from Post where post_cat_id=$cat_id ";
       
        $statmenttwo=$PDO->prepare($sqlthree);

        $statmenttwo->execute();
        while($row=$statmenttwo->fetch(PDO::FETCH_BOTH)){
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
          <img class="col col-lg-4 col-md-12" src="./img/<?php echo $post_img; ?>" alt="Image">
          <div class="media-body col col-lg-8 col-md-12">
            <h5 class="mt-0"><a href="single.php?id=<?php echo $post_id;?>" ><?php echo $post_title; ?></a></h5>
            <span class="posted"><a href="categories.php" class="category"><?php echo $cat_title; ?></a> Posted by <?php echo $post_author; ?> at <?php echo $post_date; ?></span>
            <p>
             <?php echo $post_desc; ?>
            </p>
            <span><a href="single.php?id=<?php echo $post_id;?>"  class="d-block">See more &rarr;</a></span>
          </div>
        </div>
      </section>
      
 
    

   <?php require_once("./include/footer.php");?>