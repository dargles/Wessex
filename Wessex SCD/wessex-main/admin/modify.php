<?php
/**
 * modify.php allows us to modify entries in our Wessex SCD database.
 *
 * It calls our class, webpage, sets the title for our page, sets the page content,
 * & streams the completed boilerplate code.
 * 
 * @author Donald Mackay and David Argles <wessex.scd@gmail.com>
 * @version 03-03-2014, 13:30h
 * @copyright 2014 Wessex SCD
 */

  /* The following line makes the server display error messages.
   * You may uncomment it during development, but don't forget to comment it 
   * out again when the page goes live! */
  ini_set("display_errors", 1);

  /* The next two lines bring in the webpage class and create a new instance.
   * Don't change these lines! */
  require("../library/webpage.php");
  $page = new webpage();
  
  /* If you need access to the database, you'll need to uncomment the next two lines 
   * to bring in the database class and create a new instance.  It must be done 
   * -before- we start streaming the HTML.
   * Don't change these lines! */
  require("../library/database.php");
  $database = new database($page->rootpath);
  
  /* The next line streams the initial html.  Don't change this. */
  $page->HTMLstreamTop();
  
  /* The HTML section that follows is the space for you to put all your main page content.
   * Aim to use just <p> for paragrpahs, and just <h3> for sub-headings.  Let the CSS do 
   * all the work! */
?>
       <!-- The main page content starts here -->
       
        <!-- The next line inserts the Two Dancers graphic on the page.  Comment it out if 
            you don't want it displayed -->
       <?php //$page->insertGraphic("dancers"); ?>
       
       <h3>Modify Database</h3>
       <p>This page allows us to modify table entries in the Wessex SCD database.</p>
       
       <form action="modify.php" method="get">
       	Select table to modify: <input  type="text" name="tableChoice" list="tables">
          <?php 
          	  $database->query("SHOW TABLES");
	    	  /* We'd better know if there was a problem */
	    	  if($database->error) echo($database->error);
              echo("<datalist id=\"tables\">\n");
			  while ($row = $database->result->fetch_object())
				foreach($row as $pointer=>$table) echo("            <option value='$table'>\n");
			  echo("          </datalist>\n");
          	?>
        <input name="Confirm choice" type="submit">
        
        <?php
          if(isset($_GET[tableChoice]))$table = $_GET[tableChoice];
          else $table = "bands";
		  /*echo"<pre>";
		  print_r($_GET);
		  echo"</pre>";*/
		  echo $table;
        ?>
       </form>

       <?php 
         //$database->rebuild();
       ?>

       <!-- The next line inserts the Thistle graphic on the page.  Uncomment it if 
            you want it displayed -->
       <?php //$page->insertGraphic("thistle"); ?>
       
<?php
  /* The next line displays a "Return to Top" button at the foot of the page
   * Uncomment it if you want it to display */
  // echo("        <a class=\"doubleBottom\" href=\"".$_SERVER['PHP_SELF']."\">Return to top</a>\n");  

  /* The final line streams the final html.  Don't change this. */
  $page->HTMLstreamBottom();
/**---------------------------------------------
 *             End of Code
 *----------------------------------------------
 */
?>
