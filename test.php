<?php
require 'database.php';
$id = 51;
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
echo "url is exist?<br/>";
echo $originalUrl;
echo "<br/>";
echo empty($originalUrl);
echo "<br/>";
echo false;

if(!isset($originalUrl)){
    echo "the orignal url is not added.";
}
if(empty($originalUrl)){
    echo "<br/>";
    echo "hello please set the url";
}
?>