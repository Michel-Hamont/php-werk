
<html lang="nl">
<head>
	<meta charset="utf-8">
	<title>inzendopdracht051R7</title>
	<link rel="stylesheet" href="css/051R7.css">
</head>
<body>
	<header>
	<div class="box1">
		<h1>Blogfest</h1>
		<p>To blog or to read blogs, that is the question!</p>
	</div>
	<?php
	// we voegen de errorhandling toe
		include("051R7-errorhandling.php");
		set_error_handler("error_msg");
	// we starten de sessie	
	session_start();
		if ( isset( $_SESSION['login_user'] ) ) {
  // als we ingelogd zijn, dan kunnen we weer uitloggen
		print('<form class="box2" action="051R7-logout.php" method ="POST">
		<p id="header">log uit als gebruiker:</p>
		<input id="login" name="logout" type=submit value="log uit">
		</form>'); }
		  else {
//we geven de bezoeker de mogelijkheid om in te loggen of zich te registreren als gebruiker
	print('<form class="box2" action="051R7-user.php" method ="POST">
			<p id="header">meldt u aan als blogger:</p>
			<input id="login" name="submit" type=submit value="log in/registreer">
	</form>'); }
	?>
	</header>
	<div class="container">
		<div class="menu">
			<?php
			//include voor het menu
			include("051R7-menu.php");
			?>
		</div>
		<div class="rechts">
			<p id="welkomtekst">Je bevindt je nu op de startpagina van onze blog-site.<br>
			Via het menu aan de linkerkant kun je de blogs lezen van je favoriete blogger.<br>
			(Klik op de naam)<br>
			Ben je zelf blogger? log dan in via de knop bovenaan de site.<br>
			Ben je blogger maar nog niet aangemeld?<br> Via dezelfde knop krijg je de mogelijkheid je aan te melden als nieuwe blogger!<br>
			Als je ingelogd bent, kun je via het menu links naar je blogpagina om blogs te maken of bewerken.<br>
			Uiteraard kun je altijd de blogs van de andere bloggers lezen!<br>
			Veel plezier!</p>
			<img id="plaatje" src=afbeeldingen/blogfest.png>
		</div>
	</div>
</body>
</html>