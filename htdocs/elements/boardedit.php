<?
$boardform = "
<SPAN CLASS='InputSection'>Current Settings</SPAN><BR>
<TABLE>
<TR><TD CLASS='BoardColumn'>Board ID</TD>    <TD>".$boardid."</TD></TR>
<TR><TD CLASS='BoardColumn'>Name</TD>        <TD>".$boardname."</TD></TR>
<TR><TD CLASS='BoardColumn'>Description</TD> <TD>".$boarddescription."</TD></TR>
<TR><TD CLASS='BoardColumn'>Rank</TD>        <TD>".$boardrank."</TD></TR>
<TR><TD CLASS='BoardColumn'>Group</TD>       <TD>".inputDBCycle("", $boardgroupid, TABLE_GROUPS, "ID", "groupname", "show", "grouprank")."</TD></TR>
</TABLE>
<P>
<SPAN CLASS='InputSection'>Board Name</SPAN><BR>
".inputText("boardname", $boardname, 30)."<BR>
<SPAN CLASS='InputSection'>Board Description</SPAN><BR>
".inputText("boarddescription", $boarddescription, 30)."<BR>
<SPAN CLASS='InputSection'>Board Rank</SPAN><BR>
".inputText("boardrank", $boardrank, 3, 1)."<BR>
<SPAN CLASS='InputSection'>Group</SPAN><BR>
".inputDBCycle("boardgroupid", $boardgroupid, TABLE_GROUPS, "ID", "groupname", "edit", "grouprank")."
<P>";
?>
