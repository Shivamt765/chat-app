<?php
include "includes/db.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $sql="INSERT INTO users(username,password) VALUES('$username','$password')";
    if($conn->query($sql)==TRUE){
        header("Location:login.php");
    }else{
        echo "Error:".$sql."<br>".$conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<form method="post" action="">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="password">
    <button type="submit">Register</button>
</form>
</body>
</html>