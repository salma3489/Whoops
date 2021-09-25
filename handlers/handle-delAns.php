<?php

session_start();
require_once "../Inc/dbConnection.php";

if(isset($_GET['id'])){
    $id=$_GET['id'];

    $Query="DELETE FROM `ans` where `ID`=$id";
    $runQuery=mysqli_query($conn, $Query);
    header("location:../profile.php");
    
}

?>