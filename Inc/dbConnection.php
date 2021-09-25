<?php

header("Access_Control_Allow_Origin: *");
//header("Content-Type:Application/json; charset=UTF-8");

$conn=mysqli_connect("localhost","root","","Whoops!");

if(!$conn){
    die("Error in connection");
}

?>