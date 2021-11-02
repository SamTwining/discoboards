<?
   $hostname = $HTTP_HOST;
   $hostname = ereg_replace("[^a-z]", "", $hostname);

   $settingsfile = "settings.".$hostname.".php";
   if (file_exists($settingsfile))
   {
     include($settingsfile);
   }
   else
   {
     echo "<B>FATAL:</B> Couldn't find $settingsfile!<BR>\n";
     Exit();
   }
   
   // Basics
   // ------
   
   $DBVersion = "1.7.1";
   
   // Set up system URLs
   // ------------------
   
   if (!$AccessProtocol)
   { $AccessProtocol = "http"; }
   
   if (!$functionset)
   { $functionset = "boards"; }
   
   // DBRoot should be the front page
   $DBRoot = $AccessProtocol."://".$ServerAddress.$BaseDir;
   
   // Append basedir to docroot to get the right base directory for the
   // DiscoBoard installation
   //$DocRoot .= $BaseDir;
   // ... or maybe we don't need to do this?
   
   // GFXRoot should be the gfx directory base address
   $GFXRoot = "$DBRoot/gfx";
   
   // Turn HiddenClasses into an array
   $HiddenClassNames = explode(",", $HiddenClasses);
   
   // Configuration Setup
   // -------------------
   $configoptions[themename]          = $ThemeName;
   $configoptions[perpagethreads]     = $ShowThreadsPerPage;
   $configoptions[perpageposts]       = $ShowPostsPerPage;
   $configoptions[profanityfilter]    = $ProfanityFilterActive;
   $configoptions[profanities]        = $ProfanityFilter;
   $configoptions[threshold]          = $Threshold;
   $configoptions[emoticons]          = $EmoticonSet;
   $configoptions[useownicons]        = $UseOwnIcons;
   $configoptions[timezonechange]     = $TimeZoneChange;
   $configoptions[showlastpostername] = $ShowLastPosterName;
   
   // Disallowed URL characters...
   $configoptions[disallowedchars]    = "[ '\"\(\)\>\<]";
   
   // Define SQL table names as constants
   $tableprefix = "";
   if (trim($DatabasePrefix))
   {
     $tableprefix = $DatabasePrefix."_";
   }
   define("TABLE_ACCESS_CLASS", $tableprefix."access_class");
   define("TABLE_BOARD_SESSIONS", $tableprefix."board_sessions");
   define("TABLE_BOARDS", $tableprefix."boards");
   define("TABLE_CLASS_PERMISSION", $tableprefix."class_permission");
   define("TABLE_COUNTRY_CODES", $tableprefix."country_codes");
   define("TABLE_FAVOURITES", $tableprefix."favourites");
   define("TABLE_GROUPS", $tableprefix."groups");
   define("TABLE_ICON_GROUPS", $tableprefix."icon_groups");
   define("TABLE_ICONS", $tableprefix."icons");
   define("TABLE_POLL_OPTIONS", $tableprefix."poll_options");
   define("TABLE_POLL_RESPONSES", $tableprefix."poll_responses");
   define("TABLE_POLLS", $tableprefix."polls");
   define("TABLE_POSTS", $tableprefix."posts");
   define("TABLE_RECOVERYVERIFICATION", $tableprefix."recoveryverification");
   define("TABLE_STICKY_THREADS", $tableprefix."sticky_threads");
   define("TABLE_SYSTEM_BAN", $tableprefix."system_ban");
   define("TABLE_THEME", $tableprefix."theme");
   define("TABLE_THREADS", $tableprefix."threads");
   define("TABLE_USER_NOTES", $tableprefix."user_notes");
   define("TABLE_USERS", $tableprefix."users");
   
   if (!$ThemeName)
   {
     echo "<B>FATAL:</B> No theme configuration found!<BR>\n";
     Exit();
   }
   
   $javascriptlink = " <SCRIPT LANGUAGE='JavaScript1.2' SRC='".$DBRoot."/javascript.php'></SCRIPT>\n";
   
   // ASSEMBLE REDIRECTION STRING
   // ==========================================================================   
   // ==========================================================================   

   // Get POST'd vars
   foreach($HTTP_POST_VARS as $key => $value)
   { 
     // <// Homesite code highlight marker
     if ($querystring)
     {
       $querystring .= "&";
     }
     $querystring .= urlencode($key)."=".urlencode($value);
   }
   
   // Get GET'd vars
   foreach($HTTP_GET_VARS as $key => $value)
   { 
     // <// Homesite code highlight marker
     if ($querystring)
     {
       $querystring .= "&";
     }
     $querystring .= urlencode($key)."=".urlencode($value);
   }
   
   if ($querystring)
   {
     $querystring = "?".$querystring;
   }
   
   $loginpage = "$DBRoot/login.php?returnurl=".urlencode("$PHP_SELF".$querystring);
   $loginpageplain = "$DBMRoot/login.php";

   // Establish connection to MySQL
   // -----------------------------
   
   // Try the connection
   if ($mysql = mysql_connect($MySQLServer, $MySQLUsername, $MySQLPassword))
   {
     // Select the database
     $select = mysql_select_db($MySQLDatabase, $mysql);
     
     if (!$select)
     {
       // Database selection didn't work, so output an error
       $err[] = "Failed to select database '$MySQLDatabase': ".mysql_error();
     }
   }
   else
   {
     // Database connection didn't work, so output an error
     $err[] = "Failed connection to $MySQLServer: ".mysql_error();
   }
   
   // Check to see if anything went wrong
   if ($err)
   {
     echo "<B>Fatal Error</B><BR>\n"
         .implode("<BR>\n", $err);
     Exit();
   }
   
   // Load Support Functions
   // ----------------------
   $functionfiles[] = "generic";
   switch ($functionset)
   {
     case "iconview":
       $functionfiles[] = "iconview";
       break;
     case "admin":
       $functionfiles[] = "admin";
       $functionfiles[] = "html";
       $functionfiles[] = "session";
       $functionfiles[] = "board";
       $functionfiles[] = "textformat";
       break;
     default:
       $functionfiles[] = "html";
       $functionfiles[] = "session";
       $functionfiles[] = "board";
       $functionfiles[] = "textformat";
   }
   foreach ($functionfiles as $key => $value)
   {
     include("functions.".$value.".php");
   }

   // SESSION VALIDATION
   // -----------------------------------------------------------------------
   // -----------------------------------------------------------------------
   
   if (SESSION_FUNCTIONS_AVAILABLE == 1)
   {
     if ($boardsession)
     { $boardsessionkey = $boardsession; }
     
     if ($boardsessionkey)
     {
       $debug .= "We have a session key $boardsessionkey<BR>\n";
       // Got a session key, pull it and check it out
       $session = pullSession($boardsessionkey, "board");
       
       if ($session[ID])
       {
         // We've pulled a valid session, attempt to refresh it
         $sessiondata = refreshSession($boardsessionkey, "board");
         
         if ($sessiondata[result] == "success")
         {
           $debug .= "Session $sessiondata[ID] updated successfully.<BR>\n";
           $userloggedin = 1;
  
           $userdata = getUserInformation($session[username], "users");
  
           // Override the current page length settings with the user's
           // individual settings, if present.
           if ($userdata[perpagethreads])
           {
             $configoptions[perpagethreads] = $userdata[perpagethreads];
           }
           if ($userdata[perpageposts])
           {
             $configoptions[perpageposts]   = $userdata[perpageposts];
           }
           if ($userdata[timezone])
           {
             $configoptions[timezonechange] = $userdata[timezone];
           }
         }
         elseif ($sessiondata[result] == "fail")
         {
           $debug .= "Session $boardsessionkey could not be updated.<BR>\n";
           $userloggedin = 0;
           if (($PHP_SELF != "/index.php") && ($PHP_SELF != "/login.php"))
           {
             $debug .= "Doing redirection.<BR>\n";
             // Not on the front page, you should be redirected
             //echo $debug;
             $doredirect = 1;
             $extraparams = "&timeout=1&olduser=".urlencode($session[username]);
           }
           $session     = "";
           $sessiondata = "";
         }
       }
       else
       {
         // No valid session data was found...
         $debug .= "Didn't find a session ID for $boardsessionkey<BR>\n";
         $doredirect = 1;
       }
     }
     else
     {
       $debug .= "We DON'T have a session key<BR>\n";
       //echo $debug;
       $doredirect = 1;
     }
     
     if (($doredirect) && ($protectedpage))
     {
       $redirectdestination = "$loginpage$extraparams";
       $debug .= "Page is protected, redirecting to ".$redirectdestination."...<BR>\n";
     }
     
     //echo $debug;
  
     if ($protectedpage)
     {
       if ($doredirect)
       {
         if (($PHP_SELF != "/index.php") && ($PHP_SELF != "/login.php"))
         {
           closeSession($boardsessionkey, "board");
           Header("Location: ".$redirectdestination);
           Exit();
         }
       }
     }
   }
   
   // -----------------------------------------------------------------------
   // -----------------------------------------------------------------------
   
   // Check the System Bans to see if this user is banned from this IP
   
   if (BOARD_FUNCTIONS_AVAILABLE == 1)
   {
     // Don't do this if we're on banned.php already
     if ((basename($PHP_SELF) != "banned.php") && (basename($PHP_SELF) != "login.php"))
     {
       $userbanstate = assessBanStatus($REMOTE_ADDR, $userdata[ID]);
       if ($userbanstate[banned])
       {
         Header("Location: $DBRoot/banned.php");
       }
     }
   }

   // -----------------------------------------------------------------------
   // -----------------------------------------------------------------------
   
   // Do some cache control, if we have a logged-in user
   if ($userdata[ID])
   {
     Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");               // Date in the past
     Header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
     Header("Cache-Control: no-store, no-cache, must-revalidate");   // HTTP/1.1
     Header("Cache-Control: post-check=0, pre-check=0", false);
     Header("Pragma: no-cache"); 
   }

   // -----------------------------------------------------------------------
   // -----------------------------------------------------------------------
   
   if (BOARD_FUNCTIONS_AVAILABLE == 1)
   {
     // Handle site navigation drill-down bar here
     $navigation[] = array("name" => "[".applyOnlyTextEffects($SiteCode)."]",
                           "url"  => $SiteURL);
     $navigation[] = array("name" => applyOnlyTextEffects($DiscoBoardName),
                           "url"  => "index.php");
     
     if ($postid)
     {
       $postdata   = fetchRow($postid, TABLE_POSTS);
       $threaddata = fetchRow($postdata[threadid], TABLE_THREADS);
       $boarddata  = fetchRow($threaddata[boardid], TABLE_BOARDS);
       $groupdata  = fetchRow($boarddata[groupid], TABLE_GROUPS);
       
       $navigation[] = array("name" => applyOnlyTextEffects($groupdata[groupname]),
                             "url"  => "index.php?action=viewgroup&groupid=".$boarddata[groupid]);
       $navigation[] = array("name" => applyOnlyTextEffects($boarddata[boardname]),
                             "url"  => "board.php?boardid=".$threaddata[boardid]);
       $navigation[] = array("name" => ProfanityFilter(applyOnlyTextEffects($postdata[subject])),
                             "url"  => "");
     }
     
     if ($threadid)
     {
       $threaddata = fetchRow($threadid, TABLE_THREADS);
       $firstpostdata = fetchRow($threaddata[postidfirst], TABLE_POSTS);
       $boarddata  = fetchRow($threaddata[boardid], TABLE_BOARDS);
       $groupdata  = fetchRow($boarddata[groupid], TABLE_GROUPS);
       
       $navigation[] = array("name" => applyOnlyTextEffects($groupdata[groupname]),
                             "url"  => "index.php?action=viewgroup&groupid=".$boarddata[groupid]);
       $navigation[] = array("name" => applyOnlyTextEffects($boarddata[boardname]),
                             "url"  => "board.php?boardid=".$threaddata[boardid]);
       $navigation[] = array("name" => ProfanityFilter(applyOnlyTextEffects($firstpostdata[subject])),
                             "url"  => "");
     }
     
     if ($boardid)
     {
       $boarddata = fetchRow($boardid, TABLE_BOARDS);
       $groupdata = fetchRow($boarddata[groupid], TABLE_GROUPS);
  
       $navigation[] = array("name" => applyOnlyTextEffects($groupdata[groupname]),
                             "url"  => "index.php?action=viewgroup&groupid=".$groupdata[ID]);
       $navigation[] = array("name" => applyOnlyTextEffects($boarddata[boardname]),
                             "url"  => "board.php?boardid=".$boardid);
     }
   }
?>
