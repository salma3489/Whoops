<?php

session_start();
require_once "../Inc/dbConnection.php";

if(isset($_POST['submit'])){
    $userID = $_SESSION['userID'];
    $pass=$_POST['password'];
    $newpass=$_POST['NewPass'];
    $confirmNewPass=$_POST['confirmNewPass'];
    
    $QuestQuery="SELECT `password` FROM `users` WHERE `id`=$userID";
    $runQuery=mysqli_query($conn, $QuestQuery);
    $user=mysqli_fetch_assoc($runQuery);
    $userpass=$user['password'];

    $errors=[];
    
    if(empty($pass)){
        $errors[]="pass is required";
    }

    if(empty($newpass)){
        $errors[]="Confirmation password is required";
    }   

    if(empty($confirmNewPass)){
        $errors[]="Confirmation password is required";
    }
    else if($newpass != $confirmNewPass){
        $errors[] = "password doesn't match";
    }

    if(empty($errors))
    {
        $newHash = password_hash($newpass, PASSWORD_DEFAULT);

        $iscorrect=password_verify($pass, $userpass);

        if($iscorrect){
            $Query = "UPDATE `users` SET `password` = '$newHash' WHERE `id` = $userID";
            $runQuery = mysqli_query($conn, $Query);
            
            if($runQuery)
            {
                header("location:../profile.php");
            }
            else{
                $errors[] = "password is wrong";
                $_SESSION['errors'] = $errors;
                header("location:../changepass.php");
            }
        }
        else{
            $errors[] = "password is wrong";
            $_SESSION['errors'] = $errors;
            header("location:../changepass.php");
        }
    }
    else
    {
        $_SESSION['errors'] = $errors;
        header("location:../changepass.php");
    }
}
?>