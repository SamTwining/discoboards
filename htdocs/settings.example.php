<?
   // ===============================================================================
   // DiscoBoard Configuration File
   // ===============================================================================
   
   // BEFORE YOU PROCEED FOR THE FIRST TIME, YOU NEED TO RENAME THIS FILE
   // -------------------------------------------------------------------
   // Look at the address (URL) by which your DiscoBoard forum will be accessed.
   // Take the HOSTNAME (for example www.yahoo.com, forums.mydomainnamename.com, 
   // members.lycos.com) from the URL and remove EVERYTHING that is not a letter 
   // or a number. This string, the IDENTIFIER. is the name by which DiscoBoard 
   // will refer to this file. Note that it doesn't matter what path you have to
   // follow beyond the hostname - we're only interested in the hostname at the
   // moment.
   // 
   // Example identifier derivation:
   //  www.yahoo.com becomes "wwwyahoocom"
   //  boards.shadow.net.au becomes "boardsshadownetau"
   //  members.my-domain.com becomes "membersmydomaincom"
   // ... and so on.
   //
   // Now, take your IDENTIFIER, and rename this file to settings.IDENTIFIER.php
   // and DiscoBoard will be able to find it.
   
   // ===============================================================================
   // Description of this file
   // ------------------------
   // This file forms the guts of DiscoBoard's configuration - filling in the right
   // values here is the bare minimum you can get away with in order to get the 
   // system up and running.
   // 
   // You will find that the file is broken up into 5 major areas:
   //  - Server Configuration
   //  - MySQL Configuration
   //  - Session Settings
   //  - User Restriction Settings
   //  - Cosmetic Settings
   // 
   // Each option is explained by the // comments above it
   // 
   // ===============================================================================

   // Server Configuration
   // -------------------
   
   // AccessProtocol is the protocol that a web browser will use to access your
   // DiscoBoard. This will either be "http" for a URL starting with http://,
   // or "https" for https://
   $AccessProtocol = "http";
   
   // ServerAddress is hostname of the server you are running DiscoBoard on. It 
   // should pick up $HTTP_HOST, but if it doesn't you should set it here. This 
   // shouldn't have a filename, nor HTTP protocol or trailing slash. 
   // Eg, boards.yourdomain.com
   $ServerAddress = $HTTP_HOST;
   
   // DocRoot is the DocumentRoot of the server you're running DiscoBoard on.
   // It should pick up $DOCUMENT_ROOT, but if it doesn't you should set it 
   // here. Once again, it should not have a trailing slash.
   // Eg, /usr/local/apache/virtual/boards.yourdomain.com/htdocs
   $DocRoot = $DOCUMENT_ROOT;

   // BaseDir is the directory to which you've installed DiscoBoard. If it's in 
   // the DocumentRoot of the server you're running DiscoBoard on, you can leave
   // this blank. This should have a leading slash.
   // Eg, /forum
   $BaseDir = "";
   
   // MySQL Configuration
   // -------------------
   
   // MySQLServer is the hostname of the MySQL server you've set up the
   // database for DiscoBoard on. If you need to connect on a specific port
   // number, you should specify it here. If you're not sure what value to 
   // put here, you should consult your system administrator or hostmaster.
   // Eg, mysql.yourdomain.com or mysql.yourdomain.com:3188
   $MySQLServer = "";
   
   // MySQLUsername and MySQLPassword are used for authentication of your
   // connection to the MySQL database server. If you're not sure what value 
   // to put here, you should consult your system administrator or hostmaster.
   $MySQLUsername = "";
   $MySQLPassword = "";
   
   // MySQLDatabase is the name of the database which has been set up to hold
   // the DiscoBoard data. If you're not sure what value to put here, you 
   // should consult your system administrator or hostmaster.
   // Eg, boards
   $MySQLDatabase = "";
   
   // DatabasePrefix is a prefix added to the front of all DiscoBoard table names 
   // within the system's database - when in use, a table named "name" will be referred 
   // to as "prefix_name" instead. This allows DiscoBoard to coexist happily with other 
   // tables sharing its database. If you want to rename all the tables, you will need
   // to use "rename-tables.sql" in the support/ directory of the distribution. You
   // may need to edit the SQL before running it.
   $DatabasePrefix = "disco";

   // Session Settings
   // ----------------
   
   // SessionTime is the default length of time (in minutes) a login session 
   // will last for. It should just be an integer value.
   // Eg, 60
   $SessionTime = 120;
   
   // MultipleLogins defines whether or not a user is allowed to log into the
   // system (start a session) while a current, not-expired session exists in
   // the session table. Should just be an integer value, 0 or no or 1 for yes.
   $MultipleLogins = 1;
   
   // User Restriction Settings
   // -------------------------
   
   // GraceTime is the number of minutes a user is allowed to edit their posts
   // for after the post is first created. Usually this is 90 minutes.
   // Eg, 90
   $GraceTime = 90;
   
   // ShowThreadsPerPage and ShowPostsPerPage control the number of threads and
   // posts shown on a page in the board view and thread view respectively (the
   // board view shows threads, the thread view shows posts). These are the
   // default settings that apply to all users - members can set their own
   // options which will take effect after they log in. Should just be an
   // integer value
   // Eg, 20
   $ShowThreadsPerPage = 25;
   $ShowPostsPerPage = 25;
   
   // ProfanityFilter is a case INsensitive group of replacement texts. The
   // first element of the array is replaced with the second when the post
   // is viewed.
   $ProfanityFilterActive = 1;
   $ProfanityFilter[] = array("fuck", 'f@%&');
   $ProfanityFilter[] = array("cunt", 'c&!$');
   $ProfanityFilter[] = array("shit", 's#!%');

   // Threshold limits a user to posting X amount of items in Y seconds. Note
   // there's 3600 seconds in an hour, 86400 in a day, 604800 in a week. Set
   // a limit to 0 to apply no limit.
   $Threshold[post] = array("limit" => 0, "time" => 86400);
   $Threshold[poll] = array("limit" => 2, "time" => 604800);
   
   // UseOwnIcons is a boolean flag which tells DiscoBoard whether or not you want users to be able
   // to link to their own icons via an external URL. Bear in mind that loading icons from a remote
   // server may get you into trouble, and could cause problems if the remote server is down. This
   // should be set to 0 for off, and 1 for on
   // Eg, 1
   $UseOwnIcons = 1;

   // Cosmetic Settings
   // -----------------
   
   // A ThemeName settings is the name of the theme.[ThemeName].php file that 
   // DiscoBoard will use for its page layout. This basically controls the top 
   // and bottom (and sides if you get fancy with your tables) of the page, into 
   // which the output from DiscoBoard is placed. Actual configuration of the 
   // output from DiscoBoard is not done here.
   // Eg, disco
   $ThemeName = "disco";
   
   // SiteCode should be a short canonical name or abbreviation for your 
   // site. It should only be a few letters long to avoid taking up screen
   // space
   // Eg, SN, PCW, MLBIT
   $SiteCode = "SN";

   // SiteName should be the full name you use for your site. This is mainly
   // used in communications with users (emails, etc)
   // Eg, ShadowNet
   $SiteName = "DiscoBoard";
   
   // SiteURL should be the full URL of your website
   // Eg, http://www.yourdomainname.com/path/to/your/site/
   $SiteURL = "http://www.shadow.net.au/";
   
   // DiscoBoardName should be the full name you want to give to your
   // DiscoBoard installation
   // Eg, "DiscoBoard"
   $DiscoBoardName = "DiscoBoard";
   
   // DiscoBoard awards stars to users based on the number of posts they've
   // made. The levels at which the stars are awarded can be set by you. There
   // are 10 levels. This should just be an integer value.
   // Eg, 10
   //$PostLevel[1]  = 10; // There is no star1.gif
   $PostLevel[2]  = 20;
   $PostLevel[3]  = 30;
   $PostLevel[4]  = 40;
   $PostLevel[5]  = 50;
   $PostLevel[6]  = 60;
   $PostLevel[7]  = 70;
   $PostLevel[8]  = 80;
   $PostLevel[9]  = 90;
   $PostLevel[10] = 100;
   
   // HiddenClasses are class names that are not displayed below a user's
   // name in a message display mode. This is a comma-separated list.
   // Eg: Admin,Standard,Drunkard
   $HiddenClasses = "Standard,Banned,Locked Out";
   
   // OpenAllGroupsSetting tells DiscoBoard to show all boards in all groups
   // by default. If you've only got a small number of boards, you might want
   // to set this to "all" so that users don't have to click on a group name
   // to see the boards contained in it. Should either be "all" or "".
   // Eg, all
   $OpenAllGroupsSetting = "";

   // TimeZoneChange is the number of hours + or - from the server's default
   // that you want DiscoBoard to adjust all the times by. In future this
   // setting may become user-specific. You may need to experiment a bit in
   // order to set this value, it depends where your host is located.
   // Eg: +5, 3, -1
   $TimeZoneChange = 0;
   
   // Emoticon substitution is defined as arrays below. Each element in the array
   // defines one emoticon substitution rule and holds three important elements:
   // 1. The general name of the face used in [face_X] text substitution, 2. The
   // shortcut :) face used in text substitution and 3. The actual filename of
   // the related image, relative to the gfx/faces subdirectory.
   $EmoticonSet[] = array("name" => "happy",    "code" => ":)",   "filename" => "face_happy.gif");
   $EmoticonSet[] = array("name" => "sad",      "code" => ":(",   "filename" => "face_sad.gif");
   $EmoticonSet[] = array("name" => "grin",     "code" => ":D",   "filename" => "face_grin.gif");
   $EmoticonSet[] = array("name" => "love",     "code" => ":x",   "filename" => "face_love.gif");
   $EmoticonSet[] = array("name" => "cool",     "code" => "B-)",  "filename" => "face_cool.gif");
   $EmoticonSet[] = array("name" => "silly",    "code" => ":p",   "filename" => "face_silly.gif");
   $EmoticonSet[] = array("name" => "angry",    "code" => "x-(",  "filename" => "face_angry.gif");
   $EmoticonSet[] = array("name" => "laugh",    "code" => ":^O",  "filename" => "face_laugh.gif");
   $EmoticonSet[] = array("name" => "wink",     "code" => ";)",   "filename" => "face_wink.gif");
   $EmoticonSet[] = array("name" => "blush",    "code" => ":8}",  "filename" => "face_blush.gif");
   $EmoticonSet[] = array("name" => "cry",      "code" => ":_|",  "filename" => "face_cry.gif");
   $EmoticonSet[] = array("name" => "confused", "code" => "?:|",  "filename" => "face_confused.gif");
   $EmoticonSet[] = array("name" => "shocked",  "code" => ":O",   "filename" => "face_shocked.gif");
   $EmoticonSet[] = array("name" => "plain",    "code" => ":|",   "filename" => "face_plain.gif");
   $EmoticonSet[] = array("name" => "lol",      "code" => "LOL",  "filename" => "face_lol.gif");
   $EmoticonSet[] = array("name" => "rofl",     "code" => "ROFL", "filename" => "face_rofl.gif");
   // IGN-style Emoticons
   //$EmoticonSet[] = array("name" => "angry",    "code" => "x-(",   "filename" => "ign/angry.gif");
   //$EmoticonSet[] = array("name" => "blush",    "code" => ":8}",   "filename" => "ign/blush.gif");
   //$EmoticonSet[] = array("name" => "confused", "code" => "?:|",   "filename" => "ign/confused.gif");
   //$EmoticonSet[] = array("name" => "cool",     "code" => "B-)",   "filename" => "ign/cool.gif");
   //$EmoticonSet[] = array("name" => "cry",      "code" => ":_|",   "filename" => "ign/cry.gif");
   //$EmoticonSet[] = array("name" => "devil",      "code" => "]:)", "filename" => "ign/cry.gif");
   //$EmoticonSet[] = array("name" => "grin",     "code" => ":D",    "filename" => "ign/grin.gif");
   //$EmoticonSet[] = array("name" => "happy",    "code" => ":)",    "filename" => "ign/happy.gif");
   //$EmoticonSet[] = array("name" => "laugh",    "code" => ":^O",   "filename" => "ign/laugh.gif");
   //$EmoticonSet[] = array("name" => "love",     "code" => ":x",    "filename" => "ign/love.gif");
   //$EmoticonSet[] = array("name" => "mischief", "code" => ";\\",   "filename" => "ign/love.gif");
   //$EmoticonSet[] = array("name" => "plain",    "code" => ":|",    "filename" => "ign/plain.gif");
   //$EmoticonSet[] = array("name" => "sad",      "code" => ":(",    "filename" => "ign/sad.gif");
   //$EmoticonSet[] = array("name" => "shocked",  "code" => ":O",    "filename" => "ign/shocked.gif");
   //$EmoticonSet[] = array("name" => "silly",    "code" => ":p",    "filename" => "ign/silly.gif");
   //$EmoticonSet[] = array("name" => "wink",     "code" => ";)",    "filename" => "ign/wink.gif");

   // MenuBarOptions defines an array of options you want added to your menu bar. These options
   // go after the standard ones on the Logged-in-as or Login/Register line. You can define a
   // link name, destination URL and hex #RRGGBB colour code for it
   //$MenuBarOptions[] = array("name"   => "Arbitrary Link to a thread within the board", 
   //                          "url"    => $DBRoot."/index.php?action=viewthread&threadid=X",
   //                          "colour" => "white");
   
   // ShowLastPosterName tells the system whether or not it should output the username (and
   // format it correctly) of the last poster in a thread when looking at a board. This should
   // be set to 0 for no, and 1 for yes
   $ShowLastPosterName = 1;
?>