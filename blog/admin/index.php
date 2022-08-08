<?php require("./include/header.php")?>
<?php
if(!isset($_COOKIE["user"])){
  header("Location:  sign-in.php");
}

?>

    <div class="fluid-container">
      <?php require_once("./include/nav.php") ;?>
      <!--End nav-->

      <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
        <div class="d-flex flex-row justify-content-between">
            <h2 class="my-3">All Posts</h2>
            <a class="btn btn-secondary align-self-center d-block" href="new-post.php">Add New Post</a>
        </div>
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Post Title</th>
                <th scope="col">Post Category</th>
                <th scope="col">Post Status</th>
                <th scope="col" class="d-none d-md-table-cell">Comments</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
              <?php 
              $sql="select*from post;";
              $stm=$PDO->prepare($sql);
              $stm->execute();
              $rowCount=$stm->rowCount();
              if($rowCount==0){
                echo "<div class='alert alert-danger'>Table is Empty !</div>";
              }
              if($rowCount!=0):
                while($row=$stm->fetch(PDO::FETCH_BOTH)):
                  // post_title,post_desc,post_img,post_date,post_author,post_cat_id,post_status
                  $post_id=$row["post_id"];
                $post_title=$row["post_title"];
                $post_status=$row["post_status"];
                $post_cat_id=$row["post_cat_id"];
                $post_author=$row["post_author"];
              

              ?>
                <tr>
                <th><?php echo $post_id?></th>
                <td><?php echo $post_title; ?></td>
                <td>
                <?php 
                $sqltw="select cat_title,cat_id from categories where cat_id=:cat_id;";
                $statment=$PDO->prepare($sqltw);
                $statment->bindParam(":cat_id",$post_cat_id,PDO::PARAM_INT);
                $statment->execute();
                while($rowthow=$statment->fetch(PDO::FETCH_BOTH)){
                  $cat_title=$rowthow["cat_title"];
                  
                  echo $cat_title;
                }
                ?>
                </td>
                <td><?php  echo $post_status;?></td>
                <td class="d-none d-md-table-cell">
                  <?php
                  $sqlcount="select	count(*) from comments where comment_post_id=$post_id; ";
                  $stmcount=$PDO->prepare($sqlcount);
                  $stmcount->execute();
                  while($row=$stmcount->fetch(PDO::FETCH_BOTH)):
                    $count=$row["count(*)"];
                  
                  ?>
                  <a href="comments.php?id=<?php echo $post_id;?>"><?php echo $count; ?></a>
                  <?php  endwhile;?>
                </td>
                <td>
                    <form action="edit-post.php?id=<?php echo $post_id; ?>&post_author=<?php echo $post_author; ?>" method="POST">
                        <input type="submit" value="Edit" name="Edit">
                    </form>
                </td>
                <td> 
                    <form action="index.php" method="POST">
                    
                          <input type="submit" value="Delete" name="Delete">
                    </form>               
                </td>
                <?php
                endwhile;
               endif; ?>
                 <?php 
                      if(isset($_POST["Delete"])){
                        $sqldelete="delete from post where post_id=$post_id;";
                        $stmdelete=$PDO->prepare($sqldelete);
                        $stmdelete->execute();
                        header("Location: index.php");
                      }
                      
                      ?>
            </tbody>
        </table>
    
      </section>

  
    </div>

 <?php require("./include/footer.php");?>