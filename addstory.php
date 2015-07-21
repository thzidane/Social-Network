<?php
require 'database.php';
session_start();
//----------------------------------add story into database---------------------
$username=$_SESSION['username'];
$story = $_POST['addContent'];
//$info = $_POST['addTitle'];
//$category = $_POST['addCategory'];

$filename = basename($_FILES['uploadedfile']['name']);


if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$full_path = sprintf("/home/xiexiangyu/public_html/Final/$username/%s", $filename);
$fullpath = sprintf("/~xiexiangyu/Final/$username/%s", $filename);


$stmt = $mysqli->prepare("insert into story (username,story) values (?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss',$username,$story);
 
$stmt->execute();
$stmt->close();



//-----------------------------select new story id from database;---------------------
$username=$_SESSION['username'];
$story = $_POST['addContent'];
//$info = $_POST['addTitle'];
//$category = $_POST['addCategory'];

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("select id from story where username=? and story=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss',$username,$story);
 
$stmt->execute();

$stmt->bind_result($first);

while($stmt->fetch()){
	$num=$first;
	//echo $num;
	}
$stmt->close();




//--------------------------------add link url -------------------------------------------------
$link=$_POST['addLink'];
$stmt = $mysqli->prepare("insert into links (story_id,link) values(?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('is', $num, $link);
 
$stmt->execute();
 
$stmt->close();

//-------------------------------select all username from users-----------------------------------
$stmt = $mysqli->prepare("select username from users ");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();

 
$result = $stmt->get_result();
$user_name = array();
while($row = $result->fetch_assoc()){	
    $user_name[]=$row["username"];
}
    
$stmt->close();
//----------------------------create new rows in likestories;------------------------------------------
for($i=0; $i<count($user_name); $i++){
$stmt = $mysqli->prepare("insert into likestories (username,story_id) values (?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('si',$user_name[$i],$num);
 
$stmt->execute();
 $stmt->close();
}

//-------------------------------add image if you have--------------------------------------------

if( preg_match('/^[\w_\.\-]+$/', $filename) ){
	
	if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
		echo "upload successfully";
		$str = "$filename\n";
	}else{
		echo "upload failure";	
	}
	$stmt = $mysqli->prepare("insert into images (storyid,username,url) values(?,?,?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('iss', $num,$username, $fullpath);
	 
	$stmt->execute();
	 
	$stmt->close();

}




header("Location: loginuserview.php");
exit; 
?>