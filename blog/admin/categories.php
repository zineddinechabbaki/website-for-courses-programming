<?php require("./include/header.php")?>
<?php
if(!isset($_COOKIE["user"])){
  header("Location: http://localhost/blog/admin/sign-in.php");
}

?>
    <div class="fluid-container">
    <?php require_once("./include/nav.php") ;?> <!--End nav-->        
<?php
if(isset($_POST['submit'])){
    $name=$_POST["cat_title"];
   $sqladdcat="insert into categories(cat_title) values(:cat_title)";
   $statmentaddcat=$PDO->prepare($sqladdcat);
   $statmentaddcat->bindParam(":cat_title",$name,PDO::PARAM_STR);
   $statmentaddcat->execute();
}
?>

        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
            <form class="py-4" action='categories.php' method="POST">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Enter category name" name="cat_title">
                    </div>
                    <div class="col">
                        <input type="submit" class="form-control btn btn-secondary" value="Add New Category" name="submit">
                    </div>
                </div>
            </form>
            <?php
            if(isset($_POST["btn_update"])){
                $id=$_POST["id"];
            ?>
             <form class="py-4" action='categories.php' method="POST">
                <div class="row">
                    <div class="col">
                    <input type="hidden" value="<?php echo $id;?>" name="id">
                        <input type="text" class="form-control" placeholder="Enter category name" name="update_cat_title">
                    </div>
                    <div class="col">
                        <input type="submit" class="form-control btn btn-primary" value="Update Category" name="updatecat">
                    </div>
                </div>
            </form>   
            
            <?php } 
            if(isset($_POST["updatecat"])){
                
               $id=$_POST["id"];
          
                $cat_title_update=$_POST["update_cat_title"];
                $sqlupdate="update categories set cat_title=:cat_title where cat_id=:cat_id";

                $stmupdate=$PDO->prepare($sqlupdate);
                $stmupdate->bindParam(":cat_title",$cat_title_update,PDO::PARAM_STR);
                $stmupdate->bindParam(":cat_id",$id,PDO::PARAM_INT);
                $stmupdate->execute();
               
            }
            
            
            ?>
            <h2>All Categories</h2>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category name</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql="select *from categories;";
                    $statment=$PDO->prepare($sql);
                    $statment->execute();
                    while($row=$statment->fetch(PDO::FETCH_BOTH)):
                        $id=$row["cat_id"];
                        $cat_title=$row["cat_title"];
                    ?>
                <tr>
                    <th><?php echo $id; ?></th>
                    <td><?php echo $cat_title;?></td>
                    <td>
                        <form action="categories.php" method="post">
                        <input type="hidden" value="<?php echo $id;?>" name="id">
                            <input type="submit" value="update"  name="btn_update">

                        </form>
                   
                    </td>
                    
                    <td> 
                            <form action="categories.php" method="POST">
                                <input type="hidden" name="cat_id" value="<?php  echo $id;?>">
                            <input type="submit" value="Delete" name="Delete">
                             </form> 
                    
                </td>
                </tr>
              <?php endwhile;?>
                </tbody>
            </table>
        </section>
        <?php 

                      if(isset($_POST["Delete"])){
                        $cat_id=$_POST["cat_id"];
                        $sqldelete="delete from categories where cat_id=$cat_id;";
                        $stmdelete=$PDO->prepare($sqldelete);
                        $stmdelete->execute();
                        header("Location: index.php");
                      }
                      
                      ?>
    </div>
    <?php require("./include/footer.php");?>