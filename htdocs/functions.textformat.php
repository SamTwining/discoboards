<?
   define("TEXTFORMAT_FUNCTIONS_AVAILABLE", 1);

   // This function handles making everything nice and pretty in general.
   // It calls on other functions for specific effects, and then finally
   // does URL detection itself (for images and links)
   Function bodyText($text, $displayname = "")
   {
     global $configoptions;
     // Change all HTML special characters into their appropriate entities
     // so that we don't output anything odd
     $text = htmlentities($text);
     
     // Change smilies into graphics
     $text = smileEffects($text);
     
     // Perform text formatting markups (colours)
     $text = textEffects($text, $displayname);
     
     // Used for a regex later - these characters are not allowed in 
     $disallowedchars = $configoptions[disallowedchars];

     while ( eregi('\[[a-zA-Z0-9\=\_\:\/\.\~\? -\&]*\]', $text, $brackets) )
     { 
       //echo "Found ".count($brackets)." bracket items in text.<BR>\n";
       
       $item = 0;
       while( $brackets[$item] )
       {
         //echo "<HR>Match #".$item.":<BR>\n".htmlentities($brackets[$item])."<HR>\n";
         $thiskeylink = $brackets[$item];
         //echo "Working with: ".$thiskeylink."<BR>\n";
         $thiskeylink = str_replace("[", "", $thiskeylink);
         $thiskeylink = str_replace("]", "", $thiskeylink);
         
         //echo "Found: ".$thiskeylink." (was ".$brackets[$item].")<BR>\n";
         
         $char4 = substr($thiskeylink, 0, 4);
         //echo "That's ".$char4."<BR>\n";
         
         $replacement = "";
         switch($char4)
         {
           case "link":
             $linkurl = trim(str_replace("link=", "", $thiskeylink));
             //echo "linkurl: ".htmlentities($linkurl)."<BR>\n";
             if (ereg($disallowedchars, $linkurl))
             {
               //echo "<B>Bad you</B><BR>\n";
               $replacement = "";
             }
             else
             {
               $replacement = "<A HREF='$linkurl' TARGET='_new'>";
             }
             break;
           case "/lin":
             $replacement = "</A>";
             break;
           case "imag":
             $imageurl = trim(str_replace("image=", "", $thiskeylink));
             //echo "imageurl: ".htmlentities($imageurl)."<BR>\n";
             if (ereg($disallowedchars, $imageurl))
             {
               //echo "<B>Bad you</B><BR>\n";
               $replacement = "";
             }
             else
             {
               $replacement = "<A HREF='$imageurl' TARGET='_new'><IMG SRC='$imageurl' BORDER=1 WIDTH=160 HEIGHT=120 HSPACE=5 VSPACE=5></A>";
             }
             break;
           case "icon":
             $iconurl = trim(str_replace("icon=", "", $thiskeylink));
             $replacement = "<A HREF='$iconurl' TARGET='_new'><IMG SRC='$iconurl' BORDER=0 WIDTH=80 HEIGHT=80 HSPACE=5 VSPACE=5 STYLE='background-color: #b1b3bc; padding: 8px;'></A>";
             break;
           default:
             // If they just happen to have typed something between [] then let it 
             // through... but in this case we need to kill the brackets so turn it
             // into a placeholder we'll substitute back later...
             $replacement = "%%SQOPEN%%".$thiskeylink."%%SQCLOSE%%";
         }
         //echo "Replacing ".$brackets[$item]." with ".htmlentities($replacement)."...<BR>\n";
         $text = str_replace($brackets[$item], $replacement, $text);
         $item++;
       }
     }
     
     // Now, substitute our placeholders back
     $text = str_replace("%%SQOPEN%%", "[", $text);
     $text = str_replace("%%SQCLOSE%%", "]", $text);
     
     // PHP.net's manual page says this regex represents a URL. It seems to work.
     $url = "[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]";

     // Finally, find URLs on thir own and mark them up into links.
     $text = ereg_replace("^([".$url."]*)", "<A HREF='\\1' TARGET='_new'>\\1</A>", $text);
     $text = ereg_replace(" ([".$url."]*)", "<A HREF='\\1' TARGET='_new'>\\1</A>", $text);
     $text = ereg_replace("\n([".$url."]*)", "\n<A HREF='\\1' TARGET='_new'>\\1</A>", $text);

     // Add <BR>s at appropriate places
     $text = nl2br($text);
     
     return $text;
   }
   
   // Uses the Emoticon set defined in the settings file to change certain 
   // parts of messages into graphical smileys. The rule is that a space 
   // must precede the smiley for it to be changed (although if its the 
   // first text of a post, we'll allow it).
   Function smileEffects($text)
   {
     global $configoptions;
     
     $emoticons = $configoptions[emoticons];
     
     // Add a padding space at the start so that the substitution rule still works
     $text = " ".$text;
     
     for ($i = 0; $i < count($emoticons); $i++ )
     {
       $emoticonsrule = $emoticons[$i];
       
       $emoticonsimage = "<IMG ALIGN=ABSMIDDLE SRC='gfx/faces/".$emoticonsrule[filename]."'>";
       
       // Replace the code
       $text = str_replace(" ".$emoticonsrule[code], " ".$emoticonsimage, $text);
       $text = str_replace("\n".$emoticonsrule[code], "\n".$emoticonsimage, $text);
       
       // Replace the name
       $text = str_replace("[face_".$emoticonsrule[name]."]", $emoticonsimage, $text);
     }

     // Strip the padding space at the start
     $text = substr($text, 1, (strlen($text)-1));

     return $text;
   }
   
   // A simple way to apply only the textEffects() function to given text 
   // while still ensuring no weird HTML codes get output. This is used
   // whereever markup code is allowed in things like board names, group
   // names and subjects.
   Function applyOnlyTextEffects($text)
   {
     $text = htmlentities($text);
     $text = textEffects($text);
     return $text;
   }
   
   // This function handles all markup format codes which are applied to 
   // the text in a string. 
   Function textEffects($text, $displayname = "")
   {
     // Simple replacements
     $replace[] = array("[b]", "<B>");
     $replace[] = array("[/b]", "</B>");
     $replace[] = array("[i]", "<I>");
     $replace[] = array("[/i]", "</I>");
     $replace[] = array("[q]", "<DIV CLASS='QuotedText'>");
     $replace[] = array("[/q]", "</DIV>");
     $replace[] = array("[u]", "<U>");
     $replace[] = array("[/u]", "</U>");
     $replace[] = array("[o]", "<SPAN STYLE='text-decoration:overline;'>");
     $replace[] = array("[/o]", "</SPAN>");
     $replace[] = array("[blockquote]", "<BLOCKQUOTE>");
     $replace[] = array("[/blockquote]", "</BLOCKQUOTE>");
     $replace[] = array("[spaces]", "<SPAN STYLE='white-space: pre'>");
     $replace[] = array("[/spaces]", "</SPAN>");
     $replace[] = array("[bq]", "<BLOCKQUOTE>");
     $replace[] = array("[/bq]", "</BLOCKQUOTE>");
     $replace[] = array("[hr]", "<HR SIZE=1>");
     $replace[] = array("[ul]", "<UL>");
     $replace[] = array("[/ul]", "</UL>");
     $replace[] = array("[ol]", "<OL>");
     $replace[] = array("[/ol]", "</OL>");
     $replace[] = array("[li]", "<LI>");
     $replace[] = array("[/li]", "</LI>");
     $replace[] = array("[strike]", "<SPAN STYLE='text-decoration: line-through'>");
     $replace[] = array("[/strike]", "</SPAN>");

     // Only do this one if we HAVE a username to substitute...
     if ($displayname)
     {
       $replace[] = array("/me ", " <LI>".$displayname." ");
     }
     
     // Loop through the replace array and apply each one.
     for ($i = 0; $i < count($replace); $i++ )
     {
       $rule = $replace[$i];
       $text = str_replace($rule[0], $rule[1], $text);
     }
     
     // Find [color=blah][/color] and turn it into <SPAN> tags
     if (strstr($text, "[color"))
     {
       $text = ereg_replace("\[color\=([\#0-9a-zA-Z]*)\]", "<SPAN STYLE='color: \\1;'>", $text);
       $text = ereg_replace("\[/color]", "</SPAN>", $text);
     }
     
     // Find [glow=blah][/glow]
     //if (strstr($text, "[glow"))
     //{
     //  $text = ereg_replace("\[glow\=([\#0-9a-z]*)\]", "<SPAN STYLE='filter: glow(color=\\1, strength=2);'>", $text);
     //  $text = ereg_replace("\[/glow]", "</DIV>", $text);
     //}
     // ^^^ This didn't work unless I turned it into <TABLE> tags, and then #XXYYZZ would
     //     severely break it. So I aborted it.
     
     // Find [hl=blah][/hl]
     if (strstr($text, "[hl"))
     {
       $text = ereg_replace("\[hl\=([\#0-9a-zA-Z]*)\]", "<SPAN STYLE='background-color: \\1;'>", $text);
       $text = ereg_replace("\[/hl]", "</SPAN>", $text);
     }
     
     return $text;
   }
?>