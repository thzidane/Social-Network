<?php
session_start();
$file1 = $_POST['deletefile'];
$username = $_SESSION['username'];

if (!unlink($file1)){
  echo ("Error deleting $file1");
}
  else{
  echo ("Deleted $file1");  

  $DELETE = $file1;

     $data = file("$username.txt");

     $out = array();

     foreach($data as $line) {
         if(trim($line) != $DELETE) {
             $out[] = $line;
         }
     }

     $fp = fopen("$username.txt", "w+");
     flock($fp, LOCK_EX);
     foreach($out as $line) {
         fwrite($fp, $line);
     }
     flock($fp, LOCK_UN);
     fclose($fp);  
  }
?>