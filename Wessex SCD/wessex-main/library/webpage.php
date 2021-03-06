<?php
/**
 * webpage.php provides a basic web page class for our website
 *
 * It defines a class, webpage, which forms a boilerplate html page which we 
 * re-use on every page.
 * 
 * @author Donald Mackay and David Argles <wessex.scd@gmail.com>
 * @version 24-02-2014, 22:12h
 * @copyright 2014 Wessex SCD
 */
$version = "24-02-2014, 22:12h";
  /**
   * webpage provides a basic web page class for our website
   *
   * It defines several page attributes which are loaded from a webpage.ini file
   * which should be held in the same directory as the calling page. 
   * It also defines two HTMLstream methods, HTMLstreamTop and HTMLstreamBottom, 
   * which output the necessary HTML code to make up our boilerplate page.
   * 
   * @param void
   * @return void
   */
  class webpage
  {
    /**
     * @access protected
     * @var class
     */
    protected $page;
    /**#@+
	 * @access protected
     * @var string
     */
    /**
     * Defines how to navigate to the root directory
     */
    public $rootpath = "../";
    /**
     * Defines the CSS file to be used 
     */
    protected $cssfile = "webpage.css";
    /**
     * Defines the text to be used in the browser tabs
     */
    protected $title = "Default Page Title";
    /**
     * Defines the image to be used as the page logo 
     */
    protected $heading = "Default Page Heading";
    /**
     * Defines the text to be used as the page tagline
     */
    protected $tagline = "Default page description";
    /**
     * Provides an array for the menu labels and links
     */
    protected $menu = array ("Page 1"=>"page1.php", "Page 2"=>"page2.php");
    /**
     * Defines the copyright text for the bottom of the page 
     */
    protected $copy = "2014 Wessex SCD";
    /**
     * Defines the tartan background for the page 
     */
    protected $tartan = "tarblank.gif";

    /**
     * setCSS() allows us to change the css file used for a particular page
     * 
     * @param the filename of the css file (expected to be held in the <library> sub-directory)
     * @return void
     */
    public function setCSS($filename)
    {
      $this->cssfile = $filename;
      return;
    }

    /**
     * setTartan() allows us to change the tartan background used for a particular page
     * 
     * @param the filename of the tartan (expected to be held in the <graphics> sub-directory)
     * @return void
     */
    public function setTartan($filename)
    {
      $this->tartan = $filename;
      return;
    }

    /**
     * setTitle() allows us to change the text that goes into the tab above the page display in the browser 
     * 
     * @param the new title
     * @var string
     * @return void
     */
    public function setTitle($newTitle)
    {
      $this->title = $newTitle;
      return;
    }

    /**
     * __construct() sets up all the class properties from the webpage ini file
     * 
     * It runs automatically when we first instantiate the class.
     *  
     * @param void
     * @return void
     */
    public function __construct()
    {
      /* First, we'd better check that the ini file is there */
      if(parse_ini_file("webpage.ini",true))
      {
      	/* If it is, read the file in as an object */
        $iniFile = (object) parse_ini_file("webpage.ini",true);
/*echo("<pre>");
print_r($iniFile);
echo("</pre>");*/
		/* Now read in the various settings */
        $this->rootpath = $iniFile->rootpath;
        $this->cssfile = $iniFile->cssfile;
        $this->title = $iniFile->headtitle;
        $this->tartan = $iniFile->tartan;
        $this->heading = $iniFile->heading;
        $this->tagline = $iniFile->tagline;
        /*$this->copy = $iniFile->copyright;*/
        
		/* The entire menu comes in as an object */
		$this->menu = (object) $iniFile->menu;

        /* This bit is a bit clunky.  It would be nice to automagically set up the text in the 
		 * browser tab.  To do this, we...
		 * ...extract the current page name (e.g. index.php) from PHP_SELF... */
        $this->page = substr(strrchr($_SERVER['PHP_SELF'],"/"),1);
		/* ...and then trawl through the menu entries until we find a link specified in the menu 
		 * that matches the current page. */
        foreach($this->menu as $label=>$link)
        {
          if($this->page==$link) $this->title = $label.": ".$this->title;
        }
      }
      return;
    }

    /**
     * HTMLstreamTop() streams all the code necessary for the top of our boilerplate HTML page
     * 
     * @param void
     * @return void
     */
    public function HTMLstreamTop()
    {
      global $version;
    ?>
<!DOCTYPE HTML>
<html>
  <!-- We're working in HTML5, so this is all very straightforward -->
  <!-- First, the head section -->
  <head>
    <meta charset="UTF-8">
    <!-- The following line is required because we want a responsive site -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Donald Mackay and David Argles" />
    <meta name="generator" content=<?php echo("\"Wessex SCD page generator 2, ".$version."\""); ?> />
    <!-- The next line specifies our css file (in CSS3) -->
    <link rel="stylesheet" type="text/css" <?php echo("href=\"".$this->rootpath."library/".$this->cssfile."\""); ?>>
    <!-- We need a fix for legacy IE browsers.  The next line does this for us. -->
    <!--[if lt IE 9]><?php echo("<script src=\"".$this->rootpath."library/html5shiv.js\">"); ?></script><![endif]-->
    <title><?php echo($this->title); ?></title>
  </head>

  <!-- Now we start our displayable page -->
  <body>
    <!-- container doesn't exist (yet?) in CSS3.  It should!  But we can use main instead. -->
    <!-- We have to break all the rules, and put a bit of style into our HTML at this point.
    	That's because the tartan can change from page to page, and this is the only way to
    	do it -->
<?php echo("    <main style=\"background-image: url(".$this->rootpath."graphics/".$this->tartan.")\">\n"); ?>
      <!-- First on the page is the navigation.  Layout is handled by the CSS. -->
      <nav>
<?php
          /* The next bit unpacks our menu object and displays it as a list of links. */
          foreach($this->menu as $label=>$link)
          {
            if(!(strpos($label, " ")&&(strlen($label)>10))) $style = "";
			 else $style = "double";
            if($this->page==$link) echo('        <a class="'.$style.'current" href="'.$link.'">'.$label."</a>\n");
             else echo('        <a class="'.$style.'" href="'.$link.'">'.$label."</a>\n");
          }
?>
      </nav>
      <section>
        <!-- Next up comes the header.  For now, this is just a heading and a graphic. -->
        <header>
          <h1><?php echo($this->heading); ?></h1>
          <h2><?php echo($this->tagline); ?></h2>
        </header>

        <!-- Now we start the main article... -->
        <article>
          <?php /*echo("<img class=\"right\" src=\"".$this->rootpath."graphics/2Couples.png\" alt=\"[Dancers Graphic]\">");*/ ?>
          <!-- ...and stream the main content. -->
    <?php 
    }
    /**
     * insertGraphic() inserts either the "two dancers" graphic or the "thistle" 
	 * graphic into the main page.  
	 * 
	 * A separate method is provided for this so that the person updating the page 
	 * doesn't have to worry about things like the copyright get-out clauses! 
	 * $graphic MUST be either "dancers" or "thistle".  Anything else will display 
	 * nothing at all.
	 * 
     * @param must be either "dancers" or "thistle"
     * @return void
     */
    public function insertGraphic($graphic) 
    {
      if ($graphic == "dancers") 
      {
      	echo("<img class=\"picWideRight\" src=\"".$this->rootpath."graphics/2Couples.png\" 
      	 alt=\"[Two Couples Dancing]\" title=\"We believe this graphic to be in 
      	 the public domain.  If you know anything about its origin, do please 
      	 contact us and let us know.\" />\n");
      }
      else if ($graphic == "thistle") 
      {
      	echo("<img class=\"picRight\" src=\"".$this->rootpath."graphics/thistle.png\" 
      	alt=\"[Thistle graphic]\" title=\"We believe this graphic to be in the 
      	public domain.  If you know anything about its origin, do please contact 
      	us and let us know.\" />\n");
      }
    }
	
    /**
     * common_scd_links() streams a few common links as list items
     * 
     * @param void
     * @return void
     */
    public function common_scd_links() 
    {?>  
      <li><a href="http://www.scottish-country-dancing-dictionary.com/">Scottish Country Dancing Dictionary</a><br />
      	Instructions and Diagrams for Steps, Sets and Figures</li>
      <li><a href="http://www.scottishdance.net">Grand Chain</a><br />
      	A set of resources for Scottish Dancers the world over</li>
      <li><a href="http://www.minicrib.org.uk/">"MINICRIB"</a><br />
      	A crib with more than 2000 Scottish Country Dances</li>
      <li><a href="http://www.strathspey.org/">Strathspey Server</a><br />
      	Resource for Scottish country dance and music</li>
<?php
	}

    /**
     * This function prints a list of the files in the given directory.
	 *  $path is the path to the required directory;
	 *  $suppress suppresses the given string. It's intended for suppressing
	 *   the expected file format from the display (e.g. ".doc")
	 *  $order determines
	 *  - alphabetic (0, or SCANDIR_SORT_ASCENDING)
	 *  - reverse alphabetic (1, or SCANDIR_SORT_DESCENDING)
	 *  - none (SCANDIR_SORT_NONE)
	 * Prints all the directory contents minus the . and .. entries
	 * Notes:
	 *  "-" in the filename is exchanged for a space
	 *  "_" in the filename is exchanged for a space (but it comes in a
	 *      different place in the alphabet, so it can be used to change
	 *      file order)
	 * The expectation is that ".doc" is removed.  any remaining dots
	 *  and ensuing file formats are then re-expressed as "(xxx format)"
	 * 
     * @param $path is the path to the required directory;
     * @param $suppress suppresses the given string;
	 * @param $order determines listing order (0 alphabetic, 1 reverse alphabetic)
     * @return void
     */
    public function dir_list($path, $suppress, $order) {
  /* Get the sorted directory listing into an array, $result; flag error if path is wrong */
  if (!$result=scandir($path, $order)) echo("<p class=\"indent\">Error: wrong directory path!\n</p>");
  /* If that worked OK... */

  else{
    /* remove the . and .. entries */
    $sorted_dirlist = array_diff($result, array('.','..'));
    /* $dirsize gets the size of the directory listing */
    $dirsize = count($sorted_dirlist);
    /* If there's no other entries, give a suitable message */
    if ($dirsize<1) echo("    <p>None found</p>\n");
    /* Otherwise... */
    else {
        /* This is a kludge to sort out the removed entries. It ought to be sorted properly */
        $start = 2 - ($order * 2);
        /* Select the next directory item */
        for ($i=$start; $i<=(count($sorted_dirlist) + $start); $i++) {
        /* Change "-" to space */
        $next = str_replace("-", " ", $sorted_dirlist[$i]);

        /* Change "_" to space */
        $next = str_replace("_", " ", $next);
        /* Remove $suppress */
        $next = str_replace($suppress, "", $next);
        /* change ".xxx" to " (xxx format)" */
        if (strpos($next, ".")){
          $next = strstr($next, ".", TRUE)." ( ".strstr($next, ".", FALSE)." format)";
        }
        /* Now print it out */
        echo("    <p><a href=\"".$path."/".$sorted_dirlist[$i]."\">".$next."</a></p>\n");
      }
    }
  }
}

    /**
     * displayMedia($dirname) displays a gallery of pictures
	 * 
	 * Basically, this method displays a gallery of picture thumbnails 
	 * when called.  When a thumbnail is clicked on, it calls up 
	 * 'viewer.php' - which must be in the same directory as the calling 
	 * page - to display a large version of the chosen picture.  A full 
	 * 'HowTo' is included in the documentation.
     * 
     * @param $dirname gives the directory with the gallery in
     * @return void
     */
    public function displayMedia($dirname) 
    {
      /* We're going to need to know which page we are, so get it now */
      $retPage=substr(strrchr($_SERVER['PHP_SELF'], "/"),1);
      /* We now need the contents of the media directory in alphabetical order; 
         put into an array, $result; flag error if path is wrong */
      @$result=scandir($dirname, 0);
      if (!$result) echo("<p class=\"indent\"><b>Picture Error:</b> <i>picture directory (".$dirname.") not found!</i>\n</p>");
      /* If that worked OK... */
      
      else
      {
        /* Get the next entry in the directory listing - it should be a sub-directory */
        for ($i=0; $i<count($result); $i++)
        {
          $picDir=$result[$i];
          /* Ignore the .. and . directory entries */
          if($picDir != ".." & $picDir != ".") 
          {
            /* Set up $title to be the section title; default is directory name */
            $title = $picDir;
            /* See if there's a title.txt inside this subdirectory */
            $filename = $dirname."/".$picDir."/title.txt";
            /* (The leading @ suppresses error reporting if the file's not there) */
            @$file_handle = fopen($filename, "r");
            /* If so, we need only the first line of the file (it's a title...) */
            if($file_handle)
            {
              $title = fgets($file_handle);
              fclose($file_handle);
            }
            /* List the collection name as a centred heading */
            echo("      <figure>\n        <h5>".$title."</h5>\n");

            /* Now get the directory description if there is one */
            $filename = $dirname."/".$picDir."/description.txt";
            /* (The leading @ suppresses error reporting if the file's not there) */
            @$file_handle = fopen($filename, "r");
            /* If so, we need only the first line of the file (it's a one liner...) */
            if($file_handle)
            {
              /* Now display it on the page */
              echo("  <p>".fgets($file_handle)."</p>\n");
              fclose($file_handle);
            }

            /* Now see if there's a content.ins file */
            $contentfile = FALSE;
            $filename = $dirname."/".$picDir."/content.ins";
            /* (The leading @ suppresses error reporting if the file's not there) */
            @$file_handle = fopen($filename, "r");
            /* If so, we need all the content of the file */
            if($file_handle)
            {
              $contentfile = TRUE;
              while(!feof($file_handle))
              {
                /* Display it on the page */
                echo(fgets($file_handle));
              }
              fclose($file_handle);
            } 

            /* Now get the pictures in the directory and display their thumbnails */
            @$handlePicDir=opendir($dirname."/".$picDir);
            if (!$handlePicDir) $handlePicDir=opendir($dirname);
            /* Start a containing div for the pics */
            echo ("  <div class=\"galleryPadLeft\">");
            echo ("&nbsp;");
            echo ("</div>\n");
            echo ("  <div class=\"galleryIndent\">\n");
            /* Get the next entry in the picture sub-directory */
            $picCounter = 0; /* We'll use this to count the no of pictures in this dir */
            while($picitem=readdir($handlePicDir)) 
            {
              /* Is this a full-sized picture? */
              if(strstr($picitem, ".jpg", FALSE) && !strpos($picitem, "_t."))
              {
                /* If so, we need to remember the filename */
                $piclist[$picCounter] = $picitem;
                $picCounter++;
                /* Is there a corresponding thumbnail? */
                $thumbPic = "../graphics/default-t.jpg";
                $thumbName = strstr($picitem, ".jpg", TRUE)."_t.jpg";
                /* Try opening the file */
                $fullname = $dirname."/".$picDir."/".$thumbName;
                @$thumb_handle = fopen($fullname, "r");
                /* If it's there, we need to update $thumbPic and close the file */
                if($thumb_handle)
                {
                  $thumbPic = $dirname."/".$picDir."/".$thumbName;
                  fclose($thumb_handle);
                }
                /* Is there a corresponding picture description? */
                $picDescription = $picitem;
                $picDescFile = strstr($picitem, ".jpg", TRUE).".txt";
                /* Try opening the file */
                $fullname = $dirname."/".$picDir."/".$picDescFile;
                @$desc_handle = fopen($fullname, "r");
                /* If it's there, we need to update $picDescription and close the file */
                if($desc_handle)
                {
                  $picDescription = "";
                  while(!feof($desc_handle))
                  {
                    /* Spool it into $picDescription */
                    $picDescription .= fgets($desc_handle);
                  }
                  fclose($desc_handle);
                }
                /* Now display the thumbnail */
                echo("    <div class=\"img\">\n");
                echo("      <a href=\"viewer.php?picdir=".$dirname."/".$picDir."&amp;picname=".$picitem."&amp;retpage=".$retPage."\">");
                echo("<img src=\"".$thumbPic."\" alt=\"thumbnail of ".$picitem."\" width=\"110\" height=\"90\" /></a>\n");
                echo("      <div class=\"desc\">".$picDescription."</div>
");
                echo("    </div>\n");
              }

              /* Ignore anything that's not a thumbnail 
              if(strpos($picitem, "_t.")) 
              {
                /* Work out the name of the related big pic 
                $bigpic = strstr($picitem, "_t.", TRUE).strstr($picitem, ".", FALSE);
                /* Set up the session variable for viewer.php 
                $_SESSION['path']=$dirname."/".$picDir;
                $_SESSION['picname']=$bigpic;
              }*/
            }
            /* Close the containing div */
            if($picCounter>0) echo("    <p class=\"clear\"></p>\n    <p class=\"icentre\">--- Click on pictures to enlarge ---</p>\n");
            echo ("  </div>\n");
            /* We need to clear the "float left" */
            echo ("  <p class=\"clear\"></p>\n");
            /* If we didn't find any content, we ought to say so */
            if($picCounter==0 && !$contentfile) echo("  <p class=\"centre\">(No pictures found)</p>\n");

            echo("      </figure>\n");
			 
			 /* echo("<div>(".$picCounter." pictures in this folder)</div>"); */
          }
        }
      }
    }

    /**
     * HTMLstreamBottom() streams all the code necessary for the bottom of our boilerplate HTML page
     * 
     * @param void
     * @return void
     */
    public function HTMLstreamBottom()
    {
    ?>
        <!-- First, we need to close the containing |article| -->
        </article>

        <!-- Then open up the footer section -->
        <footer>
          <?php 
          /* For all index.phps we need to display the W3 validation icons */
          if(strstr($_SERVER['PHP_SELF'], "index.php", TRUE))
          {
            echo("<!-- If we're on index.php, display the W3 consortium validation icons -->\n          ");
            echo("<p class='small'>\n        ");
            echo("    <a href=\"http://validator.w3.org/check?uri=referer\">\n          ");
            echo("    <img src=\"".$this->rootpath."graphics/HTML5.png\"\n              ");
            echo("alt=\"Valid HTML5!\" height=\"31\" width=\"88\" />\n          ");
            echo("  </a>\n        ");
            echo("    <a href=\"http://jigsaw.w3.org/css-validator/check/referer\">\n          ");
            echo("    <img style=\"border:0;width:88px;height:31px\"\n              ");
            echo("src=\"".$this->rootpath."graphics/CSS3.png\" ");
            echo("alt=\"Valid CSS3!\" />\n          ");
            echo("  </a>&nbsp; &nbsp;This site is HTML5 &amp; CSS3 compliant and mobile-friendly.\n          ");
            echo("</p>\n");
			/* If we're on the main site index.php, we also want to include a few more things */
			if(!$this->rootpath=="../")
			{
			  echo("<p class='small'>You are visitor<!-- Gostats.com web hit code. Please do not change this-->
               <script type='text/javascript'>var go_mem=\"scdwessex\";</script>
               <script src=\"http://c2.gostats.com/go.js\" type=\"text/javascript\"></script>
               <noscript><a href=\"http://c2.gostats.com/gogi/viewstats.pl?mn=scdwessex\" target=\"_top\">
               <img alt=\"hit counter\" src=\"http://c2.gostats.com/gogi/count.pl?mn=scdwessex\" 
               border=\"0\"></a></noscript>to this site.&nbsp;
               <a href=\"http://gostats.com\">
               <font size=\"-0\"><font size=\"1\">Get a GoStats hit counter</font></font></a>
               <!-- End of Gostats.com web hit code --></p>	  
	           <p class='small'>Please send any comments on this site to: <a href=\"mailto:wessex.scd@gmail.com\">
	           wessex.scd@gmail.com</a></p>");
			}
          }
          //else echo("<p>&nbsp;</p>");
        ?>
          <?php 
            echo("<p>&copy;".$this->copy."</p>\n"); 
 		  ?>
        </footer>
        <!-- Now we just tidy everything up at the foot of the page. -->
      </section>
    </main>
  </body>
</html>
<?php 
    }
  }
/**---------------------------------------------
 *             End of Code
 *----------------------------------------------
 */
?>
