<?php
session_start();

require_once "../Inc/dbConnection.php";

if(isset($_POST['submit'])){
    $userID=$_SESSION['userID'];
    $title=$_POST['Title'];
    $content=$_POST['content'];

    $errors=[];

    if(empty($title)){
        $errors[]="Title is required";
    }

    if(empty($content)){
        $errors[]="Question Body is required";
    }

    if(empty($errors))
    {
        $query="INSERT INTO `questions` (`Title`, `QuestDetails`, `user_id`) VALUES ('$title','$content', $userID)";
        $runquery=mysqli_query($conn, $query);
        if($runquery){
            // $questID=mysqli_insert_id($conn);
            // $_SESSION['questID']=$questID;
            header("location:../index.php");
        }
        else{
            header("location:../addQuestions.php");
        }
    }
    
    else{
        $_SESSION['errors'] = $errors;
        header("location:../addQuestions.php");
    }
}

?>