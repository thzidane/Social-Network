<?php
require 'database.php';
session_start();
$username = $_SESSION['username'];
$first = $_POST['unfollow'];

//echo $first;

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("delete from followers where username = ? and followby = ?");
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