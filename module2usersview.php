<!doctype html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <title>User View</title>
</head>
<body>
    <form name="form" method="POST" action="module2showfiles.php">
  <p>
    <label>
    <input type="submit" name="Submit" value="view your files">
    </label>
  </p>
  </form>
   <form name="form0" method="POST" action="module2loadingfile.php">
  <p>
    
    <label>
        File to load: <input type="text" name="loadfile" />
    </label>
    <label>
    <input type="submit" name="Loadfile" value="load">
    </label>
  </p>
  </form>
    <form name="form2" method="POST" action="module2deletefile.php">
  <p>
    
    <label>
        File to delete: <input type="text" name="deletefile" />
    </label>
    <label>
    <input type="submit" name="Deletefile" value="delete">
    </label>
  </p>
  </form>
   <form enctype="multipart/form-data" action="module2uploader.php" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
		<input type="submit" value="Upload File" />
	</p>
</form>
   <form name="form3" method="POST" action="module2userlogout.php">
  <p>
    <label>
    <input type="submit" name="Submit" value="logout">
    </label>
  </p>
  </form>
</body>
</html>
