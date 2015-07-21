<?php
// This is a *good* example of how you can implement password-based user authentication in your web application.
session_start();
$_SESSION['username'] = $_POST['loginname'];
$username = $_SESSION['username'];
$_SESSION['token'] = substr(md5(rand()), 0, 10); 
require 'database.php';
 
// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE username=?");
 
// Bind the parameter
$stmt->bind_param('s', $username);
//$user = $_POST['username'];
$stmt->execute();
 
// Bind the results
$stmt->bind_result($cnt, $pwd_hash);
$stmt->fetch();
 
$pwd_guess = $_POST['loginpassword'];
// Compare the submitted password to the actual password hash
if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
	// Login succeeded!
	//$_SESSION['user_id'] = $user_id;
	// Redirect to your target page
        header("Location: loginuserview.php");
        exit; 
}else{
	header("Location: index.html");
        exit; 
        // Login failed; redirect back to the login screen
}
?>