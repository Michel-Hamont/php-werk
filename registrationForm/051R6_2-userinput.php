<?php
//de log in op de mySQL-server
include("051R6-connection.php");

// we voegen de errorhandling toe
include("051R6-errorhandling.php");
set_error_handler("error_msg");

//aanmeldingen moeten aan voorwaarden voldoen
$message ="";

// de functie die de voorwaarden van de email invoer bepaalt
function checkMailFormat($email) {
if (preg_match('/[a-z0-9]{2,}@[a-z]{2,}\.[a-z]{2,}$/i', $email)) {
    return TRUE;
  }
  else return FALSE;
}

// we creëren voorwaarden voor invoer door het nieuwe lid
if (isset($_POST['submit']) && $_POST['submit'] == 'Registreer') {
 // het aanroepen van de functie met het e-mailformat
 $pattern = checkMailFormat($_POST['email']);
if (!isset($_POST['voornaam']) || $_POST['voornaam'] == "" || strlen($_POST['voornaam']) > 20) {
$message .= '<P>Vul uw voornaam in a.u.b. (maximaal 20 karakters)</P>';
}
if (!isset($_POST['anaam']) || $_POST['anaam'] == "" || strlen($_POST['anaam']) > 30)
  {
    $message .= '<p>vul uw achternaam in (max 30 karakters)</p>';
  }

if (!isset($_POST['email']) || $_POST['email'] == "" || $pattern == FALSE )
  {
    $message .= '<p>vul een emailadres in (het format moet tekst@tekst.nl zijn)</p>';
  } 
if (!isset($_POST['sport']) || $_POST['sport'] == "")
  {
    $message .= '<p>kies a.u.b. een sport die u wilt beoefenen</p>';
  }
 if (!isset($_POST['ges']) || $_POST['ges'] == "")
  {
    $message .= '<p>geef a.u.b. uw geslacht in</p>';
  }
 // we zetten de door de gebruiker in europese stijl ingegeven datum om naar een datum die in mySQL kan worden ingeschreven
$olddate2 = $_POST['datum'];
$datum = date('Y-m-d', strtotime($olddate2));
// en we zorgen er voor dat de gekozen datum om te starten niet in het verleden kan liggen
 if ($datum < date('Y-m-d'))
  {
    $message .= '<p>voer a.u.b een datum in de toekomst in voor wanneer u wilt starten met sporten</p>';
  }

// we zetten de door de gebruiker in europese stijl ingegeven datum om naar een datum die in mySQL kan worden ingeschreven
$olddate = $_POST['geb'];
$geb = date('Y-m-d', strtotime($olddate));

//je moet 18 zijn om bij de sportvereniging te komen sporten!
if ($geb > date('Y-m-d', strtotime('-18 years')))
  {
    $message .= '<p>sorry maar u moet ouder dan 18 zijn om bij ons te sporten</p>';
  }
  echo $message;
if ($message =="") {

//als aan de voorwaarden voldaan is, verwerken we de invoer in de database
$vnaam = trim($_POST['voornaam']);
$tussen = addslashes($_POST['tussen']);
$anaam = trim($_POST['anaam']);
$straat = trim($_POST['straat']);
$hnr = trim($_POST['hnr']);
$pc = trim($_POST['pc']);
$woon = trim($_POST['woon']);
$olddate = $_POST['geb'];
$geb = date('Y-m-d', strtotime($olddate));
$email = $_POST['email'];
$ges = $_POST['ges'];
$sport = $_POST['sport'];
$olddate2 = $_POST['datum'];
$datum = date('Y-m-d', strtotime($olddate2));
$dag = $_POST['dag'];

// we voegen de eerste batch met data in de tabel leden
$query = "INSERT INTO leden (Voornaam, Tussenvoegsel, Achternaam, Straat, Huisnummer, Postcode, Woonplaats, Email, Geboortedatum, Geslacht)
VALUES('$vnaam', '$tussen', '$anaam', '$straat', '$hnr', '$pc', '$woon', '$email', '$geb', '$ges')";
$result = mysqli_query($conn, $query);

// we halen het id van leden weer uit de database en voegen deze samen met de overige data in de tabel lidmaatschap
$query2 = "SELECT ID FROM leden
           WHERE Achternaam = '$anaam'
           AND Voornaam = '$vnaam'";
$result2 = mysqli_query($conn, $query2);
$idrow = mysqli_fetch_row($result2);
$id = $idrow[0];
$query3 = "INSERT INTO lidmaatschap (LedenID, Datumingang, Sportonderdeel, Lesdag)
VALUES('$id', '$datum', '$sport', '$dag')";
$result3 = mysqli_query($conn, $query3);

// als alles goed gaat, geven we een melding hiervan op het scherm en verzenden we de mails (als mailadres voor zowel nieuw lid als administrateur geldt het ingevoerde adres)
if (mysqli_affected_rows($conn) == 1) {
$message = '<P>uw gegevens zijn opgeslagen, check uw e-mail voor de bevestiging</P>';
$address = $email;
$subject = 'Uw aanmelding bij de sportvereniging';
$body = "Beste $vnaam,\r\n Uw aanmelding is ontvangen en in onze administratie opgenomen, we zien u graag op $dag $olddate2 verschijnen om bij ons $sport te komen beoefenen!";
$extraheader =  "From: Sportvereniging How (s)low can you go? <$email>\r\n";
$extraheader .= "Cc: $email\r\n";
$formsent = mail($address, $subject, $body, $extraheader) or set_error_handler("error_msg");
if ($formsent) {
echo $message;
} 
} else {
	print mysqli_error($conn);
	error_log(mysqli_error($conn));
}
}
}

