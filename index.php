<?php
session_start();
require_once "Inc/dbConnection.php";

$QuestQuery="SELECT * FROM `questions`";
$runQuery=mysqli_query($conn, $QuestQuery);
$Questions=mysqli_fetch_all($runQuery, MYSQLI_ASSOC);
//print_r($Questions);

?>

<?php
require_once "Inc/header.php";
?>
    <section id="home">
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


        <header>
          <div class="bg-img">
              <img class="img-fluid" src="images/action.png">
              <div class="caption w-50">
                  <h4 class="ml-4">Share & grow the world's knowledge!</h4>
                  <p class="ml-4">We want to connect the people who have knowledge to the people who need it, to bring together people with different perspectives so they can understand each other better, and to empower everyone to share their knowledge.</p>
              </div>
              <div class="ask-button">
              <?php if(!isset($_SESSION['userID'])) {?>
                  <a class="btn btn-primary" href="signUp.php">Create A New Account</a>
                  <?php } ?>
              </div>
          </div>
        </header>
    </section>
    

    <section id="body">
        <div class="container bg-white">
            <div class="row px-5 py-5 my-5">
                <div class="col-md-2 mt-5">
                  <a href="profile.php">Profile</a><br>
                  <a href="index.php">Questions</a>
                </div>
                <div class="col-md-10 ">
                <?php if(isset($_SESSION['userID'])) {?>
                  <a class="btn btn-primary mb-4 float-right mt-5" href="addQuestions.php">Ask a Question</a>
                  <?php } ?>

                  <?php 
                  $per_page=4;
                  $Query="SELECT * FROM `questions`";
                  $runQuery=mysqli_query($conn, $Query);
                  $numofQueries=mysqli_num_rows($runQuery);

                  $numofPages= ceil($numofQueries/$per_page);

                  if(!isset($_GET['page'])){
                    $page=1;
                  }else{
                    $page=$_GET['page'];
                  }

                  $first_row=($page-1)* $per_page;

                  $Query="SELECT * from `questions` LIMIT $first_row, $per_page";
                  $runQuery=mysqli_query($conn, $Query) or die( mysqli_error($conn));

                  while($row = mysqli_fetch_array($runQuery)){
                    echo '<br><a class="text-decoration-none" name="submit" href="DisplayQuestion.php?id= '. $row['Quest_id'] . '">' . $row['Title'] . "</a><br>" . '<p small class="text-muted">' . $row['created_at'] . '</p>' ;
                    echo "<p>_______________________________________________________</P>";
                  }

                  for($page=1; $page<=$numofPages; $page++){
                    echo '<a class="btn btn-primary float-right ml-2" href="index.php?page= '. $page .'">' . $page . '</a>';
                  }
?>

                </div>
            </div>
        </div>
    </section>


<?php
require_once "Inc/footer.php";
?>