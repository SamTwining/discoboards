<?
if (!$birthdayyear) { $birthdayyear = ""; }

if ($tosfield)
{
  $tosoutput = "
<TR><TD COLSPAN=3>
        <SPAN CLASS='InputSection'>Terms Of Service</SPAN><BR>
        <SPAN CLASS='PlainText'>By using this message board system, you agree
        to the following terms of service:</SPAN><BR>
        ".$tosfield."
        </TD></TR>
";
}
$userform = "
<TABLE WIDTH=80%>
<TR><TD COLSPAN=3>
        <SPAN CLASS='InputSection'>User Information</SPAN><BR>
        <SPAN CLASS='PlainText'>Select a display name for your account.<BR>
        (You can use letters, numbers, _, -, + and .)</SPAN><BR>
        </TD></TR>
<TR><TD WIDTH=25% ALIGN=RIGHT>Display Name</TD>
    <TD>".$mandatory."</TD>
    <TD WIDTH=75%>".inputText("displayname", $displayname, 15, 30)."</TD></TR>
<TR><TD COLSPAN=3>
        <SPAN CLASS='InputSection'>Personal Information</SPAN><BR>
        <SPAN CLASS='PlainText'>The information here is used to form the basis of 
        your bio.</SPAN><BR>
        </TD></TR>
<TR><TD WIDTH=25% ALIGN=RIGHT>First Name</TD>
    <TD>".$mandatory."</TD>
    <TD WIDTH=75%>".inputText("firstname", $firstname, 15, 30)."</TD></TR>
<TR><TD ALIGN=RIGHT>Last Name</TD>
    <TD>".$mandatory."</TD>
    <TD>".inputText("lastname", $lastname, 15, 30)."</TD></TR>
<TR><TD ALIGN=RIGHT>Email Address</TD>
    <TD>".$mandatory."</TD>
    <TD>".inputText("email", $email, 20, 50)."</TD></TR>
<TR><TD ALIGN=RIGHT>Country</TD>
    <TD>".$mandatory."</TD>
    <TD>".inputCountry("country", $country)."</TD></TR>
<TR><TD ALIGN=RIGHT>Birthday</TD>
    <TD>".$mandatory."</TD>
    <TD>".inputDMYtext("birthday", $birthdayday, $birthdaymonth, $birthdayyear)."</TD></TR>
<TR><TD ALIGN=RIGHT>Gender</TD>
    <TD>".$mandatory."</TD>
    <TD>".inputChoice("gender", "gender", $gender)."</TD></TR>
".$tosoutput."
</TABLE>
";
?>
