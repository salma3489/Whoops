
<?php
session_start();
require_once "Inc/dbConnection.php";
?>

<?php
require_once "Inc/header.php";
?>

<nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="index.php"><img src="images/Screenshot 2021-09-13 014732.png" alt="Whoops!.com"> </a>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-lg-0 mr-5 ml-5">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                  </li>
                  
                </ul>

              
                <form action="handlers/handle-search.php" method="GET">
	                  <input class="mx-5 w-100 " placeholder="Search for key word" type="text" name="query">
                </form>


                <?php
                if(!empty($_SESSION['userID'])){
                    $userID=$_SESSION['userID'];
                    $userquery = "SELECT * FROM `users` WHERE `id` = $userID";
                    $userRunQuery = mysqli_query($conn, $userquery);
                    if($current_user = mysqli_fetch_assoc($userRunQuery)){?>
                        <div class="userDetails ml-5">
                          <img class = "rounded-circle ml-5 w-25" src="images/<?= $current_user['img'] ?>">
                          <a href="profile.php" class="text-decoration-none text-white"><?= $current_user['Username'] ?></a>
                        </div>
              <?php }
                }?>
                

                <div class="sign-buttons ml-auto">
                <?php if(!isset($_SESSION['userID'])){?>
                <a class="btn btn-primary ml-5" href="Login.php">Login</a>
                <?php } ?>
                <?php if(!isset($_SESSION['userID'])){?>
                <a class="btn btn-primary" href="signUp.php">register</a>
                <?php } ?>

                    <?php if(isset($_SESSION['userID'])) {?>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                    <?php } ?>
                </div>
              </div>
            </div>
        </nav>

<?php

    $userID = $_SESSION['userID'];
    $userquery = "SELECT `id`, `Username`, `email`, `password`, `confirm`, `age`, `gender`, `img`, `created_at` FROM `users` WHERE `id` = $userID";
     $userRunQuery = mysqli_query($conn, $userquery);
    if($current_user = mysqli_fetch_assoc($userRunQuery)){
      
    }
?>

<style>
.activity-item{
    float: left;
}
</style>

<div class="container bg-white">
    <div class="row py-3 my-5">
        <div class="col-md-2">
            <a href="DisQuest.php">Profile</a><br>
            <a href="DisQuest.php">users</a><br>
            <a href="DisQuest.php">Questions</a>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-2">
                    <img class="w-75 h-100" src="images/<?= $current_user['img'] ?>">
                </div>
                <div class="col-md-8">
                    <h1><?= $current_user['Username'] ?></h1>
                    <p>member at <?= $current_user['created_at'] ?></p>
                </div>
                <div class="editprof mt-5">
                <?php if(isset($_SESSION['errors'])){?>
<div class="alert alert-danger w-25 m-5 ">
    <strong>
    <?php foreach($_SESSION['errors'] as $error) { ?>
        <p><?php echo $error ?></p>
    <?php } unset($_SESSION['errors']) ?>
    </strong>
</div>
<?php } ?>
                    <form action="handlers/handle-editprof.php" method="POST" enctype = "multipart/form-data">
                        <h4 class="mb-3">Edit Profile</h4>  
                        <div class="form-group">
                            Username <input name="editusername" type="text" class="form-control" value="<?= $current_user['Username'] ?>">
                        </div>     
                        <div class="form-group">
                            Email address <input type="text" name="editemail" class="form-control" value="<?= $current_user['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label font-weight-bold">Profile Picture</label>
                            <input type = "file" name = "editimg">
                        </div>
                        <div class="form-group mt-5">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
require_once "Inc/footer.php";
?>