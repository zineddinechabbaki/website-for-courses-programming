
<?php require_once("./include/header.php");?>
<?php
if(!isset($_COOKIE["user"])){
  header("Location: http://localhost/blog/admin/sign-in.php");
}

?>
    <div class="fluid-container">
    <?php require_once("./include/nav.php") ;?> <!--End nav-->        

        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
            <h2 class="pb-3">Add New Post</h2>
            <?php 
            if(isset($_POST["insert_post"])){
                $post_title=trim(htmlspecialchars($_POST["post_title"]));
                $cat_id=$_POST["post_cat_id"];
                $post_image=$_POST["post_image"];
                $post_content=$_POST["post_desc"];
                $cat_status=$_POST["post_status"];
                $post_author=$_POST["post_author"];
                
                $sql="insert into post(post_title,post_desc,post_img,post_date,post_author,post_cat_id,post_status) values(:post_title,:post_desc,:post_img,current_date(),:post_author,:post_cat_id,:post_status);";
                $stm=$PDO->prepare($sql);
                $stm->bindParam(":post_title",$post_title);
                $stm->bindParam(":post_img",$post_image);
                $stm->bindParam(":post_cat_id",$cat_id);
                $stm->bindParam(":post_desc",$post_content);
                $stm->bindParam(":post_status",$cat_status);
                $stm->bindParam(":post_author",$post_author);
                $stm->execute();
            }
            
            ?>
            <form action="new-post.php" method="POST">
            <!-- post_author -->
                <div class="form-group">
                    <label for="post-title">Post Title</label>
                    <input type="text" class="form-control" id="post-title" placeholder="Enter post title" name="post_title">
                </div>
                <div class="form-group">
                    <label for="post-title">Post author</label>
                    <input type="text" class="form-control" name="post_author" id="post-author" placeholder="Enter post author" name="post-title">
                </div>
                <div class="form-group">
                    <label for="category">Post Status</label>
                    <select class="form-control" id="category" name="post_status">
                        <option value="Published" >published</option>
                        <option value="Draft" >Draft</option>
                    </select>
                </div>
                <div class="form-group">
                   
                   <label for="category">Select Category</label>
                   <select class="form-control" id="category" name="post_cat_id">
                   <?php
                   $sqltw="select cat_id, cat_title from categories";
                   $statment=$PDO->prepare($sqltw);
                   $statment->execute();
                   $row=$statment->fetchall(PDO::FETCH_KEY_PAIR);
                   
                   ?>
                   <?php foreach($row  as $key=>$value ):?>
                       <option value='<?php echo $key; ?>'><?php echo $value; ?></option>
                   <?php endforeach; ?>
                   </select>
               </div>
                <div class="form-group">
                    <label for="post-image">Upload post image</label>
                    <input type="file" class="form-control-file" id="post-image" name="post_image">
                </div>
                <div class="form-group">
                    <label for="post-content">Post Content</label>
                    <textarea class="form-control" id="post-content" rows="6" placeholder="Your post content" name="post_desc"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="insert_post">Submit</button>
            </form>
        </section>

    </div>
<?php require_once("./include/footer.php");?>