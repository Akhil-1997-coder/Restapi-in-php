<?php
$server = 'localhost';
$username = 'root';
$password = '';
$db = 'api';

$conn= mysqli_connect($server,$username,$password,$db);
if(!$conn)
{
    die("Could not Connect:".mysqli_errno($conn));
}
?>