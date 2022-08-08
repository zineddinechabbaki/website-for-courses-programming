<?php require_once("./include/header.php");?>

    <div class="container">

        <h2 class="text-uppercase mt-5 sign-in" style="text-align:center">Sign In</h2>
        <?php
if(isset($_POST["submit"])){
    $user_name=$_POST["username"];
    $user_email=$_POST["email"];
    $user_password=$_POST["password"];
    if(empty($user_name) || empty($user_email)  || empty($user_password)){
        echo "<div class='alert alert-danger'>please Don't let your inforamtion empty !</div>";
    }
    else{
        $sql="select*from users";
        $stm=$PDO->prepare($sql);
        $stm->execute();
        while($row=$stm->fetch(PDO::FETCH_BOTH)){
            // user_name,user_email,user_password
            $name=$row["user_name"];
            $email=$row["user_email"];
            $password=$row["user_password"];
            if($name==$user_name && $email==$user_email && $password==$user_password){
                setcookie("user",md5(1),time()+60,"/");
                header("Location: index.php");
                
            }else{
                echo "<div class='alert alert-danger'>the Information is not correct !</div>";
            }


       
        }
    }


}

?>

        <form class="py-2 d-flex justify-content-center flex-column" action="sign-in.php" method="POST">
            <div class="form-group m-3">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username">
            </div>
            <div class="form-group m-3">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email Address">
            </div>
            <div class="form-group m-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary m-3 align-self-end">SIGN IN</button>
        </form>
    </div>
    
<?php require_once("./include/footer.php"); ?>