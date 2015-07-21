<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
      <?php
      session_start();
      
       if(!$_SESSION){
	?>
	  <meta http-equiv=refresh content="3; url=index.html">
      <?php
       }
       ?>
    <title>User View</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
    
    
</head>
<body>
  <div id="backtotop"></div>
  <?php
      
       if(isset($_SESSION)){
	?>
  
     <div class="container">
        <div class="wrapper">
            <div class="heading">
	      <form name="form11" method="POST" action="logout.php" >
                <div class="user" >
                    
                        <?php
                        if($_SESSION){
                            $username = $_SESSION['username'];
			    
                            echo htmlspecialchars("User:  ".$username);
			    
			    
                        ?>
			
		
			
			  <input type="submit" name="Logout" value="logout" class="button1">                           
			
			
                                      
                </div>
		</form>
	      <br/>
	      <div class="webDrive">
		<a href="usersview.php">See your WebDrive</a><br/>
		
		
	      </div>
                <div class="edit">                                                                     
                <br/>
		  <form enctype="multipart/form-data" name="form21" method="POST" action="addstory.php" id="add_story">
                <p>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
		    <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                    <!--<label>
                        <textarea cols="40" rows="1" name="addCategory" placeholder="Please Enter Category"></textarea>
                    </label>
                    <label>
                        <textarea cols="40" rows="1" name="addTitle" placeholder="Please Enter Title"></textarea>
                    </label>-->
                    <br/>
                    <label>
                        <textarea cols="40" rows="10" name="addContent" placeholder="Please Enter Story"></textarea>
                    </label>
		    <label>
                        <textarea cols="40" rows="1" name="addLink" placeholder="You can add link here"></textarea>
                    </label> 
                    <br/>
		    <label for="uploadfile_input">Add Picture:</label> <input name="uploadedfile" type="file" id="uploadfile_input"/>
                    <br/>
		    <br/>
		    <label>
                        <input type="submit" name="Addstory" value="Add" class="button">
                    </label>
                    
                </p>
                 </form>		  
		</div>
		<div class="follow">
		  
		  <?php
		    require 'database.php';
		    $user1 = array();
		    $stmt = $mysqli->prepare("select username from users");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }                
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                  $user1[]=htmlentities($row["username"]);
		  //echo $row["username"];
		  //echo "<br/>";
                }		
		 $stmt->close();	
		 $followers = array();
		  $stmt = $mysqli->prepare("select followby from followers where username =?");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
		
                $stmt->bind_param('s', $_SESSION['username']);
                $stmt->execute();
		$result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                  $followers[]=htmlentities($row["followby"]);	 
		        
                }
		
		 $stmt->close();
		 ?>
		  <form name="form21" action="follow.php" method="POST">
		    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" class="token" />
		    
		    <select name="follow">
		      <?php
		      $username2 = $_SESSION['username'];
		      for($j = 0;$j<count($user1);$j++){
			$exists = false;
			      for($k = 0;$k<count($followers);$k++){
				
				//$exist = (strcmp($user1[$j],$followers[$k])==0)||(strcmp($user[$j],$username2)==0);
				
				if((strcmp($user1[$j],$followers[$k])==0)||(strcmp($user1[$j],$username2)==0)){
				  $exists = true;				  
				}
			      }
			      if(!$exists && !(strcmp($user1[$j],$username2)==0)){
			?>
		      <option value="<?php echo $user1[$j]; ?>"><?php echo $user1[$j]; ?></option>
		      <?php }
		      }
		      ?>
		    </select>
		    <input type="submit" name="follows" value="follow" class="button" />
		  </form>	   		 		 	    
		</div>
		
		
		<div class="unfollow">
  
		  <form name="form22" action="unfollow.php" method="POST">
		    <input type="hidden"  name="token" value="<?php echo $_SESSION['token'];?>" class="token" />
		    
		    <select name="unfollow">
		      <?php
		      $username2 = $_SESSION['username'];
		     			      
			      for($k = 0;$k<count($followers);$k++){
				
			?>
		      <option value="<?php echo $followers[$k]; ?>"><?php echo $followers[$k]; ?></option>
		      <?php }
		      
		      ?>
		    </select>
		    <input type="submit" name="unfollows" value="unfollow" class="button" />
		  </form>
		  
		  <a href="#backtotop" class="btt"><img src="backtotop.jpg" alt="Back To Top" height="42" width="42" title="Back to top" ></a>
		  
		  
		</div>
		
            </div>
	    
	    
	    
            <div class="body">
                <?php
                require 'database.php';
                // generate a 10-character random string
                $firstid = array();
                $secondname = array();
                $thirdstory = array();
                $lastinfo = array();
                
                $stmt = $mysqli->prepare("select id,username,story,info from story order by id");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
               
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                  $firstid[]=htmlentities($row["id"]);
                  $secondname[]=htmlentities($row["username"]);
                  $thirdstory[]=htmlentities($row["story"]);
                  $lastinfo[]= htmlentities($row["info"]);
                }
                $stmt->close();
                
		//$exists = false;
		for($i = 0;$i<count($secondname);$i++){
		  $exists = false;
			      for($k = 0;$k<count($followers);$k++){
				
				//$exist = (strcmp($user1[$j],$followers[$k])==0)||(strcmp($user[$j],$username2)==0);
				
				if((strcmp($secondname[$i],$followers[$k])==0)||(strcmp($secondname[$i],$username2)==0)){
				  $exists = true;
				  
				}
			      }
			      if($exists || strcmp($secondname[$i],$username2)==0){		      							      			      
                //for($i = 0;$i<count($firstid);$i++){
                    $username1 = $secondname[$i];
                    $story_id = $firstid[$i];
		    
                    $stmt = $mysqli->prepare("select username, story, links.link from story join links on (story.id=links.story_id)where id = ?");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $stmt->bind_param('s', $story_id);
                $stmt->execute();
                $stmt->bind_result($first, $second,$added);
                echo "<ul class=\"story\">";
                while($stmt->fetch()){
                    echo "<li>";
                    echo "<b>";
                    printf("%s: ",htmlspecialchars($first));
                    echo "</b>";
                    printf(" %s",nl2br(htmlspecialchars($second)));
		    if(strcmp($added,"")){
		?>
		<a href="<?php printf("%s",nl2br(htmlspecialchars($added))); ?>"><?php printf(" %s",nl2br(htmlspecialchars($added))); ?></a>
		<?php
		 //printf("See more at: %s",nl2br(htmlspecialchars($added)));
	}
                }?>

		 <div class="floatright">
		  

<form name="form18" method="POST" action="editstoryview.php">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" class="token" />
  <input type="hidden" name="Id" value="<?php echo $story_id; ?>" />
  <!--<input type="hidden" name="username" value="" />-->
  <input type="submit" name="Edit" value="Edit" class="button"/>
</form>
</div>
		 <div class="floatright">  
<form name="form18" method="POST" action="deletestory.php">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" class="token" />
  <input type="hidden" name="deletestory" value="<?php echo $story_id; ?>" />
  <!--<input type="hidden" name="username" value="" />-->
  <input type="submit" name="Delete" value="Delete" class="button"/>
</form>
</div>
		<?php
		
                echo "</ul>";
                $stmt->close();
		
//----------------------------  -----load image-------------------------------------------

$stmt = $mysqli->prepare("select url from images where storyid =?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('i', $story_id);
$stmt->execute();
$stmt->bind_result($first);
while($stmt->fetch()){
  echo "<img src=\"$first\" alt=\"photo\">";
  echo "<br/>";
	
}
$stmt->close();

//----------------------------------like story button-------------------------------------


$username = $secondname[$i];
$stmt = $mysqli->prepare("select islike from likestories where story_id =? and username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('is', $story_id,$username);
$stmt->execute();
$stmt->bind_result($haha);

while($stmt->fetch()){

	$str=$haha;
}
$stmt->close();
?>
<div class="floatleft">  
<form name="form4" method="POST" action="storycomment.php">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" class="token" />
<input type="hidden" name="storyid" value="<?php echo $story_id; ?>" />
<label>
<textarea cols="50" rows="1"  name="addcomment" placeholder="Please Enter Comment"></textarea>
</label>
<input type="submit" name="Comment" value="Comment" class="button"/>
</form>
</div>
<?php
if(strcmp($str,'no')==0){
  ?>
<div class="floatleft">  
<form name="form13" method="POST" action="likestory.php" class="likebutton">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" class="token" />
  <input type="hidden" name="storyid" value="<?php echo $story_id; ?>" />
  <input type="hidden" name="username" value="<?php echo $username; ?>" />
  <input type="submit" name="Like" value="Like" class="button"/>


<?php
//    echo "<label>";
//    echo "<input type=\"submit\" name=\"Like\" value=\"Like\">";
//    echo "</label>";
	
	$stmt = $mysqli->prepare("select likestory from story where id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $story_id); 
	$stmt->execute();
	 
	$stmt->bind_result($first);
	 
	
	while($stmt->fetch()){
		printf("\t %d\n",
			htmlspecialchars($first)
		);
	}
	
	 
	$stmt->close();
	echo "</form>";
	echo "</div>";
	

	
//echo "</form>";


}else{
  ?>
<div class="floatleft">  
<form name="form14" method="POST" action="likestory.php" >
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" class="token" />
  <input type="hidden" name="storyid" value="<?php echo $story_id; ?>" />
  <input type="hidden" name="username" value="<?php echo $username; ?>" />
  <input type="submit" name="Like" value="Like" class="button"/>



<?php
	$stmt = $mysqli->prepare("select likestory from story where id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $story_id); 
	$stmt->execute();
	 
	$stmt->bind_result($first);
	 
	
	while($stmt->fetch()){
		printf("\t %d\n",
			htmlspecialchars($first)
		);
	}
	
	 
	$stmt->close();
	echo "</form>";
	echo "</div>";
	
	
}


$stmt = $mysqli->prepare("select comment_id, username, comment from comment where story_id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('s', $story_id); 
$stmt->execute();
 
$stmt->bind_result($first, $second, $last);
echo "<br/>";
 
echo "<ul>\n";
while($stmt->fetch()){
        echo "<form name=\"form17\" method=\"POST\" action=\"deletecomment.php\">";
	echo "<p>";
	echo "<li class=\"comment\">";
	//echo "<p>";
	echo "<b>";
        printf("%s",htmlspecialchars($second));
        echo "</b>";
        //echo "<p class=\"author\">";
        //printf("Comment id:&nbsp;  %d\n",
        //        htmlspecialchars($first)                  
        //        );
        //echo "</p>";
        
        printf(": %s",nl2br(htmlspecialchars($last)));
	?>
  
	
	  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" class="token"/>
	  <input type="hidden" name="deletecomment" value="<?php echo $first; ?>" />
          <input type="submit" name="delete" value="delete" class="button"/>
	</form>

	<?php
	//echo "</p>";
        echo "</li>";
	echo "</p>";
	echo "</form>";

	
}
echo "</ul>\n";
 
$stmt->close();

                }
			}
			}
		
                ?>
                
            </div>
        </div>
        
    </div>
    <?php
       }else{
	echo "you have to log in";
       }
       
    ?>
</body>
</html>