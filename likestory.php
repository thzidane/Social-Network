<?php
require 'database.php';
session_start();
$storyid = $_POST['storyid'];
$username = $_SESSION['username'];


if($_SESSION['token'] !== $_POST['token']){
	die("<br/>Request forgery detected");
}

$stmt = $mysqli->prepare("select islike from likestories where story_id =? and username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('is', $storyid,$username);
$stmt->execute();
$stmt->bind_result($haha);
echo "<ul>\n";
while($stmt->fetch()){
	$str=$haha;
}
echo "<ul>\n";

$stmt->close();

if(strcmp($str,'no')==0){
$stmt = $mysqli->prepare("select likestory from story where id =?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('i', $storyid);

$stmt->execute();

$stmt->bind_result($first);
 
echo "<ul>\n";
while($stmt->fetch()){
	$num=$first+1;
}
echo "</ul>\n";
$stmt->close();

 
$stmt = $mysqli->prepare("update story set likestory=? where id =?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ii', $num,$storyid);
 
$stmt->execute();
 
 echo "</ul>\n";
 
$stmt->close();


$stmt = $mysqli->prepare("update likestories set islike='yes' where story_id =? and username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('is', $storyid,$username);
 
$stmt->execute();
 
 echo "</ul>\n";
 
$stmt->close();



header("Location: loginuserview.php");
exit;
}else{
	
	$stmt = $mysqli->prepare("select likestory from story where id =?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $storyid);

	$stmt->execute();

	$stmt->bind_result($first);
 
	echo "<ul>\n";
	while($stmt->fetch()){
		$num=$first-1;
	}
	echo "</ul>\n";
	$stmt->close();
	
?>
	
<?php
require 'database.php';
 
$stmt = $mysqli->prepare("update story set likestory=? where id =?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ii', $num,$storyid);
 
$stmt->execute();
 
 echo "</ul>\n";
 
$stmt->close();

$stmt = $mysqli->prepare("update likestories set islike='no' where story_id =? and username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('is', $storyid,$username);
 
$stmt->execute();
 
 echo "</ul>\n";
 
$stmt->close();

header("Location: loginuserview.php");
exit;
	
}
?>
