<?php
$host="localhost";
$db="chat_app";
$user="root";
$pass="";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    die("Connection Failed".$conn->connect_error);
}
?>