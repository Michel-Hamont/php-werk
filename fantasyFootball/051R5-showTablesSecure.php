<html lang="nl">
<head>
	<meta charset="utf-8">
	<title>inzendopdracht051R5</title>
	<link rel="stylesheet" href="css/051R5.css">
</head>
<body>
	<header>
 <!-- we geven de ingelogde gebruiker de mogelijkheid om uit te loggen -->
		<form action="051R5-logout.php" method ="POST">
		<p id="header">log uit als gebruiker:</p>
		<input id="login" name="logout" type=submit value="log uit">
		</form>
	</header>
	<h1>Fantasy-league Yellow-Greens</h1>
	<p>Welkom op de site van de geel-groenen</p>
<?php
//includes voor de connectie en de gebruikte functies op de 'hoofd'pagina
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
// we roepen de functie aan om de competitiestand te laten zien (functie vanaf regel 46 in 051R5-Functions.php)
print "<h2>De competitiestand:<br>";
display_db_table2("teams", $conn);
print "<br>";

//we roepen de functie aan om het wedstrijdschema te laten zien (functie vanaf regel 2 in 051R5-Functions.php)
print "<h2>Het wedstrijdschema:<br>";
print "<p id='link'>klik op de link bij de speeldata hieronder om de uitslagen van de wedstrijden te kunnen invoeren/aanpassen</p><br>";
?>
<div class="box"> 
	<div id="schema">
	<?php
	display_db_table($conn, TRUE, "BORDER=2", "select c.speeldatum, t.teamname as Thuisteam, t2.teamname as Uitteam, c.scorethuis as 'Score Thuisteam', c.scoreuit as 'Score Uitteam' from competitie c join teams t on c.thuisteam = t.teamID join teams t2 on c.uitteam = t2.teamID");
	?>
	</div>
	<figure>
		<img src="afbeeldingen/voetballer.png" id="plaatje">
	</figure>
</div>
</body>
</html>