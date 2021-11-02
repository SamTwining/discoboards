<?
   include("common.php");
   
   if ($action == "viewgroup")
   {
     $listboards = listGroups("", $groupid);
     
     $output = $listboards;

     $groupdata  = fetchRow($groupid, TABLE_GROUPS);
     $navigation[] = array("name" => $groupdata[groupname],
                           "url"  => "");
     $navigation[] = array("name" => "Choose a Board",
                           "url"  => "");
   }
   
   if (!$action)
   {
     // Allow the user to specify Open All Groups
     if ($show == "all") { $showall = "all"; }
     
     if ($OpenAllGroupsSetting) 
     { $showall = "all"; }
     
     $output = listGroups("", $showall);
     $navigation[] = array("name" => "Choose a Board",
                           "url"  => "");
     $stats = boardStats();
     $systemmessageextra = "<B CLASS='statistictext'>Total boards: <SPAN CLASS='statisticvalue'>".number_format($stats[boards])."</SPAN> | Total Messages: <SPAN CLASS='statisticvalue'>".number_format($stats[total])."</SPAN> (<SPAN CLASS='statisticvalue'>".number_format($stats[today])."</SPAN> posted today) | ".makeLink("usersonline.php", "Show Online Users", "MainMenuLink")."</B>";
   }

   if (($show != "all") && (!$OpenAllGroupsSetting))
   {
     $areaoptions[] = array("name" => "Open All Groups",
                            "url"  => $PHP_SELF."?show=all");
   }
   elseif (!$OpenAllGroupsSetting)
   {
     $areaoptions[] = array("name" => "Close All Groups",
                            "url"  => $PHP_SELF);
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
