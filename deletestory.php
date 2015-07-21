<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta http-equiv=refresh content="3;url=loginuserview.php">
        
    <title>Delete story</title>
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
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
$username = $_SESSION['username'];
$str="$username";
$id = $_POST['deletestory'];

//-------------------------make sure that only the author can delete the story---------
$stmt = $mysqli->prepare("select username from story where id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i',$id); 
$stmt->execute();
$stmt->bind_result($first);

if(!$stmt->fetch()){
    
    echo "Please enter correct story id.";
}else{
    $str2=$first;
	
$stmt->close();

if(strcmp($str,$str2)==0){
//---------------------------------------delete story-------------------------------
    $stmt = $mysqli->prepare("delete from story where id=? and username=?");
    if(!$stmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
    	exit;
    }
    
    $stmt->bind_param('is',$id,$str);
     
    $stmt->execute();

        $stmt->close();
    //-----------------------------delete rows associate with that id in likestories----------------------------------------
    
    $stmt = $mysqli->prepare("delete from likestories where story_id=?");
    if(!$stmt){
      	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
    
    $stmt->bind_param('i',$id);
     
    $stmt->execute();
    
    $stmt->close();
    
//--------------------------------------delete comment associate with that id--------------------------------
    $stmt = $mysqli->prepare("delete from comment where story_id=?");
    if(!$stmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }

    $stmt->bind_param('i',$id);
 
    $stmt->execute();

    $stmt->close();
//------------------------------------delete images associate with that id---------------------------------
    $stmt = $mysqli->prepare("delete from images where storyid=?");
    if(!$stmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }

    $stmt->bind_param('i',$id);
 
    $stmt->execute();

    $stmt->close();
    
    
    echo "<p>";
    echo "delete story successfully!";
    echo "</p>";



        
//header ("Location: module3loginuserview.php");
//exit; 
 
}else{
    echo "<p>";
    echo "you are not the author of this story, you cannot delete it.";
    echo "</p>";
}
}
?>
    <p>
       <a href=loginuserview.php>Click here if not redirect.</a>
    </p>

  
    
</body>
</html>