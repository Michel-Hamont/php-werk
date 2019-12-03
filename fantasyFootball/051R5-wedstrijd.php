<?php
//includes voor de connectie en de gebruikte functies op de pagina
include("051R5-connection.php");
include("051R5-Functions.php");
//we zorgen dat er een sessie loopt op deze pagina
session_start();

if ( isset( $_SESSION['login_user'] ) ) {
    // we pakken user data uit de database
    // en dan krijgen ze toegang tot de secure-pagina's
} else {
   // als niet ingelogd, dan kom je op de standaard start-pagina, met inlog mogelijkheid
    header("Location: 051R5_3-showTablesStart.php");
}
// we laten ook hier het competitieschema zien, met gameID om de scores te kunnen vullen.
display_db_table($conn, TRUE, "BORDER=2", "select c.gameID, c.speeldatum, t.teamname as Thuisteam, t2.teamname as Uitteam, c.scorethuis as 'Score Thuisteam', c.scoreuit as 'Score Uitteam' from competitie c join teams t on c.thuisteam = t.teamID join teams t2 on c.uitteam = t2.teamID");
$message ="";

// we geven de gebruiker de mogelijkheid om een score aan een wedstrijd toe te voegen.
if (isset($_POST["submit"]) && $_POST["submit"] == "Submit") {
	if (!isset($_POST['gameID']) || $_POST['gameID'] == "")
  {
    $message .= '<p>Hebt u het juiste gameID ingevuld?</p>';
  }

  if (!isset($_POST['scorethuis']) || $_POST['scorethuis'] == "")
  {
    $message .= '<p>Hebt u een geldige score voor het thuisspelende team ingevuld?</p>';
  }
  if (!isset($_POST['scoreuit']) || $_POST['scoreuit'] == "")
  {
    $message .= '<p>Hebt u een geldige score voor het uitspelende team ingevuld?</p>';
  }
 
	if ($message == "")
 {
$gameid = 	trim($_POST['gameID']);
$thuisscore = trim($_POST['scorethuis']);
$uitscore = trim($_POST['scoreuit']);
$query = "UPDATE competitie
		SET scorethuis = $thuisscore , scoreuit = $uitscore
		WHERE gameID = $gameid";

$result = mysqli_query($conn, $query);
// als de invoer goed gaat verversen we de pagina om de score gelijk te verwerken in het op deze pagina getoonde wedstrijdschema
if (mysqli_affected_rows($conn) == 1) {
$message = header("Location: 051R5-wedstrijd.php");
// als de invoer niet goed gaat, dan zorgen we voor een foutmelding
	} else {
  print mysqli_error($conn);
		error_log(mysqli_error($conn));
		$message = "<P>Er is een onbekende fout opgetreden (waarschijnlijk heb je de score geprobeerd te overschrijven met identieke waarden?)</P>";
	}

	}

// we gaan aan de gang met het vullen van de stand

// allereerst maken we de stand helemaal leeg om de mogelijkheid te kunnen bieden dat ingevoerde scores overschreven worden
$query8 = "UPDATE teams
		SET Punten = 0, Gespeeld = 0, Gewonnen = 0, Gelijk = 0, Verloren = 0, Voor = 0, Tegen = 0, Doelsaldo = 0";
 // we selecteren met een aantal queries data vanuit de competitie tabel die we nodig hebben om de stand te kunnen genereren
$query2 = "SELECT thuisteam FROM competitie;";
$query3 = "SELECT scorethuis FROM competitie;";
$query4 = "SELECT uitteam FROM competitie;";
$query5 = "SELECT scoreuit FROM competitie;";
$result2 = mysqli_query($conn, $query2);
$result3 = mysqli_query($conn, $query3);
$result4 = mysqli_query($conn, $query4);
$result5 = mysqli_query($conn, $query5);
$result8 = mysqli_query($conn, $query8);
// per opgehaalde kolom maken we een array met de data
for ($set = array (); $row = $result2->fetch_assoc(); $set[] = $row['thuisteam']);
for ($set2 = array (); $row = $result3->fetch_assoc(); $set2[] = $row['scorethuis']);
for ($set3 = array (); $row = $result4->fetch_assoc(); $set3[] = $row['uitteam']);
for ($set4 = array (); $row = $result5->fetch_assoc(); $set4[] = $row['scoreuit']);
// de opgehaalde data gaan we dmv een for-loop verdelen over de juiste teams
for ($i = 0; $i <15; $i++) {
		$thuisteam = $set[$i];
		$uitteam = $set3[$i];
		$thuis = $set2[$i];
		$uit = $set4[$i];
	// de if-serie hieronder bepaalt het punten aantal voor de teams die aan een wedstrijd deelnemen afhankelijk van gewonnen, verloren of gelijk.
	if ($thuis > $uit) { // het thuisteam wint
		$query6 = "UPDATE teams
		SET Punten = Punten +3, Gespeeld = Gespeeld +1, Gewonnen = Gewonnen +1, Verloren = Verloren +0, Voor = Voor +'$thuis', Tegen = Tegen +'$uit', Doelsaldo = Doelsaldo +('$thuis' - '$uit')
		WHERE teamID = $thuisteam";
		$query7 = "UPDATE teams
	 SET Punten = Punten +0, Gespeeld = Gespeeld +1, Gewonnen = Gewonnen +0, Verloren = Verloren +1, Voor = Voor +'$uit', Tegen = Tegen +'$thuis', Doelsaldo = Doelsaldo +('$uit' - '$thuis')
		WHERE teamID = $uitteam";
	}
	elseif ($thuis == $uit) { // een gelijkspel
 // een extra if om er voor te zorgen dat als een wedstijd nog niet gespeeld is, de data niet gezien wordt als een gelijkspel
	  if ($thuis == $uit && $thuis !== NULL) {
	$query6 = "UPDATE teams
	 SET Punten = Punten +1, Gespeeld = Gespeeld +1, Gelijk = Gelijk +1, Voor = Voor +'$thuis', Tegen = Tegen +'$uit', Doelsaldo = Doelsaldo +('$thuis' - '$uit')
		WHERE teamID = $thuisteam";
 $query7 = "UPDATE teams
	 SET Punten = Punten +1, Gespeeld = Gespeeld +1, Gelijk = Gelijk +1, Voor = Voor +'$uit', Tegen = Tegen +'$thuis', Doelsaldo = Doelsaldo +('$uit' - '$thuis')
		WHERE teamID = $uitteam";
	}
		else {
		$query6 = "UPDATE teams
	 SET Punten = Punten +0, Gespeeld = Gespeeld +0, Gelijk = Gelijk +0, Voor = Voor +0, Tegen = Tegen +0, Doelsaldo = Doelsaldo +0
		WHERE teamID = $thuisteam";
		$query7 = "UPDATE teams
	 SET Punten = Punten +0, Gespeeld = Gespeeld +0, Gelijk = Gelijk +0, Voor = Voor +0, Tegen = Tegen +0, Doelsaldo = Doelsaldo +0
		WHERE teamID = $uitteam"; }
	}
	elseif ($thuis < $uit) { // het uitteam wint
	$query6 = "UPDATE teams
		SET Punten = Punten +3, Gespeeld = Gespeeld +1, Gewonnen = Gewonnen +1, Verloren = Verloren +0, Voor = Voor +'$uit', Tegen = Tegen +'$thuis', Doelsaldo = Doelsaldo +('$uit' - '$thuis')
		WHERE teamID = $uitteam";
		$query7 = "UPDATE teams
	 SET Punten = Punten +0, Gespeeld = Gespeeld +1, Gewonnen = Gewonnen +0, Verloren = Verloren +1, Voor = Voor +'$thuis', Tegen = Tegen +'$uit', Doelsaldo = Doelsaldo +('$thuis' - '$uit')
		WHERE teamID = $thuisteam";
}
$result6 = mysqli_query($conn, $query6);
$result7 = mysqli_query($conn, $query7);
}

}

 // Toon het formulier op de pagina om de scores te kunnen vullen
		
		$thisfile = "051R5-wedstrijd.php";
		$message .= 
		"<P>Uitslagen</P>
		<FORM METHOD='post' ACTION='$thisfile'>
		WedstrijdID: <INPUT TYPE= 'number' NAME= 'gameID'><BR><BR>
		Thuisscore: <INPUT TYPE='number' SIZE=25 NAME='scorethuis'><BR><BR>
		Uitscore: <INPUT TYPE='number' SIZE=25 NAME='scoreuit'><BR><BR>
		<INPUT TYPE= 'submit' NAME='submit' VALUE='Submit'>
		</FORM>";
 // een extra knop om terug te kunnen naar de pagina met de stand (zodat je meerdere scores kunt wijzigen voor je terug gaat naar de stand)
	$message .= "<FORM METHOD='post' ACTION='051R5-showTablesSecure.php'>
															<INPUT TYPE= 'submit' NAME='submit' VALUE='Terug naar Hoofdmenu'>
														</FORM>";
//en tot slot de html- om de invoer van de scores neer te zetten op de pagina
?>
<html lang="nl">
<head>
<meta charset="utf-8">
	<title>score formulier</title>
 <style>
 BODY, P {color: black; font-family: verdana; font-size: 10pt;}
 H1 {color: black; font-family: arial; font-size: 12pt;} </style>
</head>
<BODY> <TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD BGCOLOR=”#F0F8FF” ALIGN=CENTER VALIGN=TOP WIDTH=17%> </TD>
<TD BGCOLOR=”#FFFFFF” ALIGN=LEFT VALIGN=TOP WIDTH=83%> <H1>Uitslagen invoeren</H1> <?php echo $message; ?> </TD>
</TR>
</TABLE>
</BODY>
</HTML>


