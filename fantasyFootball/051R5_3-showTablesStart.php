<html lang="nl">
<head>
	<meta charset="utf-8">
	<title>inzendopdracht051R5</title>
	<link rel="stylesheet" href="css/051R5.css">
</head>
<body>
	<header>
		<form action="051R5-user.php" method ="POST">
<!-- we geven de bezoeker de mogelijkheid om in te loggen of zich te registreren als gebruiker -->
			<p id="header">meldt u aan als gebruiker:</p>
			<input id="login" name="submit" type=submit value="log in/registreer">
		</form>
	</header>
	<h1>Fantasy-league Yellow-Greens</h1>
	<p>Welkom op de site van de geel-groenen</p>
<?php
//includes voor de connectie en de gebruikte functies op de 'hoofd'pagina
include("051R5-connection.php");
include("051R5-Functions.php");

// we roepen de functie aan om de competitiestand te laten zien (functie vanaf regel 46 in 051R5-Functions.php)
print "<h2>De competitiestand:<br>";
display_db_table2("teams", $conn);
print "<br><br>";

//we roepen de functie aan om het wedstrijdschema te laten zien (functie vanaf regel 2 in 051R5-Functions.php)
print "<h2>Het wedstrijdschema:<br>";
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