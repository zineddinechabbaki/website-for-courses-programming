<a class="navbar-brand" href="index.php" style="font-size: 22px">Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <?php 
            $sql="select*from categories;";
            $statment=$PDO->prepare($sql);
            $statment->execute();
            while($row=$statment->fetch(PDO::FETCH_BOTH)):
                $cat_id=$row[0];
                $cat_title=$row[1];
                
            
            ?>
            <li class="nav-item active">
              <a class="nav-link" href="categories.php?id=<?php echo $cat_id; ?>"><?php echo $cat_title ?></a>
            </li>
            <?php endwhile;?>

            <!-- <li class="nav-item">
              <a class="nav-link" href="#">JavaScript</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">NodeJS</a>
            </li> -->
          </ul>
          <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
            <input class="form-control mr-sm-2" style="font-size: 14px" type="search" placeholder="Search" aria-label="Search" name="zt_search" >
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>