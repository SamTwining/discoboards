<?
   // This is the default DiscoBoard theme. It's modelled loosely on the
   // look and feel of IGNBoards http://boards.ign.com.
   
   $bodycolor      = "white";
   $bodybackground = "";
   $pagetitle      = "DiscoBoards";
   if ($pageareatitle)
   {
     $pagetitle = $pagetitle." | ".$pageareatitle;
   }

   if ($bodybackground)
   {
     $bodybackgroundtag = " BACKGROUND='$bodybackground'";
   }
   
   // Final definition of page layout conditions...
   $pagetop = "<HTML>\n"
             ."<HEAD>\n"
             ." <TITLE> $pagetitle </TITLE>\n"
             ." <LINK REL=STYLESHEET HREF='stylesheet.".$configoptions[themename].".php' TYPE='text/css'>\n"
             .$javascriptlink
             ."</HEAD>\n"
             ."<BODY MARGINWIDTH=0 MARGINHEIGHT=0 LEFTMARGIN=0 TOPMARGIN=0 \n"
             ."      BGCOLOR='$bodycolor' ".$bodybackgroundtag." \n"
             ."      TEXT='black' LINK='blue' VLINK='blue' ALINK='red'>\n"
             ."<BR>\n"
             ."<TABLE WIDTH=100% ALIGN=CENTER CELLPADDING=4 CELLSPACING=0 BORDER=0>\n"
             ."<TR><TD WIDTH=10><IMG SRC='$GFXRoot/blank.gif' WIDTH=10 HEIGHT=10 ALT=''></TD>\n"
             ."<TD WIDTH=100% CLASS='MainTable'>\n"
             .""
             .$pageformstart
             .$navigationrow
             .$menurow
             .$areaoptionsrow
             .$messagerow
             .$centerrow
             ."";
             
   $pageend = $centerrow
             .$bottommessagerow
             .$navigationrow
             ."<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0 BORDER=0><TR>\n"
             ."<TD CLASS='VersionText'><B CLASS='black'>Current Time: ".dateNeat(Date("U"))."</B></TD>\n"
             ."<TD ALIGN=RIGHT CLASS='VersionText'>DiscoBoard v".$DBVersion."</TD>\n"
             ."</TR></TABLE></TD>\n"
             ."<TD WIDTH=10><IMG SRC='$GFXRoot/blank.gif' WIDTH=10 HEIGHT=10 ALT=''></TD>\n"
             ."</TR>\n"
             ."</TABLE><BR>\n"
             .$pageformstop
             ."</BODY>\n"
             ."</HTML>\n";
?>
