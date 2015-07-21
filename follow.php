<?php
require 'database.php';
session_start();
$username = $_SESSION['username'];
$first = $_POST['follow'];

//echo $first;

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("insert into followers (username, followby) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
echo "test";
$stmt->bind_param('ss', $username, $first);
 
$stmt->execute();
 
$stmt->close();

header("Location:loginuserview.php");
exit;
 
?>