<?
   include("common.php");
   
   $viewboard = viewBoard($boardid, $page);
   
   $output    = $viewboard[boardoutput];
   $centerrow = $viewboard[navbar];
   
   $areaoptions[] = array("name" => "Start New Thread",
                          "url"  => "post.php?boardid=$boardid");
   if ($userloggedin)
   {
     $areaoptions[] = array("name" => "Create Poll",
                            "url"  => "poll.php?boardid=$boardid&returnurl=".urlencode($PHP_SELF.$querystring));
     if (!inFavourites($userdata[ID], "boardid", $boardid))
     {
       $areaoptions[] = array("name" => "Add to Favourites",
                              "url"  => "watch.php?action=addboard&boardid=$boardid&returnurl=".urlencode($PHP_SELF.$querystring));
     }
   }

   // Show the last 10 logins on the bottom of the page
   $lastusers = fetchLoggedinUsers(10, "recent");
   if ($lastusers[userlist])
   {
     $bottommessage = makeLink("usersonline.php", "Currently online", "MainMenuLink").": ".$lastusers[userlist];
   }
   
   $pagecontents = $output;
   include("layout.php");
?>
