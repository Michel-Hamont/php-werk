<?php
// de eerste login op MySQL om een database aan te maken ()
$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Create database
$sql = "CREATE DATABASE dbLOI";
if (mysqli_query($conn, $sql)) {
    echo "Database dbLOI is succesvol aangemaakt<br><br>";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}
mysqli_close($conn);
//de log in op de mySQL-server deel 2, nu met database
include("051R7-connection.php");

// het aanmaken van de tabel blogs
$blogs = "CREATE TABLE blogs (
ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
BloggerID INT(11) NOT NULL,
Onderwerp VARCHAR(50) NOT NULL,
Datum DATETIME(0),
Tekst TEXT(265000) NULL
)";

if (mysqli_query($conn, $blogs)) {
    echo "de tabel blogs is succesvol aangemaakt<br><br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// het aanmaken van de tabel bloggers
$bloggers = "CREATE TABLE bloggers (
BloggerID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
Username VARCHAR(30) NOT NULL,
Password VARCHAR(32) NOT NULL,
Email VARCHAR (50) NOT NULL
)";

if (mysqli_query($conn, $bloggers)) {
    echo "de tabel bloggers is succesvol aangemaakt<br><br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
//we maken gelijk de admin-user aan - voor de controle kan dan het wachtwoord hieronder gebruikt worden
$passw = md5('superuser');
$bloggerFill = "INSERT INTO bloggers (Username, Password, Email)
VALUES ('admin', '$passw', 'my@email.com');";
$result = mysqli_query($conn, $bloggerFill);
if (mysqli_affected_rows($conn) == 1) {
$message = '<P>de gegevens zijn opgeslagen, er kan worden ingelogd als admin (gebruikersnaam = my@email.com)</P>';
echo $message;
} else {
	print mysqli_error($conn);
	error_log(mysqli_error($conn));
$message = '<P>het is niet gelukt om de admin-gebruiker aan te maken</P>';
}
mysqli_close($conn);
?>