<?
$profiledisplay = "
<TABLE WIDTH=100% CELLPADDING=3 CELLSPACING=1 BORDER=0>
<TR><TD ALIGN=RIGHT WIDTH=20% CLASS='BoardColumn'>ID:&nbsp;</TD>
    <TD WIDTH=80% CLASS='BoardRowBody'>".$userinfo[ID]."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Username:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".usernameDisplay($userinfo[ID], "", "showstar")."&nbsp;".$classnamedisplay."</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Class:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".applyOnlyTextEffects($userinfo[classname])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Real Name:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".applyOnlyTextEffects(trim($userinfo[fname]." ".$userinfo[sname]))."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Gender:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".inputChoice("gender", "", $userinfo[gender], "show")."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Age:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".calculateAge($userinfo[dateofbirth])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Country:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".inputCountry("country", $userinfo[country], "show")."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Company:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".applyOnlyTextEffects($userinfo[company])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Job Title:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".applyOnlyTextEffects($userinfo[jobtitle])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Email:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".applyOnlyTextEffects($userinfo[contactemail])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>ICQ UIN:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".$icqonline.applyOnlyTextEffects($userinfo[contacticq])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>MSN ID:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".$msnonline.$msnpre.applyOnlyTextEffects($userinfo[contactmsn]).$msnpost."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Yahoo ID:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".$yahooonline.applyOnlyTextEffects($userinfo[contactyahoo])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>AIM ID:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".$aimonline.applyOnlyTextEffects($userinfo[contactaim])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Picture:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".makeLink($userinfo[picurl], $userinfo[picurl], "")."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Website:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".makeLink($userinfo[wwwurl], $userinfo[wwwurl], "")."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Posts:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".number_format($userinfo[postcount])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Last Login:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".dateNeat($userinfo[lastlogin])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Last Post:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".getLastPost($userinfo[ID])."&nbsp;".makeLink("messages.php?userid=".$user, "(View History)")."</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Profile Created:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".dateNeat($userinfo[created])."&nbsp;</TD></TR>
<TR><TD ALIGN=RIGHT CLASS='BoardColumn'>Profile Updated:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".dateNeat($userinfo[updated])."&nbsp;</TD></TR>
<TR VALIGN=BASELINE>
    <TD ALIGN=RIGHT CLASS='BoardColumn'>Watched Users:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".$watcheduserlist."</TD></TR>
<TR VALIGN=BASELINE>
    <TD ALIGN=RIGHT CLASS='BoardColumn'>Watched By:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".$watchingusersoutput."</TD></TR>
<TR VALIGN=BASELINE>
    <TD ALIGN=RIGHT CLASS='BoardColumn'>Bio:&nbsp;</TD>
    <TD CLASS='BoardRowBody'>".bodyText($userinfo[bio])."&nbsp;</TD></TR>
</TABLE>
";
?>