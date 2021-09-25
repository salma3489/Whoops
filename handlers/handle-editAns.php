<?php

session_start();
require_once "../Inc/dbConnection.php";

if(isset($_POST['submit']) && isset($_GET['id'])){
    $id = $_GET['id'];
    $content=$_POST['content'];

    $errors=[];

    if(empty($content)){
        $errors[]="Answer Body is required";
    }


    if(empty($errors))
    {
        
        $editquestQuery = "UPDATE `ans` SET  `ansDetails`= '$content' WHERE `ID` = $id";
        $editquestRunQuery = mysqli_query($conn, $editquestQuery);

        if($editquestRunQuery)
        {
            header("location:../profile.php");
        }
        else
        {
            $errors[]="error in database";
            $_SESSION['errors'] = $errors;
            header("location:../editAns.php");
        }
        
    }
    else
    {
        $_SESSION['errors'] = $errors;
        header("location:../editQuestion.php");
    }
}


?>