// een if om de invoer van de gebruikers te bewaren als de invoer niet gelijk goed is
if (isset($_POST['voornaam'])) $vnaam = $_POST['voornaam'];
else $vnaam = "";
if (isset($_POST['tussen'])) $tussen = $_POST['tussen'];
else $tussen = "";
if (isset($_POST['anaam'])) $anaam = $_POST['anaam'];
else $anaam = "";
if (isset($_POST['straat'])) $straat = $_POST['straat'];
else $straat = "";
if (isset($_POST['hnr'])) $hnr = $_POST['hnr'];
else $hnr = "";
if (isset($_POST['pc'])) $pc = $_POST['pc'];
else $pc = "";
if (isset($_POST['woon'])) $woon = $_POST['woon'];
else $woon = "";
if (isset($_POST['email'])) $email = $_POST['email'];
else $email = "";
if (isset($_POST['geb'])) $olddate = $_POST['geb'];
else $olddate = "";
if (isset($_POST['datum'])) $olddate2 = $_POST['datum'];
else $olddate2 = "";

// de reset button zet alles weer op lege waarden
if (isset($_POST['reset']) && $_POST['reset'] == 'Reset het formulier') {
  $vnaam = ""; $tussen = ""; $anaam = ""; $straat = ""; $hnr = ""; $pc = ""; $woon = ""; $email = ""; $olddate = ""; $olddate2 = ""; }

// De invoermogelijkheid wordt in de browser getoond
$thisfile = "051R6_2-userinput.php";
$message = <<< MESSAGE
<P>Meldt u aan bij onze sportclub!</P>

<FORM METHOD="post" ACTION="$thisfile">
<INPUT TYPE="submit" id="reset" NAME="reset" VALUE="Reset het formulier"><br><br>
<label>Voornaam&#42;&#58; </label><INPUT TYPE="text" SIZE=40 NAME="voornaam" value="$vnaam" autofocus><BR><br>
<label>Tussenvoegsel&#58; </label><INPUT TYPE="text" SIZE=10 NAME="tussen" value="$tussen">
<label>Achternaam&#42;&#58; </label><INPUT TYPE="text" SIZE=30 NAME="anaam" value="$anaam"><BR><br>
<label>Straat&#58; </label><INPUT TYPE="text" SIZE=35 NAME="straat" value="$straat">
<label>Huisnummer&#58; </label><INPUT TYPE="text" SIZE=5 NAME="hnr" value="$hnr"><br><br>
<label>Postcode&#58; </label><INPUT TYPE="text" SIZE=6 NAME="pc" value="$pc">
<label>Woonplaats&#58; </label><INPUT TYPE="text" SIZE=34 NAME="woon" value="$woon"><br><br>
<label>Email&#42;&#58;</label> <INPUT TYPE="text" SIZE=40 NAME="email" value="$email"><BR><BR>
<label>Geboortedatum&#42;&#58;</label> <INPUT TYPE="date" SIZE=10 NAME="geb" value="$olddate" placeholder="dd-mm-jjjj">
<label>Geslacht&#42;&#58;</label>
        <INPUT TYPE="radio" name="ges" value="M">M
        <INPUT TYPE="radio" name="ges" value="V">V
<BR><BR>
<label>Voor welke sport wilt u zich inschrijven&#63;&#42;</label>
   <SELECT name="sport">
          <option value="" selected hidden disabled>Maak uw keuze</option>
          <option value="tennis">Tennis</option>
          <option value="voetbal">Voetbal</option>
          <option value="tafeltennis">Tafeltennis</option>
          <option value="biljart">Biljart</option>
   </SELECT><br><br>
<label>Welke dag wilt u komen sporten&#63;&#42;</label>
   <SELECT name="dag">
          <option value="" selected hidden disabled>Maak uw keuze</option>
          <option value="maandag">Maandag</option>
          <option value="dinsdag">Dinsdag</option>
          <option value="woensdag">Woensdag</option>
          <option value="donderdag">Donderdag</option>
          <option value="vrijdag">Vrijdag</option>
   </SELECT><br><br>
 <label>Wanneer wilt u starten&#63;&#42;</label> <INPUT TYPE="date" SIZE=10 NAME="datum" value="$olddate2" placeholder="dd-mm-jjjj">

<p id='small'>&#42;&#61; verplicht in te vullen</p>
<INPUT TYPE="submit" NAME="submit" VALUE="Registreer">
</FORM>
MESSAGE;
    
?>
<HTML>
<HEAD>
<title>inzendopdracht 051R6</title>
<STYLE TYPE="text/css">
BODY, P {color: black; font-family: verdana;
font-size: 10pt; }
H1 {color: black; font-family: arial; font-size: 12pt; }
.links { background: url(afbeeldingen/slow.jpg) no-repeat center; background-size: contain; }
</STYLE>
</HEAD>
<BODY>
<!-- de tabel voor gebruikers invoer -->
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD class="links" BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=17%>
</TD>
<TD BGCOLOR="#4da5f2" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<H1>Welkom bij sportvereniging&#58; <em>How &#40;s&#41;low can you go&#63;</em></H1>
<?php echo $message; ?>
</TD>
</TR>
</TABLE>


</BODY>
</HTML>
