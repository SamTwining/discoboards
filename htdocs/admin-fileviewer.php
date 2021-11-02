<?
   $protectedpage = 1;
   $functionset   = "admin";
   include("common.php");

   $navigation[] = array("name" => "File Viewer",
                         "url"  => $PHP_SELF);
   
   $mandatory = "<SPAN CLASS='red'>�</SPAN>";
   
   $allowedfileextensions = array("php", "php3", "html", "txt");
   
   if (checkAccess("accessadmin"))
   {
     include("elements/fileviewer.php");
     $form = "<FORM ACTION='".$PHP_SELF."' METHOD=POST>\n"
            .inputHidden("action", "view")
            .$fileviewform
            ."</FORM>\n";
     
     if ($action == "view")
     {
       $filename = trim($filename);
       if (!$filename)                              { $err[] = "No filename was specified"; }
       else
       {
         // Add a leading / if its not there already
         if (substr($filename, 0, 1) != "/")
         {
           $filename = "/".$filename;
         }
         
         $filefullpath = $DocRoot.$filename;
         
         // Validate that the file exists and is a file we allow them to see
         if (!file_exists($filefullpath))           { $err[] = $filename." does not exist"; }
         else
         {
           $validextensionereg = "\\.(".implode("|", $allowedfileextensions).")$";
           if (!ereg($validextensionereg, $filename)) { $err[] = "Filename does not end in ".implode(",", $allowedfileextensions); }
         }
       }
       
       if ($err)
       {
         $reason = implode("<BR>\n", $err);
         $action = "";
       }
       else
       {
         // Fetch the file's contents
         $filedata = file($filefullpath);
         
         for ($i = 0; $i < count($filedata); $i++ )
         {
           $filedataoutput .= "#%#<SPAN STYLE='color: #888888;'>".substr("     ".($i+1), -5)."</SPAN> | ".htmlentities($filedata[$i]);
         }
         
         $output = "<B>".$filename."</B><BR>\n"
                  ."<TABLE WIDTH=90% CELLSPACING=0 CELLPADDING=3 BORDER=1><TR><TD BGCOLOR='white' STYLE='font-size: 8pt;'><PRE>\n"
                  .$filedataoutput
                  ."</PRE></TD></TR></TABLE>\n";
       }
     }
     
     $output = $form.$output;
   }
   else
   {
     $output = "<TABLE WIDTH=100% CELLPADDING=20 CELLSPACING=1 BORDER=0>\n"
              ."<TR><TD CLASS='BoardRowBody'>\n"
              ."        <B CLASS='red'>You don't have access to this page</B></TD></TR>\n"
              ."</TABLE>\n";
   }
   
   if ($reason)
   {
     $reasonoutput = "<B CLASS='red'>".$reason."</B>\n"
                    ."<P>\n";
   }
   
   $output = $reasonoutput.$output;
   
   // ALWAYS wrap output on this page.
   $wrapoutput = 1;
   
   if ($wrapoutput)
   {
     $output = "<TABLE WIDTH=100% CELLPADDING=20 CELLSPACING=1 BORDER=0>\n"
              ."<TR><TD CLASS='BoardRowBody'>\n"
              ."        ".str_replace("\n", "\n        ", $output)."</TD></TR>\n"
              ."</TABLE>\n";
   }       

   $pagecontents = $output;
   include("layout.php");
?>
