<?php
         session_start();

         $username = $_SESSION['username'];
         echo "$username\n";
         $f = fopen("$username.txt", "r");
 
         $linenum = 1;
         echo "<ul>\n";
         while( !feof($f) ){
	 printf("\t<li> %s</li>\n",
		fgets($f)
	 );
        }
         echo "</ul>\n";

        fclose($f);
        
?>