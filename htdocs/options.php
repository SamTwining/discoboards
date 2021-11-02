<?
   $protectedpage = 1;
   include("common.php");
   
   $navigation[] = array("name" => "Options",
                         "url"  => "$PHP_SELF");
   
   // Wrap this page's output in a padded table by default
   $wrappage = 1;
   
   if ($action == "usersearchresults")
   {
     $navigationhead = "Search Results";

     if (!trim($searchuser)) { $err[] = "No username to match!"; }
     
     if ($err)
     {
       $reason = implode("<BR>\n", $err);
     }
     else
     {
       $searchresults = listUsers($searchuser, "");
       
       if ($$searchresults[resultcnt]) 
       {
         $reason = "No users were found<BR>\n"; 
       }
       else
       {
         $output = ""
                  //."<SPAN CLASS='InputSection'>Search Results</SPAN><BR>\n"
                  //."<FORM ACTION='$PHP_SELF' METHOD=POST>\n" 
                  //.inputHidden("action", "manageusers")
                  //.inputHidden("checkboxcount", $searchresults[checkboxcount])
                  //.inputHidden("step", 3)
                  .$searchresults[usertable] 
                  //.inputSubmit("Proceed")
                  //."</FORM>\n"
                  ."";
       }
       $action = "usersearch";
       $wrappage = 0;
     }
   }
   
   if ($action == "usersearch")
   {
     $navigationhead = "Find Users";
     
     include("elements/listusers.php");
     $output .= "<TABLE WIDTH=100% CELLPADDING=10>\n"
               ."<TR VALIGN=TOP>\n"
               ."    <TD CLASS='BoardRowBody'>\n"
               ."        <FORM ACTION='$PHP_SELF' METHOD=POST>\n"
               ."        ".inputHidden("action", "usersearchresults")
               ."        ".str_replace("\n", "        ", $searchform)
               ."        ".inputSubmit("Search")
               ."        </FORM></TD></TR>\n"
               ."</TABLE>\n";
     
   }

   if (checkAccess("accessnameformat"))
   {
     if ($action == "savenameformat")
     {
       $navigationhead = "Update Name Formatting";
       
       $validcolourregex = "^\#[A-Fa-f]{6}$";
       
       // Make sure a valid colour code comes through for colour attributes.
       // First, see if the same code we put into inputChoice() comes back 
       // from it.
       $sethlcolour     = inputChoice("colours", "hlcolour", $hlcolour, "show");
       $settxtcolour    = inputChoice("colours", "txtcolour", $txtcolour, "show");
       $setbordercolour = inputChoice("colours", "txtcolour", $bordercolour, "show");
       
       // Now check - if the same code DIDN'T come back, then validate it 
       // against $validcolourregex
       if (($sethlcolour != $hlcolour) && (ereg($validcolourregex, $hlcolour))) 
       { $sethlcolour = $hlcolour; }
       if (($settxtcolour != $txtcolour) && (ereg($validcolourregex, $txtcolour))) 
       { $settxtcolour = $txtcolour; }
       if (($setbordercolour != $bordercolour) && (ereg($validcolourregex, $bordercolour))) 
       { $setbordercolour = $bordercolour; }
       
       $newsettings[hlcolour]       = $sethlcolour;
       $newsettings[txtcolour]      = $settxtcolour;
       $newsettings[stylebold]      = $bold;
       $newsettings[styleitalic]    = $italic;
       
       $newsettings[styleunderline]     = $underline;
       $newsettings[styleoverline]      = $overline;
       $newsettings[stylestrikethrough] = $strikethrough;
       
       $newsettings[bottomborder] = $bottomborder;
       $newsettings[topborder]    = $topborder;
       $newsettings[leftborder]   = $leftborder;
       $newsettings[rightborder]  = $rightborder;
       $newsettings[bordercolour] = $setbordercolour;
       
       if ($sethlcolour || $settxtcolour || $bold || $italic || $underline || $overline || $strikethrough || $bottomborder || $topborder || $leftborder || $rightborder || $setbordercolour)
       {
         $vars[displayformat] = serialize($newsettings);
       }
       else
       {
         $vars[displayformat] = "";
       }
       
       $update = updateUser($userdata[ID], $vars, "no");
       if ($update)
       {
         $userdata[displayformat] = $vars[displayformat];
         $sysmsg = "custom";
         $sysmsgcustomcontent = "Your name display formatting has been updated.";
         $action = "";
       }
       else
       {
         $reason = "Err, something went wrong";
         $action = "nameformat";
       }
     }
     
     if ($action == "nameformat")
     {
       $navigationhead = "Name Formatting";
  
       $formatsettings = unserialize($userdata[displayformat]);
       //print_r($formatsettings);
       //echo "<BR>\n";
       $hlcolour  = $formatsettings[hlcolour];
       $txtcolour = $formatsettings[txtcolour];
       $bold      = $formatsettings[stylebold];
       $italic    = $formatsettings[styleitalic];
       // Legacy
       $bottomborder  = $formatsettings[styleunderline];
       $topborder     = $formatsettings[styleoverline];
       $strikethrough = $formatsettings[stylestrikethrough];
       // Border switches
       $bottomborder = $formatsettings[bottomborder];
       $topborder    = $formatsettings[topborder];
       $leftborder   = $formatsettings[leftborder];
       $rightborder  = $formatsettings[rightborder];
       $bordercolour = $formatsettings[bordercolour];
       
       include("elements/nameformat.php");
       $output = "<SPAN CLASS='InputSection'>Change Name Colour</SPAN><BR>\n"
                ."Select the styles you want to apply to your name below.<BR>\n"
                ."<FORM ACTION='$PHP_SELF' METHOD=POST>\n"
                .inputHidden("action", "savenameformat")
                .$nameformatform
                ."<P>\n"
                .inputSubmit("Change Formatting")
                ."</FORM>\n";
     }
   }
   
   if ($action == "savepass")
   {
     $navigationhead = "Change Password";

     if (!$currpass)     { $err[] = "No current password was entered"; }
     else
     {
       $auth = userAuth($userdata[displayname], $currpass);
       if ($auth[result] != "valid")
                         { $err[] = "Current password is incorrect"; }
     }
     if (!$password1)    { $err[] = "No password was entered"; }
     if (!$password2)    { $err[] = "No verification password was entered"; }
     if (($password1) && ($password2))
     {
       if ($password1 != $password2)      
                         { $err[] = "Passwords don't match"; }
     }
     
     if ($err)
     {
       $reason = implode("<BR>\n", $err);
       $action = "changepass";
       $currpass = "";
       $password1 = "";
       $password2 = "";
     }
     else
     {
       // Hash the password and store it
       $data[encpassword] = hashPassword($password1, "authenticate");;
       
       $update = updateUser($userdata[ID], $data);
       if ($update)
       {
         $sysmsg = "custom";
         $sysmsgcustomcontent = "Your password has been changed.";
         $action = "";

         // Send the user a notification email to tell them the password has changed
         $email = implode("", file("templates/changepass.txt"));
         
         // Replace the special bits in the welcome email
         $email = str_replace("FNAME", $userdata[fname], $email);
         $email = str_replace("DISCOBOARDNAME", $DiscoBoardName, $email);
         $email = str_replace("IPADDRESS", $REMOTE_ADDR, $email);
         $email = str_replace("USERNAME", $userdata[displayname], $email);
         $email = str_replace("PASSWORD", $password1, $email);
         $email = str_replace("DBROOT", $DBRoot, $email);
         
         $recipient = trim($userdata[fname]." ".$userdata[sname]);
         $recipientfull = $recipient." <".$userdata[contactemail].">";
         
         sendSystemEmail($recipientfull, "passchange", $email);
       }
       else
       {
         $reason = "Err, something went wrong";
         $action = "display";
       }
     }
   }
   
   if ($action == "changepass")
   {
     $navigationhead = "Change Password";
     $mandatory = "<SPAN CLASS='red'>�</SPAN>";
     
     include("elements/changepass.php");
     $output = "<SPAN CLASS='InputSection'>Change Password</SPAN><BR>\n"
              ."Enter your new password twice below. For verification, you will \n"
              ."also need to enter your current password before the change can \n"
              ."be made.<BR>\n"
              ."<FORM ACTION='$PHP_SELF' METHOD=POST>\n"
              .inputHidden("action", "savepass")
              .$changepassform
              ."<P>\n"
              .inputSubmit("Change Password")
              ."</FORM>\n";
   }
   
   if ($action == "savedisplay")
   {
     $navigationhead = "Adjust Display Settings";

     $data[perpageposts]   = $perpageposts;
     $data[perpagethreads] = $perpagethreads;
     $data[timezone]       = $timezone;
     
     $update = updateUser($userdata[ID], $data);
     if ($update)
     {
       $sysmsg = "custom";
       $sysmsgcustomcontent = "Your display settings have been updated.";
       $action = "";

       // Insert these into the current settings
       $configoptions[perpagethreads] = $data[perpagethreads];
       $configoptions[perpageposts]   = $data[perpageposts];
       $configoptions[timezonechange] = $data[timezone];
     }
     else
     {
       $reason = "Err, something went wrong";
       $action = "display";
     }
   }
   
   if ($action == "display")
   {
     $navigationhead = "Adjust Display Settings";

     $userinfo = $userdata;
     
     include("elements/displaysettings.php");
     $output = "<FORM ACTION='$PHP_SELF' METHOD=POST>\n"
              .inputHidden("action", "savedisplay")
              .$displaysettingsform
              ."<P>\n"
              .inputSubmit("Save Display Settings")
              ."</FORM>\n";
   }
   
   if (!$action)
   {
     $navigationhead = "Options";
     
     // Define options
     if (checkAccess("accessnameformat"))
     {
       $pageopt[] = array("name" => "Name Formatting",
                          "url"  => $PHP_SELF."?action=nameformat",
                          "desc" => "Change the colour and text modes used to display your name. \n"
                                   ."This allows you to stand out from the crowd. \n");
     }
     $pageopt[] = array("name" => "Edit Your Profile",
                        "url"  => "user.php?action=edit",
                        "desc" => "Change the information in your profile (shown when \n"
                                 ."users click on your username). This information can \n"
                                 ."help other board members to get to know you better.\n");
     $pageopt[] = array("name" => "Display Settings",
                        "url"  => $PHP_SELF."?action=display",
                        "desc" => "These options affect the presentation of some \n"
                                 ."parts of the board system - number of items per page, \n"
                                 ."timezone selection etc.\n");
     $pageopt[] = array("name" => "Choose Icon",
                        "url"  => "icon.php",
                        "desc" => "Use this tool to change the icon associated with your \n"
                                 ."account. Your icon will appear next to every post you \n"
                                 ."make on the system.\n");
     $pageopt[] = array("name" => "Change Password",
                        "url"  => $PHP_SELF."?action=changepass",
                        "desc" => "You can change that password used to log into this \n"
                                 ."account here.\n");
     $pageopt[] = array("name" => "Manage your Favourites",
                        "url"  => "watch.php",
                        "desc" => "Check your favourite boards, and watched users/topics here.\n");
     $pageopt[] = array("name" => "User Search",
                        "url"  =>  $PHP_SELF."?action=usersearch",
                        "desc" => "Search for other members based on their username.\n");
     
     // Show a menu of options availabale to the user
     for ($i = 0; $i < count($pageopt); $i++ )
     {
       $output .= makeLink($pageopt[$i][url], $pageopt[$i][name])."<BR>\n"
                 .$pageopt[$i][desc]
                 ."<P>\n";
     }
   }
   
   if ($reason)
   {
     $reasonoutput = "<B CLASS='red'>".$reason."</B>\n"
                    ."<P>\n";
   }
   $output = $reasonoutput
            .$output;
   
   if ($wrappage)
   {
     $output = "<TABLE WIDTH=100% CELLPADDING=20 CELLSPACING=1 BORDER=0>\n"
              ."<TR><TD CLASS='BoardRowBody'>\n"
              ."        ".str_replace("\n", "\n        ", $output)."</TD></TR>\n"
              ."</TABLE>\n";
   }
         
   $pagecontents = $output;
   include("layout.php");
?>