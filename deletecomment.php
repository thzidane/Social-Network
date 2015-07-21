<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta http-equiv=refresh content="3; url=loginuserview.php">
        
    <title>Delete Comment</title>
    <style type="text/css">
    
    p{
	text-indent: 25px;
      }
    </style>
</head>
<body>


<?php

session_start();
require 'database.php';
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$username = $_SESSION['username'];
$str="$username";
$id = $_POST['deletecomment'];

//-------------------------make sure that only the user can delete the comment---------
$stmt = $mysqli->prepare("select username from comment where comment_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i',$id); 
$stmt->execute();
$stmt->bind_result($first);

if(!$stmt->fetch()){
    echo "<ul>\n";
    echo "Please enter correct comment id.";
}else{
    $str2=$first;
	
$stmt->close();

if(strcmp($str,$str2)==0){
//---------------------------------------delete comment-------------------------------
    $stmt = $mysqli->prepare("delete from comment where comment_id=? and username=?");
    if(!$stmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
    	exit;
    }
    
    $stmt->bind_param('is',$id,$str);
     
    $stmt->execute();
    
    $stmt->close();
    
    echo "<p>";
    echo "delete comment successfully!";
    echo "</p>";
 
}else{
    echo "<p>\n";
    echo "you are not the author of this comment, you cannot delete it.";
    echo "</p>";
}
}
?>
    <p>
        <a href=loginuserview.php>Click here if not redirect.</a>
    </p>
    
  
    
</body>
</html>
