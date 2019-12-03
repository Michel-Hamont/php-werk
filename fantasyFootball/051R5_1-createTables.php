<?php
//de log in op de mySQL-server
include("051R5-connection.php");

// het aanmaken van de tabel users
$user = "CREATE TABLE users (
userID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(20) NOT NULL,
password VARCHAR(32) NOT NULL,
email VARCHAR(50) NOT NULL
)";

if (mysqli_query($conn, $user)) {
    echo "de tabel users is succesvol aangemaakt<br><br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// het aanmaken van de tabel teams
$teams = "CREATE TABLE teams (
teamID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
teamname VARCHAR(20) NOT NULL,
plaats VARCHAR(32) NOT NULL,
trainer VARCHAR(20) NOT NULL,
Gespeeld INT(2) NOT NULL,
Gewonnen INT(2) NOT NULL,
Gelijk INT(2) NOT NULL,
Verloren INT(2) NOT NULL,
Voor INT(2) NOT NULL,
Tegen INT(2) NOT NULL,
Doelsaldo INT(3) NOT NULL,
Punten INT(3) NOT NULL
)";

if (mysqli_query($conn, $teams)) {
    echo "de tabel teams is succesvol aangemaakt<br><br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// het aanmaken van de tabel competitie
$comp = "CREATE TABLE competitie (
gameID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
speeldatum DATE,
thuisteam INT(11) NOT NULL,
uitteam INT(11) NOT NULL,
scorethuis INT(6) NULL,
scoreuit INT(6) NULL
)";

if (mysqli_query($conn, $comp)) {
    echo "de tabel competitie is succesvol aangemaakt<br><br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
mysqli_close($conn);
?>