<?php

session_start();

require_once "../Inc/dbConnection.php";

if(isset($_GET['ansID']) && !empty($_SESSION['userID'])){
    
    $ansID=$_GET['ansID'];
    $questID= $_SESSION['questID'];

    $Query = "DELETE FROM `votes` WHERE `ans_id`=$ansID AND `vote_up`=1 LIMIT 1";
    $runQuery=mysqli_query($conn, $Query);

    if($runQuery){
        header("location:../DisplayQuestion.php?id=$questID");
    }

}

?>