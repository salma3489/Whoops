

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
    $userquery = "SELECT * FROM `users` WHERE `id` = $userID";
     $userRunQuery = mysqli_query($conn, $userquery);
    $current_user = mysqli_fetch_assoc($userRunQuery);

    $QuestQuery="SELECT * FROM `questions` WHERE `user_id`=$userID";
    $runQuery=mysqli_query($conn, $QuestQuery);
    $Questions=mysqli_fetch_all($runQuery, MYSQLI_ASSOC);

    $ansQuery="SELECT * FROM `ans`";
    $ansrunQuery=mysqli_query($conn, $ansQuery);
    $answers=mysqli_fetch_all($ansrunQuery, MYSQLI_ASSOC);
      
    
    $questQuery="SELECT count(`Quest_id`) as total FROM `questions` WHERE `user_id`=$userID";
    $quetRunQuery = mysqli_query($conn, $questQuery);
    $current_quest=mysqli_fetch_assoc($quetRunQuery);

    $ansQuery="SELECT count(`ID`) as total FROM `ans` WHERE `user_id`=$userID";
    $ansRunQuery = mysqli_query($conn, $ansQuery);
    $current_ans=mysqli_fetch_assoc($ansRunQuery);
?>

<div class="container bg-white">
    <div class="row py-3 my-5">
        <div class="col-md-2">
            <a href="profile.php">Profile</a><br>
            <a href="DisQuest.php">users</a><br>
            <a href="index.php">Questions</a>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-2">
                    <img class="w-75 h-100" src="images/<?= $current_user['img'] ?>">
                </div>
                <div class="col-md-8">
                    <h1><?= $current_user['Username'] ?></h1>
                    <p>member at <?= $current_user['created_at'] ?></p>
                    <a class="btn btn-primary float-right ml-2" href="changepass.php">Change Password</a>
                    <a class="btn btn-primary float-right" href="EditProfile.php">Edit Profile</a>
                </div>
                <div class="activity mt-5">
                    <div class="activity-item mt-5">
                        <a class="btn mr-3" href="profile.php">Answers(<?php echo $current_ans['total'] ?>)</a>
                        <a class="btn mr-3" href="myquestion.php">Questions(<?php echo $current_quest['total'] ?>)</a>
                    </div>
                </div>
                
                <div class="MyQuestions mt-4 ml-2">

                    <?php 
                    
                    $per_page=4;
                    $Query="SELECT * FROM `questions` WHERE `user_id`=$userID";
                    $runQuery=mysqli_query($conn, $Query);
                    $numofQueries=mysqli_num_rows($runQuery);

                    $numofPages= ceil($numofQueries/$per_page);

                    if(!isset($_GET['page'])){
                        $page=1;
                    }else{
                        $page=$_GET['page'];
                    }

                    $first_row=($page-1)* $per_page;

                    $Query="SELECT * from `questions` WHERE `user_id`=$userID LIMIT $first_row, $per_page";
                    $runQuery=mysqli_query($conn, $Query) or die( mysqli_error($conn));
                    
                    while($row = mysqli_fetch_array($runQuery)){?>
                        <?php echo $row['Title'] ?>
                        <p small class="text-muted"><?php echo $row['created_at'] ?></p>
                        <a href="handlers/handle-delQuestion.php?id=<?= $row['Quest_id'] ?>">Delete</a>
                        <a href="editQuestion.php?id=<?= $row['Quest_id'] ?>">Edit</a><?php
                        echo "<p>_______________________________________________________</P>";
                    
                    }
                    for($page=1; $page<=$numofPages; $page++){
                        echo '<a class="btn btn-primary" href="myquestion.php?page= '. $page .'">' . $page . '</a>';
                        echo " ";
                    }
                
                    ?>                    
                </div>
            </div>
            
        </div>
    </div>
</div>




<?php
require_once "Inc/footer.php";
?>
