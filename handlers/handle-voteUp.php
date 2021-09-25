<?php

session_start();

require_once "../Inc/dbConnection.php";

if(isset($_GET['ansID']) && !empty($_SESSION['userID'])){
    
    $ansID=$_GET['ansID'];
    $questID= $_SESSION['questID'];

    $Query = "INSERT INTO `votes` (`vote_up`, ans_id) VALUES (1, $ansID)";
    $runQuery=mysqli_query($conn, $Query);

    if($runQuery){
        header("location:../DisplayQuestion.php?id=$questID");
    }

}

?>