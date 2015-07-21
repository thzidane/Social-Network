<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	
    <title>Add comment successfully!</title>
    <style type="text/css">
    p{
	text-indent: 25px;
      }
    </style>
    
</head>
<body>

<?php
require 'database.php';
session_start();
$username = $_SESSION['username'];
$first = $_POST['addcomment'];
$last = $_POST['storyid'];

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("insert into comment (username, comment, story_id) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssi', $username, $first, $last);
 
$stmt->execute();
 
$stmt->close();

//header("Location:module3registerstoryview.php");
//exit;

echo "<p>";
echo "Comment added successfully!";
echo "<p>";
 header("Location: loginuserview.php");
        exit; 

?>

<!--<p>-->
<!--<a href=module3loginuserview.php>Click here if not redirect.</a>-->
<!--</p>-->


</body>
</html>