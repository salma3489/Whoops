<?php

session_start();
require_once "../Inc/dbConnection.php";

if(isset($_POST['submit']) && isset($_GET['id'])){
    $id = $_GET['id'];
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
        
        $editquestQuery = "UPDATE `questions` SET  `Title`= '$title', `QuestDetails` = '$content' WHERE `Quest_id` = $id";
        $editquestRunQuery = mysqli_query($conn, $editquestQuery);

        if($editquestRunQuery)
        {
            header("location:../myquestion.php");
        }
        else
        {
            $errors[]="error in database";
            $_SESSION['errors'] = $errors;
            header("location:../editQuestion.php");
        }
        
    }
    else
    {
        $_SESSION['errors'] = $errors;
        header("location:../editQuestion.php");
    }
}


?>