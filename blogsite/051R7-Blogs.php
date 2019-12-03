
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
		session_start();
		if ( isset( $_SESSION['login_user'] ) ) {
  // als we ingelogd zijn, dan kunnen we weer uitloggen
		print('<form class="box2" action="051R7-logout.php" method ="POST">
		<p id="header">log uit als gebruiker:</p>
		<input id="login" name="logout" type=submit value="log uit">
		</form>'); }
		  else {
//we geven de bezoeker de mogelijkheid om in te loggen of zich te registreren als gebruiker -->
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
  <?php
	//we halen de meegestuurde id op vanaf de link, en zorgen dat we enkel de blogs van deze blogger tonen
  $user = $_GET['id'];
  display_db_table2($conn, TRUE, "BORDER=2", "select b.Username as Blogger, a.Onderwerp , a.Datum, a.Tekst as Blog from blogs a join bloggers b on a.BloggerID = b.BloggerID WHERE a.BloggerID='$user' ORDER BY a.Datum DESC");
  ?>
  	</div>
</div>
</body>
</html>