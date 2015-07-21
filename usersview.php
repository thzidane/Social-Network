<!doctype html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <title>User View</title>
    <style type="text/css">      
a{
   text-decoration: none;
}
a:link,a:visited{
   color: darkgray;
}
a:hover,a:active{
   color: dimgrey;
}
    </style>
</head>
<body>
       
    
   <form name="form0" method="POST" action="loadingfile.php">
  <p>
    
    <label>
        File to load: <input type="text" name="loadfile" />
    </label>
    <label>
    <input type="submit" name="Loadfile" value="load">
    </label>
  </p>
  </form>
    <form name="form2" method="POST" action="deletefile.php">
  <p>
    
    <label>
        File to delete: <input type="text" name="deletefile" />
    </label>
    <label>
    <input type="submit" name="Deletefile" value="delete">
    </label>
  </p>
  </form>
   <form enctype="multipart/form-data" action="uploader.php" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
	<input type="submit" value="Upload File" />
	</p>
</form>
   <form name="form3" method="POST" action="userlogout.php">
  <p>
    <label>
    <input type="submit" name="Submit" value="logout">
    </label>
    <a href="loginuserview.php">Home</a>
  </p>
  </form>
   
   <p>
   <?php
         session_start();
	 

         $username = $_SESSION['username'];
	 $str = "$username\n";
         echo "File List:";
         
         $dir = "/srv/$username";
         $name = scandir($dir);
         $mystring = "";
          for($i=2; $i<count($name); $i++){
	  $mystring = $name[$i]."\n ";
          printf("\t<li> %s</li>\n",
		$mystring);
        }
        //echo $mystring;
    ?>

        
   </p>
</body>
</html>
