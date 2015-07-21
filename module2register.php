<?php
session_start();
$_SESSION['username'] = $_GET['loginname'];
$username = $_SESSION['username'];
$h = fopen("users.txt", "r");
echo "<ul>\n";
while( !feof($h) ){
	$str0 = trim(fgets($h)," \t\n\r\0\x0B" );
	if(strcmp($username,$str0)==0){               
               header("Location: module2usersview.php");
               exit; 
	}
}
echo "no such user";

echo "</ul>\n";
 
fclose($h);

?>