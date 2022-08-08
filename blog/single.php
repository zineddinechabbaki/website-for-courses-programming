<?php   require_once("./include/header.php");?>
    <div class="fluid-container">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-md-5 p-3">
      <?php require_once("./include/navigation.php");?>
      </nav> <!--End nav-->

      <section id="main">
        <div class="post-single-information">  
          <?php
         if(isset($_GET["id"])):
          $id=$_GET["id"];
          $sqlthree="select*from post where post_id=:post_id;";
          $statmenthree=$PDO->prepare($sqlthree);
          $statmenthree->bindParam(":post_id",$id,PDO::PARAM_INT);
          $statmenthree->execute();
          $rowct=$statmenthree->rowCount();
          if($rowct==1):
          while($rowthree=$statmenthree->fetch(PDO::FETCH_BOTH)):
          $post_id=$rowthree["post_id"];
          $post_title=$rowthree["post_title"];
          $post_desc=$rowthree["post_desc"];
          $post_img=$rowthree["post_img"];
          $post_date=$rowthree["post_date"];
          $post_author=$rowthree["post_author"];
          $post_cat_id=$rowthree["post_cat_id"];
          $post_status=$rowthree["post_status"];
        ?>     
        <div class="post-single-info">
            <div class="post-single-80">                 
                <h1 class="category-title">Category: 
                  <?php 
                  $sqlfour="select cat_title from categories where cat_id=:cat_id;";
                  $statmentfour=$PDO->prepare($sqlfour);
                  $statmentfour->bindParam(":cat_id",$post_cat_id,PDO::PARAM_INT);
                  $statmentfour->execute();
                  while($row=$statmentfour->fetch(PDO::FETCH_BOTH)){
                    echo $row["cat_title"];
                  }
                  
                  ?>

                </h1>
                <h2 class="post-single-title">Title:<?php echo $post_title; ?> </h2>
                <div class="post-single-box">
                    Posted by <?php echo $post_author." ". $post_date; ?> 
                </div>
            </div>
        </div>
        <div class="post-main">
          <img class="d-block" style="width:100%;height:400px" src="./img/<?php echo $post_img ?>" alt="photo" />
          <p class="mt-4">
            <?php echo $post_desc; ?>
          </p>
        </div>
      </div>
      <?php endwhile;
          endif;
    endif;
    ?>
  
     

        <div class="comments">
          <?php  $sqlcount="select count(*) from comments where comment_post_id=:id ";
        $stmcount=$PDO->prepare($sqlcount);
   
        $stmcount->bindParam(":id",$id,PDO::PARAM_INT);
        $stmcount->execute();
        while($rowtwo=$stmcount->fetch(PDO::FETCH_BOTH)){
          $count=$rowtwo["count(*)"];
          
        }?>
          
        <h2 class="comment-count"><?php echo $count; ?> Comments</h2>
        <?php
        
        $sqlfive="select*from comments where comment_post_id=:id";
        $statementfive=$PDO->prepare($sqlfive);
        $statementfive->bindParam(":id",$id,PDO::PARAM_INT);
        $statementfive->execute();
        while($row=$statementfive->fetch(PDO::FETCH_BOTH)):
          // comment_desc,comment_date,comment_author,comment_post_id
          $comment_desc=$row["comment_desc"];
          $comment_date=$row["comment_date"];
          $comment_author=$row["comment_author"];
          $comment_post_id=$row["comment_post_id"];
       
        $sqlimg="select*from post where post_id=$id;";
        $stmimg=$PDO->prepare($sqlimg);
        $stmimg->execute();
        while($rowimg=$stmimg->fetch(PDO::FETCH_BOTH)){
          $img=$rowimg["post_img"];
        }
        
        
        ?>
         
          <div class="comment-box">
              <img src="./img/<?php echo $img; ?>" style="width:88px;height:88px;border-radius:50%" alt="Author photo" class="comment-photo">
              <div class="comment-content">
                  <span class="comment-author"><b><?php echo $comment_author; ?></b></span>
                  <span class="comment-date"><?php echo $comment_date; ?></span>
                  <p class="comment-text">
                      <?php echo $comment_desc; ?>
                  </p>
              </div>
          </div>
          <?php  endwhile;?>
          <?php
            if(isset($_POST["send_comment"])){
              $name=$_POST["name"];
              $email=$_POST["email"];
              $comment=$_POST["comment"];
              if(empty($name) | empty($email) | empty($comment)){
                $erro="Please enter your information before submit it !";
                echo "<div class='alert alert-danger'>$erro </div>";
              }else{
                $sqlinsert="insert into comments(comment_desc,comment_date,comment_author,comment_post_id,email) values(:comment,current_date(),:name,:comment_post_id,:email)";
                 $stmntinsert=$PDO->prepare($sqlinsert);
                 $stmntinsert->bindParam(":comment",$comment,PDO::PARAM_STR);
                 $stmntinsert->bindParam(":name",$name,PDO::PARAM_STR);
                 $stmntinsert->bindParam(":comment_post_id",$id,PDO::PARAM_STR);
                 $stmntinsert->bindParam(":email",$email,PDO::PARAM_STR);
                 $stmntinsert->execute();
                 
header("Location: single.php?id={$id}");
              }
             
            }
            ?>
          <h3 class="leave-comment">Leave a comment</h3>
          <div class="comment-submit"> 
            
              <form action="http://localhost/blog/single.php?id=<?php echo $_GET["id"]; ?>" method="POST" class="comment-form" >
                  <input class="input" type="text" placeholder="Enter Full Name" name="name">
                  <input class="input" type="email" placeholder="Enter valid email" name="email">
                  <textarea name="comment" id="" cols="20" rows="5" placeholder="Comment text"></textarea>
                  <input type="submit" value="Submit" class="comment-btn" name="send_comment">
              </form>
          </div>
        </div>
      </section>

   <?php require_once("./include/footer.php");?>