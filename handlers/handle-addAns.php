<?php
session_start();

require_once "../Inc/dbConnection.php";


if(isset($_POST['submit']) && isset($_GET['id'])){
    $userID=$_SESSION['userID'];
    $id=$_GET['id'];
    $content=$_POST['content'];

    $errors=[];

    if(empty($content)){
        $errors[]="Answer Body is required";
    }

    if(empty($errors))
    {
        $query="INSERT INTO `ans` (`ansDetails`, `user_id`, `Q_ID`) VALUES ('$content', $userID, $id)";
        $runquery=mysqli_query($conn, $query);
        if($runquery){
            header("location:../DisplayQuestion.php?id=$id");
        }
        else{
            $errors[]="No content";
            $_SESSION['errors'] = $errors;
            header("location:../DisplayQuestion.php");
        }
    }
    
    else{
        $_SESSION['errors'] = $errors;
        header("location:../DisplayQuestion.php");
    }
}

?>