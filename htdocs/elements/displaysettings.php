<?
$displaysettingsform = "
<SPAN CLASS='InputSection'>Posts Per Page</SPAN><BR>
Controls the maximum number of posts you will see on a page at a time when 
viewing a thread.<BR>
".inputChoice("perpage", "perpageposts", $userinfo[perpageposts])."
<P>
<SPAN CLASS='InputSection'>Threads Per Page</SPAN><BR>
Controls the number of threads you will see on a page at a time when viewing
the threads posted on a board.<BR>
".inputChoice("perpage", "perpagethreads", $userinfo[perpagethreads])."
<P>
<SPAN CLASS='InputSection'>Timezone Settings</SPAN><BR>
The current system time is <I>".Date("d M Y H:i:s")."</I><BR>
Your configuration shows the current time as <I>".dateNeat(Date("U"), "datetime")."</I><BR>
Select the number of hours offset required to change this to your local time.<BR>
<I>Default setting is currently <U>".$TimeZoneChange."</U></I><BR>
".inputTimeZoneSelect("timezone", $userinfo[timezone])."
";
?>