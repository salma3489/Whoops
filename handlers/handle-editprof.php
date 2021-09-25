<?php

session_start();
require_once "../Inc/dbConnection.php";

if(isset($_POST['submit'])){
    $userID = $_SESSION['userID'];
    $editUsername=$_POST['editusername'];
    $editemail=$_POST['editemail'];
    $img = $_FILES['editimg'];
    
    $imgName = $img['name'];
    $imgType = $img['type'];
    $imgTmpname = $img['tmp_name'];
    $imgSize = $img['size'];
    $imgError = $img['error'];
    $imgSizemb = $imgSize / (1024**2);
    
    $randStr = uniqid();
    $ext = pathinfo($imgName, PATHINFO_EXTENSION);
    $date=time();

    $errors=[];
    
        
     if(empty($editUsername)){
         $errors[]="username is required";
     }
    if(is_numeric($editUsername)){
        $errors[] = "username must be string";
    }

    if(empty($editemail)){
        $errors[]="email is required";
    }
    else if(!filter_var($editemail, FILTER_VALIDATE_EMAIL)){
        $errors[] = "email must be string";
    }

    // if($imgError > 0){
    //     $errors = "There is error while uploading";
    // }
    // else if($imgSizemb > 1){
    //     $errors = "Size must be less than 1mb";
    // }
    // else if(!in_array(strtolower($ext), ['jpg', 'png', 'jpeg', 'gif'])){
    //     $errors = "must be image";
    // }

    

    if(empty($errors))
    {
        if(!empty($imgName))
        {
            $imgNewname = "$date$randStr.$ext";
            move_uploaded_file($imgTmpname,"../images/$imgNewname");

            $edituserQuery = "UPDATE `users` SET `Username` = '$editUsername', `email`= '$editemail', `img`='$imgNewname' WHERE `id` = $userID";
            $edituserRunQuery = mysqli_query($conn, $edituserQuery);

            if($edituserRunQuery)
            {
                header("location:../profile.php");
            }
            else
            {
                header("location:../EditProfile.php");
            }
        }
        else
        {
            $edituserQuery = "UPDATE `users` SET `Username` = '$editUsername', `email`= '$editemail' WHERE `id` = $userID";
            $edituserRunQuery = mysqli_query($conn, $edituserQuery);

            if($edituserRunQuery)
            {
                header("location:../profile.php");
            }
            else
            {
                header("location:../EditProfile.php");
            }
        }
    }
    else
    {
        $_SESSION['errors'] = $errors;
        header("location:../EditProfile.php");
    }
}


?>