<?
   include("common.php");
   
   if ($action)
   {
     if ($username)
     {
       $vars[classid] = 1;
       
       $userinfo = fetchRow($username, TABLE_USERS, "displayname", "idfieldistext", "dontcareifblank");
       if ($userinfo[ID])
       {
         $update = updateUser($userinfo[ID], $vars);
         if ($update)
         {
           $output = "$username has been upgraded.<BR>\n"
                    ."<P>\n"
                    ."<SPAN CLASS='red'>\n"
                    ."<B>IMPORTANT</B><BR>\n"
                    ."You should now <U>DELETE</U> this file, as it is a \n"
                    ."<U>SECURITY RISK</U>!\n"
                    ."<P>\n"
                    ."If you can't delete the file, ask your administrator \n"
                    ."to do it for you.\n"
                    ."<P>\n"
                    ."The full path of this file is ".$DocRoot.$PHP_SELF.".\n"
                    ."</SPAN>\n";
         }
         else
         {
           $reason = "Couldn't update this user - you'll have to do it manually.<BR>\n";
           $action = "";
         }
       }
       else
       {
         $reason = "Didn't find a user named  <I>".$username."</I>. Mistyped?<BR>\n";
         $action = "";
       }
     }
     
   }
   
   if (!$action)
   {
     $output = "Enter a username to upgrade to Super User (class 1)\n"
              ."<P>\n"
              ."<FORM ACTION='$PHP_SELF' METHOD=POST>\n"
              .inputHidden("action", "super")
              .inputText("username", $username)
              .inputSubmit("Upgrade")
              ."</FORM>\n";
   }

   if ($reason)
   {
     $reasonoutput = "<B CLASS='red'>".$reason."</B>\n"
                    ."<P>\n";
   }
   
   $output = "<TABLE WIDTH=100% CELLPADDING=20 CELLSPACING=1 BORDER=0>\n"
            ."<TR><TD CLASS='BoardRowBody'>\n"
            ."        ".str_replace("\n", "\n        ", $reason.$output)."</TD></TR>\n"
            ."</TABLE>\n";
   $pagecontents = $output;
   include("layout.php");
?>