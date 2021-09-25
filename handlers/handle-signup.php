<?php

session_start();

require_once "../Inc/dbConnection.php";
if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email=$_POST['email'];
        $pass=$_POST['password'];
        $confirm=$_POST['confirmPass'];
        $age=$_POST['age'];
        $gender=$_POST['gender'];
        $img = $_FILES['img'];
    
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
    
        
        if(empty($username)){
            $errors[]="username is required";
        }
        else if(is_numeric($username)){
            $errors[] = "username must be string";
        }
    
        if(empty($email)){
            $errors[]="email is required";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "email must be string";
        }
    
        if(empty($pass)){
            $errors[]="pass is required";
        }
        else if (strlen($pass)>5 || strlen($pass)>50){
            $errors[] = " pass be in range [5-50]";
        }
    
        if(empty($confirm)){
            $errors[]="Confirmation password is required";
        }
        else if (strlen($confirm)>5 || strlen($confirm)>50){
            $errors[] = "Confirm pass should be in range [5-50]";
        }
        else if($pass != $confirm){
            $errors[] = "password doesn't match";
        }
    
        if(empty($age)){
            $errors[]="age is required";
        }
        else if(! is_numeric($age)){
            $errors[] = "age must be num";
        }else if($age<20 || $age>100){
            $errors[] = "age must be in range of 20-100";
        }
    
    
        if(empty($gender)){
            $errors[]="gender is required";
        }
        else if(! in_array($gender,['male','female'])){
            $errors[] = "gender must be male or female";
        }
    
        if($imgError > 0){
            $errors = "There is error while uploading";
        }
        else if($imgSizemb > 1){
            $errors = "Size must be less than 1mb";
        }
        else if(!in_array(strtolower($ext), ['jpg', 'png', 'jpeg', 'gif'])){
            $errors = "must be image";
        }
    
        if(empty($errors)){
            
            $imgNewname = "$date$randStr.$ext";
            move_uploaded_file($imgTmpname,"../images/$imgNewname");
    
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $conHash = password_hash($confirm, PASSWORD_DEFAULT);
    
            $query="INSERT INTO `users` (`username`, `email`, `password`, `confirm`, `age`, `gender`, `img`) VALUES ('$username', '$email', '$hash', '$conHash', $age, '$gender', '$imgNewname')";
            $runQuery= mysqli_query($conn, $query);
    
            if($runQuery)
            {
                $userID=mysqli_insert_id($conn);
                $_SESSION['userID']=$userID;
                header("location:../index.php");
            }
            else
            {
                header("location:../signUp.php");
            }
        }
    
        else{
            $_SESSION['errors'] = $errors;
            header("location:../signUp.php");
        }
    }
}
else
{
    http_response_code(404);
}

?>