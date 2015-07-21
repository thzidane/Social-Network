<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <title>Edit Story View</title>
    <?php
    session_start();
    ?>
     <style type="text/css">
    
    .main{
	
	text-align: center;
      }
      
a{
   text-decoration: none;
}
a:link,a:visited{
   color: darkgray;
}
a:hover,a:active{
   color: dimgrey;
}
img{
        max-width: 512px;
        max-height: 512px;
        height:auto;
        zoom:expression( function(e) {
if(e.width>e.height) {if (e.width>128) { e.height = e.height*(128 /e.width); e.width=128; }}
else {if (e.height>128) { e.width = e.width*(128 /e.height); e.height=128; }}
e.style.zoom = '1';     }(this));
         overflow:hidden; 
}
    </style>
</head>

<body>
    <div class="main">
    <?php
    require 'database.php';
    if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
    }
    $id = $_POST['Id'];    
    $username=$_SESSION['username'];
    
    //-------------------------make sure that only the author can delete the story---------
$stmt = $mysqli->prepare("select username from story where id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i',$id); 
$stmt->execute();
$stmt->bind_result($first);

if(!$stmt->fetch()){    
    echo "Please enter correct story id.";
}else{
    $str2=$first;
}
	
$stmt->close();

if(strcmp($username,$str2)==0){
    ?>
    <form enctype="multipart/form-data" name="form6" method="POST" action="editstory.php" class="editstory">        
        <p>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
	    <input type="hidden" name="Id" value="<?php echo htmlspecialchars($id) ?>" />
	    <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
           
            <label>
                <textarea cols="100" rows="15" name="Content" >
                     <?php
                    $stmt = $mysqli->prepare("select story from story where id=?");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                        }
                    $stmt->bind_param('i',$id);
                    $stmt->execute();
                    $stmt->bind_result($first);
                    
                   while($stmt->fetch()){
                	printf("%s",
                               htmlspecialchars($first));}
                    $stmt->close()
                    ?>                       
                </textarea>
            </label>
	    <br/>
	    <label>
                link: <textarea cols="95" rows="2" name="Link" >
                     <?php
                    $stmt = $mysqli->prepare("select link from links where story_id=?");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                        }
                    $stmt->bind_param('i',$id);
                    $stmt->execute();
                    $stmt->bind_result($first);
                    
                   while($stmt->fetch()){
                	
                           echo htmlspecialchars($first);}
                    $stmt->close()
                    ?>                       
                </textarea>
            </label>
            <br/>
	    
		<?php
		$stmt = $mysqli->prepare("select url from images where storyid =?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->bind_result($first);
		while($stmt->fetch()){
		  echo "<img src=\"$first\" alt=\"photo\">";
		  echo "<br/>";
			
		}
		$stmt->close();
		?>
		
		<label for="uploadfile_input">Change Picture:</label> <input name="uploadedfile" type="file" id="uploadfile_input"/>
                    <br/>
	   
	    <p>
            <label>
                <input type="submit" name="Editstory" value="Edit" class="button">
            </label>
	    </p>
        </p>
    </form>
    <?php
    }else{
         echo "<p>";
    echo "you are not the author of this story, you cannot edit it.";
    echo "</p>";
    }
    ?>
    <p>
       <a href=loginuserview.php>Back to Home Page.</a>
    </p>
    </div>
    


</body>
</html>
