<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta http-equiv=refresh content="3; url=index.html">
    <title>Log out</title>
    <style type="text/css">
    
    p{
	text-indent: 25px;
      }
    </style>
</head>
<body>
<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
echo "<p>";
echo "Log out successfully!";
echo "</p>";
//header("refresh:3;Location:module3login.php");
//exit;
?>
<p>
<a href=index.html>Click here if not redirect.</a>
</p>

</body>
</html>