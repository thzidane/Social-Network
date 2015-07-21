<?php
require 'database.php';
session_start();

$username=$_SESSION['username'];
//$str="$username";
$id = $_POST['Id'];
$story = $_POST['Content'];
$link = $_POST['Link'];

$filename = basename($_FILES['uploadedfile']['name']);
$full_path = sprintf("/home/xiexiangyu/public_html/Final/$username/%s", $filename);
$fullpath = sprintf("/~xiexiangyu/Final/$username/%s", $filename);

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("update story set story=? where id=? and username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sis',$story,$id,$username);
 
$stmt->execute();
$stmt->close();


$stmt = $mysqli->prepare("update links set link=? where story_id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('si', $link,$id);
 
$stmt->execute();
$stmt->close();


$stmt = $mysqli->prepare("select url from images where storyid =? ");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i',$id);
 
$stmt->execute();
$stmt->bind_result($first);
while($stmt->fetch()){
	$originalUrl = $first;			
	}
$stmt->close();

if( preg_match('/^[\w_\.\-]+$/', $filename) ){
	if(!isset($originalUrl)){
		$stmt = $mysqli->prepare("insert into images (storyid,username,url) values (?,?,?)");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('iss', $id,$username,$fullpath);
		 
		$stmt->execute();
		 
		$stmt->close();
	}else{
		if(!(strcmp($fullpath,$originalUrl)==0)){
		if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
			echo "upload successfully";
			$str = "$filename\n";
		}else{
			echo "upload failure";	
		}
		$stmt = $mysqli->prepare("update images set url=? where storyid=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('si', $fullpath,$id);
		 
		$stmt->execute();
		 
		$stmt->close();
	}
	}
	
	

}


 
header("Location: loginuserview.php");
exit; 
?>

