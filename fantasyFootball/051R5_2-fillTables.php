<?php
//de log in op de mySQL-server
include("051R5-connection.php");

// we vullen de teams met hun informatie en vullen ook gelijk het competitieschema
$teamFill = "INSERT INTO teams (teamname, plaats, trainer, Gespeeld, Gewonnen, Gelijk, Verloren, Voor, Tegen, Doelsaldo, Punten)
VALUES ('Norwich City', 'Norwich(ENG)', 'Han Saplast', '0', '0', '0', '0', '0', '0', '0', '0');";
$teamFill .= "INSERT INTO teams (teamname, plaats, trainer, Gespeeld, Gewonnen, Gelijk, Verloren, Voor, Tegen, Doelsaldo, Punten)
VALUES ('FC Nantes', 'Nantes(FR)', 'Jenu Patient', '0', '0', '0', '0', '0', '0', '0', '0');";
$teamFill .= "INSERT INTO teams (teamname, plaats, trainer, Gespeeld, Gewonnen, Gelijk, Verloren, Voor, Tegen, Doelsaldo, Punten)
VALUES ('ADO Den Haag', 'Den Haag(NL)', 'Al Ibaba', '0', '0', '0', '0', '0', '0', '0', '0');";
$teamFill .= "INSERT INTO teams (teamname, plaats, trainer, Gespeeld, Gewonnen, Gelijk, Verloren, Voor, Tegen, Doelsaldo, Punten)
VALUES ('Australie', 'Canberra(AUS)', 'Frank Enstein', '0', '0', '0', '0', '0', '0', '0', '0');";
$teamFill .= "INSERT INTO teams (teamname, plaats, trainer, Gespeeld, Gewonnen, Gelijk, Verloren, Voor, Tegen, Doelsaldo, Punten)
VALUES ('Brazilie', 'Brasilia(BRA)', 'Mit Subishi', '0', '0', '0', '0', '0', '0', '0', '0');";
$teamFill .= "INSERT INTO teams (teamname, plaats, trainer, Gespeeld, Gewonnen, Gelijk, Verloren, Voor, Tegen, Doelsaldo, Punten)
VALUES ('Jamaica', 'Kingston(JAM)', 'Ana Rchie', '0', '0', '0', '0', '0', '0', '0', '0');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-05-25', '1', '2');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-05-25', '3', '4');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-05-25', '5', '6');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-05-28', '1', '3');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-05-28', '2', '5');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-05-28', '4', '6');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-01', '1', '4');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-01', '2', '6');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-01', '3', '5');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-05', '5', '1');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-05', '4', '2');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-05', '6', '3');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-12', '6', '1');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-12', '2', '3');";
$teamFill .= "INSERT INTO competitie (speeldatum, thuisteam, uitteam)
VALUES ('2019-06-12', '4', '5')";

// de melding goed of fout voor het vullen van de teams en de competitie
if (mysqli_multi_query($conn, $teamFill)) {
    echo "de teams en competitie zijn succesvol aangemaakt!<br><br>";
} else {
    echo "Error: ". $teamFill . "<br>" . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);
?>