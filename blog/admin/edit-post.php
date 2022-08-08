<?php require("./include/header.php")?>
<?php
if(!isset($_COOKIE["user"])){
  header("Location: http://localhost/blog/admin/sign-in.php");
}

?>
    <div class="fluid-container">
    <?php require_once("./include/nav.php") ;?> <!--End nav-->        

        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
            <h2 class="pb-3">Edit Post</h2>
            <?php
            $post_id=$_GET["id"];
           $post_id=trim($_GET["id"]); 
            if(isset($_POST["submit"])){
                
                $post_title=$_POST["post_title"];
                $cat_id=$_POST["cat_id"];
                $cat_status=$_POST["cat_status"];
                $post_img=$_POST["post_img"];
                $post_author=$_GET["post_author"];
                $post_desc=$_POST["post_desc"];
                $post_date=date("Y-m-d");
                $sqlinser="update post set post_title=:post_title,post_desc=:post_desc,post_img=:post_img,post_date=:post_date,post_author=:post_author,post_cat_id=:post_cat_id,post_status=:post_status where post_id=:post_id;";
                $sttminsert=$PDO->prepare($sqlinser);
                $sttminsert->bindParam(":post_title",$post_title,PDO::PARAM_STR);
                $sttminsert->bindParam(":post_date",$post_date);
                $sttminsert->bindParam(":post_cat_id",$cat_id,PDO::PARAM_INT);
                $sttminsert->bindParam(":post_status",$cat_status,PDO::PARAM_STR);
                $sttminsert->bindParam(":post_img",$post_img);
                $sttminsert->bindParam(":post_author",$post_author,PDO::PARAM_STR);
                $sttminsert->bindParam(":post_desc",$post_desc,PDO::PARAM_STR);
                $sttminsert->bindParam(":post_id",$post_id,PDO::PARAM_INT);
                $sttminsert->execute();
              header("Location: index.php");

            }
            $sql="select*from post where post_id=:post_id";
            
            $stm=$PDO->prepare($sql);
            $stm->bindParam(":post_id",$post_id,PDO::PARAM_INT);
            $stm->execute();
            $rowCount=$stm->rowCount();
          
              while($row=$stm->fetch(PDO::FETCH_BOTH)){
                $id=$row["post_id"];
                $title=$row["post_title"];
                $status=$row["post_status"];
                $cat_id=$row["post_cat_id"];
                $author=$row["post_author"];
                $descc=$row["post_desc"];
                $img=$row["post_img"];
              }
                // post_title,post_desc,post_img,post_date,post_author,post_cat_id,post_status
                

            ?>
            
        
              

           
            <form action='#' method="POST">
                <div class="form-group">
                    <label for="post-title">title</label>
                    <input type="text" value='<?php echo $title;?>' name="post_title" class="form-control" id="post-title" placeholder="Enter post title">
                </div>
                <div class="form-group">
                   
                    <label for="category">Select Category</label>
                    <select class="form-control" id="category" name="cat_id">
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
                    <label for="category">Post Status</label>
                    <select class="form-control" id="category" name="cat_status">
                        <option value="Published" <?php $status=="published"?"selected":"";?>>published</option>
                        <option value="Draft"<?php $status=="Draft"?"selected":"";?> >Draft</option>
                    </select>
                </div>
                <div class="form-group">
                   <img src="../img/<?php echo $img; ?>" style="width:50px;height:50px;" >
                    <label for="post-image">Upload post image</label>
                    <input type="file" class="form-control-file" id="post-image" name="post_img">
                </div>
                <div class="form-group">
                    <label for="post-content">Post Content</label>
                    <textarea class="form-control" id="post-content" rows="6" placeholder="Your post content" name="post_desc" ><?php echo $descc; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </section>

    </div>
    <?php require("./include/footer.php");?>