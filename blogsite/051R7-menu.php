<?php
//includes voor de connectie en de gebruikte functies op de 'hoofd'pagina
include("051R7-connection.php");
include("051R7-Functions.php");

// we roepen de functie aan om het overzicht met de bloggers te laten zien
print "<h2>onze bloggers:<br>";
display_db_table("bloggers", $conn);
print "<br><br>";


?>