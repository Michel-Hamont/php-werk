<?php
include("051R7-connection.php");
session_start();

if ( isset( $_SESSION['login_user'] ) ) {
    // we pakken user data uit de database
    // en dan krijgen ze toegang tot de secure-pagina's
} else {
   // als niet ingelogd, dan kom je op de standaard start-pagina, met inlog mogelijkheid
    header("Location: index.php");
}
// we voegen de errorhandling toe
include("051R7-errorhandling.php");
set_error_handler("error_msg");

//omdat we een tijd toevoegen zetten we de tijdzone voor de zekerheid op de onze
date_default_timezone_set('CET');
$blogid= "";
$onderwerp="";
$blog="";
$message ="";
$message2 ="";
$user = $_GET['id'];
// we creëren voorwaarden voor invoer van een nieuwe blog door de blogger
if (isset($_POST['submit']) && $_POST['submit'] == 'Inzenden') {
	
  // alleen als het een nieuwe blog betreft slaan we 'm als nieuw op
  if ($_POST['blogid2']=="") {
	if (!isset($_POST['onderwerp']) || $_POST['onderwerp'] == "")
  {
    $message .= '<p>Vul een onderwerp in</p>';
    $onderwerp=$_POST['onderwerp'];
		$blog= $_POST['blog'];
  }
	
if (!isset($_POST['blog']) || $_POST['blog'] == "")
  {
    $message .= '<p>Sorry, maar er moet iets in je blog komen te staan</p>';
    $onderwerp=$_POST['onderwerp'];
		$blog= $_POST['blog'];
  }
  echo $message;
	// als het goed gaat dan slaan we de blog op
if ($message =="") {
$blog = addslashes($_POST['blog']);
$datum = date("Y-m-d H:i");
$onderwerp = trim(addslashes(($_POST['onderwerp'])));
$query2 = "INSERT INTO blogs (BloggerID, Datum, Onderwerp, Tekst) VALUES('$user','$datum', '$onderwerp', '$blog')";
$result2 = mysqli_query($conn, $query2);

if (mysqli_affected_rows($conn) == 1) {
	$message = '<P>Je blog is opgeslagen</P>';
	echo $message;
	$onderwerp = "";
  $blog= "";
	}
else {
  print mysqli_error($conn);
  error_log(mysqli_error($conn));
	$message = '<P>er ging helaas iets mis bij de invoer, probeert u het aub nog een keer.</P>';
	}
}
}
// als het geen nieuwe blog betreft dan halen we de gekozen blog op en kan deze geupdate worden
else {
  	if (!isset($_POST['onderwerp']) || $_POST['onderwerp'] == "")
  {
    $message .= '<p>Vul een onderwerp in</p>';
    $onderwerp=$_POST['onderwerp'];
		$blog= $_POST['blog'];
  }
	
if (!isset($_POST['blog']) || $_POST['blog'] == "")
  {
    $message .= '<p>Sorry, maar er moet iets in je blog komen te staan</p>';
    $onderwerp=$_POST['onderwerp'];
		$blog= $_POST['blog'];
  }
  echo $message;
	// hier vindt de update plaats
if ($message =="") {
$blog = addslashes($_POST['blog']);
$datum = date("Y-m-d H:i");
$onderwerp = trim(addslashes(($_POST['onderwerp'])));
$blogid2 = $_POST['blogid2'];
$query2 = "UPDATE blogs SET Datum='$datum', Onderwerp='$onderwerp', Tekst='$blog' WHERE ID='$blogid2'";
$result2 = mysqli_query($conn, $query2);

if (mysqli_affected_rows($conn) == 1) {
	$message = '<P>Je blog is opgeslagen</P>';
	echo $message;
	$onderwerp = "";
  $blog="";
  $blogid="";
	}
else {
  print mysqli_error($conn);
  error_log(mysqli_error($conn));
	$message = '<P>er ging helaas iets mis bij de invoer, probeert u het aub nog een keer.</P>';
	}

	
}
}
}
// het ophalen van de bestaande blog. je mag alleen je eigen blogs ophalen (de admin mag alles ophalen, maar alleen in de pagina van de betreffende blogger)
if (isset($_POST['aanpassen']) && $_POST['aanpassen'] == 'Haal bestaande blog op') {
  if (!isset($_POST['blogid']) || $_POST['blogid'] == "")
  {
    $message .= '<p>Vul een bestaande blogID in</p>';
  }
  if ($message =="") {
$blognr = $_POST['blogid'];
$query3 = "Select ID, BloggerID, Onderwerp, Tekst from blogs
              WHERE ID = '$blognr' AND BloggerID = '$user'";
$result3 = mysqli_query($conn, $query3);
$row = mysqli_fetch_row($result3);
$blogid=$row[0];
$onderwerp=$row[2];
$blog=$row[3];
  }
}
// de reset button zet alles weer op lege waarden
if (isset($_POST['reset']) && $_POST['reset'] == 'Reset je invoer') {
  $onderwerp = ""; $blog = ""; }
// we voegen een delete mogelijkheid toe, je moet eerst de betreffende blog ophalen om 'm te kunnen verwijderen, dit als extra safeguard ingebouwd
  if (isset($_POST['delete']) && $_POST['delete'] == 'Delete opgehaalde blog') {
  if (!isset($_POST['blogid2']) || $_POST['blogid2'] == "")
  {
    $message .= '<p>Om te kunnen verwijderen moet je eerst de blog ophalen met de ophaal knop</p>';
  }
  echo $message;
  if ($message =="") {
    $blognr = $_POST['blogid2'];
  $query4 = "DELETE from blogs
              WHERE ID = '$blognr'";
  $result4 = mysqli_query($conn, $query4);
  }
  }
// De invoermogelijkheid wordt in de browser getoond
$thisfile = "051R7-BlogsSecure.php?id=$user";
$message = <<< MESSAGE
<P>schrijf een blog of pas een bestaande blog aan</P>
<FORM METHOD="post" ACTION="$thisfile">
<label>BlogID:&#42; </label><INPUT TYPE="text" SIZE=4 NAME="blogid">
<INPUT TYPE="submit" NAME="aanpassen" VALUE="Haal bestaande blog op"><br>
<p><small>&#42;&#58; alleen vullen als je een bestaande blog wilt ophalen!</small></p><br>
<INPUT TYPE="submit" NAME="reset" VALUE="Reset je invoer"><INPUT TYPE="submit" NAME="delete" VALUE="Delete opgehaalde blog"><br><br><br>
<INPUT TYPE="text" SIZE=4 NAME="blogid2" value="$blogid" hidden>
<label>Onderwerp:</label> <INPUT TYPE="text" SIZE=32 NAME="onderwerp" value="$onderwerp"><br><br>
<label>Je tekst:</label><br><TEXTAREA NAME="blog" ID="blog" style="width: 400px; height: 200px;">$blog</TEXTAREA><br><br>

<BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Inzenden">
</FORM>
MESSAGE;
?>
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
  display_db_table2($conn, TRUE, "BORDER=2", "select a.ID as BlogID, a.Onderwerp , a.Datum, a.Tekst as Blog from blogs a join bloggers b on a.BloggerID = b.BloggerID WHERE a.BloggerID='$user' ORDER BY a.Datum DESC");
	?>
	<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
    <TR>
    <TD ALIGN=LEFT VALIGN=TOP WIDTH=83%>
    <H1>Voeg je blog toe</H1>
    <?php echo $message; ?>
    </TD>
    </TR>
    </TABLE>
  	</div>
</div>
</body>
</html>