<?
   include("common.php");

   $markupexample[] = array("[b]bold text[/b]");
   $markupexample[] = array("[i]italic text[/i]");
   $markupexample[] = array("[u]underlined text[/u]");
   $markupexample[] = array("[o]overlined text[/o]");
   $markupexample[] = array("[strike]struck-through text[/strike]");
   $markupexample[] = array("[bq]blockquoted text[/bq]");
   $markupexample[] = array("[spaces]text   with   all    spaces shown between words[/spaces]");
   $markupexample[] = array("[q]quoted text[/q]");
   $markupexample[] = array("[hr] (horizontal rule)");
   $markupexample[] = array("[ul][li]unordered list[li]unordered list[/ul]");
   $markupexample[] = array("[ol][li]ordered list[li]ordered list[/ul]");
   $markupexample[] = array("[color=red]red text[/color]");
   $markupexample[] = array("[hl=yellow]yellow highlight[/hl]");
   $markupexample[] = array("/me does something IRC-style");
   $markupexample[] = array("[link=http://www.yahoo.com/]Yahoo![/link]");
   $markupexample[] = array("[image=http://www.discosis.com/gfx/sn-icon.gif]");
   $markupexample[] = array("[icon=http://www.carlmmii.com/ico/annoy.gif]");
   
   for ($i = 0; $i < count($markupexample); $i++ )
   {
     $markuprow .= "<TR VALIGN=BASELINE>\n"
                  ."    <TD STYLE='font-size: 8pt;'>".$markupexample[$i][0]."</TD>\n"
                  ."    <TD>=</TD>\n"
                  ."    <TD>".bodyText($markupexample[$i][0], "(Insert-Username-Here)")."</TD></TR>\n";
   }
   $markupexamples = "<TABLE CELLPADDING=4 CELLSPACING=1 BORDER=0>\n"
                    ."<TR><TD COLSPAN=2 CLASS='BoardRowHeading'>Markup</TD>\n"
                    ."    <TD CLASS='BoardRowHeading'>Output</TD></TR>\n"
                    .$markuprow
                    ."</TABLE>\n";
   
   // Show the smiley list as currently configured
   foreach ($configoptions[emoticons] as $key => $value)
   {
     $facerow .= "<TR VALIGN=BASELINE>\n"
                  ."    <TD STYLE='font-size: 8pt;'>".$value[code]." or [face_".$value[name]."]</TD>\n"
                  ."    <TD>=</TD>\n"
                  ."    <TD>".bodyText("[face_".$value[name]."]")."</TD></TR>\n";
   }
   $faceexamples = "<TABLE CELLPADDING=4 CELLSPACING=1 BORDER=0>\n"
                  ."<TR><TD COLSPAN=2 CLASS='BoardRowHeading'>Code</TD>\n"
                  ."    <TD CLASS='BoardRowHeading'>Output</TD></TR>\n"
                  .$facerow
                  ."</TABLE>\n";
   
   $output = "Note: More detailed help will be coming soon.\n"
            ."<P>\n"
            ."<B>Markup Codes</B>\n"
            ."<P>\n"
            ."DiscoBoard supports the following markup codes:\n"
            ."<P>\n"
            .$markupexamples
            ."<P>\n"
            ."You may also use the following codes to produce faces:\n"
            ."<P>\n"
            .$faceexamples;

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