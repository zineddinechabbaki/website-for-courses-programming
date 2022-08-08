<?php require("./include/header.php")?>
<?php
if(!isset($_COOKIE["user"])){
  header("Location: http://localhost/blog/admin/sign-in.php");
}

?>
    <div class="fluid-container">
    <?php require_once("./include/nav.php") ;?> <!--End nav-->

      <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
        <div class="d-flex flex-row justify-content-between">
            <h2 class="my-3">All Comments</h2>
        </div>
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">User name</th>
                <th scope="col">Comment</th>
                <th scope="col" class="d-none d-md-table-cell">In response to</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
              <?php 
           if(isset($_GET["id"])):
            $comment_post_id=$_GET["id"];
            $sql="select	*from comments where comment_post_id=:comment_post_id;";
            $stment=$PDO->prepare($sql);
            $stment->bindParam(":comment_post_id",$comment_post_id,PDO::PARAM_INT);
            $stment->execute();
            while($row=$stment->fetch(PDO::FETCH_BOTH)):
              $comment_id=$row["comment_id"];
              $comment_author=$row["comment_author"];
              $comment_title=$row["comment_desc"];
            
           
              
              
              ?>
                <tr>
                    <td><?php echo $comment_id; ?></td>
                    <td><?php echo $comment_author ?></td>
                    <td><?php echo $comment_title;?></td>
                    <td class="d-none d-md-table-cell">
                      <?php
                      $sqlPosttitle="select*from post where post_id=$comment_post_id;";
                      $stmPosttitle=$PDO->prepare($sqlPosttitle);
                      $stmPosttitle->execute();
                      while($rowposttitle=$stmPosttitle->fetch(PDO::FETCH_BOTH)){
                        $post_title=$rowposttitle["post_title"];
                      }
                      
                      ?>
                        <a href="../single.php?id=<?php ECHO $comment_post_id; ?>"><?php echo $post_title;?></a>
                    </td>
                    <td>
                        <form action="comments.php" method="POST">
                          <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                            <button name="delete">Delete</button>
                        </form>               
                    </td>
                </tr>
                <?php endwhile; endif;?>
            </tbody>
        </table>
    <?php 
    if(isset($_POST["delete"])){
        $comment_id=$_POST["comment_id"];
        $sqldelete="delete from comments where comment_id=$comment_id;";
        $stmdelete=$PDO->prepare($sqldelete);
        $stmdelete->execute();    
    }
    
    ?>
      </section>

      <ul class="pagination px-lg-5">
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>

    </div>
    <?php require("./include/footer.php");?>