<?php
session_start();
require_once "../Inc/dbConnection.php";

if(isset($_POST['submit'])){
    $email=$_POST['email'];
    $pass=$_POST['password'];
    $userHashPass=password_hash($_POST['password'], PASSWORD_DEFAULT);

    $Query="SELECT * FROM `users` WHERE email='$email'";
    $runQuery=mysqli_query($conn, $Query);
    if(mysqli_num_rows($runQuery)>0){
        $user=mysqli_fetch_assoc($runQuery);
        $userHashPass=$user['password'];
        $iscorrect=password_verify($pass,$userHashPass);
        if($iscorrect){
            $_SESSION['userID']=$user['id'];
            header("location:../index.php");
        }
        else{
            $errors="Password Not Match";
            $_SESSION['errors']=$errors;
            header("location:../Login.php");
        }
    }
    else{
        $errors="Email Not Match";
        $_SESSION['errors']=$errors;
        header("location:../Login.php");
    }
}



?>