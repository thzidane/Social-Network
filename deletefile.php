<?php
session_start();
$file1 = $_POST['deletefile'];
$username = $_SESSION['username'];
$filename = "/srv/$username/$file1";

            
if( !preg_match('/^[\w_\.\-]+$/', $file1) ){
	echo "Invalid filename";
	exit;
}elseif (!unlink($filename)){
  echo ("Error deleting $file1");
}
  else{
  echo ("Deleted $file1");  

  $DELETE = $file1;

     $data = file("/srv/$username/$username.txt");

     $out = array();

     foreach($data as $line) {
         if(trim($line) != $DELETE) {
             $out[] = $line;
         }
     }

     $fp = fopen("/srv/$username/$username.txt", "w+");
     flock($fp, LOCK_EX);
     foreach($out as $line) {
         fwrite($fp, $line);
     }
     flock($fp, LOCK_UN);
     fclose($fp);
  }
  
header("Location: usersview.php");
exit;
  
?>