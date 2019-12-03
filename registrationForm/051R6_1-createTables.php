<?php
//de log in op de mySQL-server
include("051R6-connection.php");

// het aanmaken van de tabel leden
$leden = "CREATE TABLE leden (
ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
Voornaam VARCHAR(20) NOT NULL,
Tussenvoegsel VARCHAR(15) NULL,
Achternaam VARCHAR(30) NOT NULL,
Straat VARCHAR(50) NULL,
Huisnummer VARCHAR(10) NULL,
Postcode VARCHAR(6) NULL,
Woonplaats VARCHAR(30) NULL,
Email VARCHAR(50) NULL,
Geboortedatum DATE,
Geslacht VARCHAR(1) NULL
)";

if (mysqli_query($conn, $leden)) {
    echo "de tabel leden is succesvol aangemaakt<br><br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// het aanmaken van de tabel lidmaatschap
$lid = "CREATE TABLE lidmaatschap (
ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
LedenID INT(11) NOT NULL,
Datumingang DATE NOT NULL,
Datumeinde DATE NULL,
Sportonderdeel VARCHAR(30) NOT NULL,
Lesdag VARCHAR(15) NULL
)";

if (mysqli_query($conn, $lid)) {
    echo "de tabel lidmaatschap is succesvol aangemaakt<br><br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
mysqli_close($conn);
?>