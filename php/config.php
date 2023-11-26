<?php
$host_name='localhost';
$user_name='root';
$password='';
$db_name='guvi';
$con=mysqli_connect($host_name,$user_name,$password,$db_name);
if(!$con)
{
    die('connection failed'.$con->connect_error);
}
?>