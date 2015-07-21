<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <!--<meta http-equiv=refresh content="3; url=index.html">-->
        
    <title>New User Registered!</title>
    <style type="text/css">    
    p{
	text-indent: 25px;
      }
    </style>
</head>
<body>
<?php
//create the user with crypt password
require 'database.php';
 
$username = $_POST['registername'];
$password = $_POST['registerpassword'];
$hashpassword = crypt("$password", '$1$WQvMDFgI$5.mVOS7V2Q/aB78Mxl13Q1');
$str = "$username\n";

if( !preg_match('/^[\w_\.\-]+$/', $username) ){
	echo "<p>";
	echo "Invalid username";
	echo "</p>";
	exit;
}

mkdir("/srv/$username",0777);
chmod("/srv/$username",0777);
//fopen("/srv/$username/$username.txt","a");
mkdir("/home/xiexiangyu/public_html/Final/$username",0777);
chmod("/home/xiexiangyu/public_html/Final/$username",0777);
    
$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss', $username, $hashpassword);
 
$stmt->execute();
 
$stmt->close();
        

//I add new code from here
//select all the id from table story.
$stmt = $mysqli->prepare("select id from story");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
    $storyid9[]=$row["id"];
}
$stmt->close();

//create new rows in likestories.
for($i=0; $i<count($storyid9); $i++){
	$stmt = $mysqli->prepare("insert into likestories (username, story_id) values (?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('si', $username, $storyid9[$i]);
	 
	$stmt->execute();

	$stmt->close();
}

echo "<p>";
echo "Create new user successfully!";
echo "</p>";
//this two line are original ones;
//header("Location: module3login.php");
//exit;
?>
<p>
       <a href=index.html>Click here if not redirect.</a>
</p>

    </body>
</html>