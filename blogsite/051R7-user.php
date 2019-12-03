<?php
//de log in op de mySQL-server
include("051R7-connection.php");
// we voegen de errorhandling toe
include("051R7-errorhandling.php");
set_error_handler("error_msg");
$message ="";
$email = "";
$email2 = "";
$naam2 = "";
 // we starten een sessie en laten een gebruiker inloggen

    if (isset($_POST['submit2'])) {     
    session_start();
    $email=$_POST['email'];
    $wachtwoord=md5($_POST['password']);
    $_SESSION['login_user']=$wachtwoord; 
    $query = "SELECT Email FROM bloggers WHERE Email='$email' and Password='$wachtwoord'";
    $result=mysqli_query($conn, $query);
     if (mysqli_num_rows($result) != 0)
    {
    header("Location: index.php");
   
      }
      else
      {
       $email=$_POST['email'];
       echo ("U hebt een incorrecte Username of Password ingegeven!");
    }
    }
// als een bezoeker nog geen gebruiker is dan kan hij zich aanmelden, maar de aanmelding moet wel aan voorwaarden voldoen

// de functie die de voorwaarden van de email invoer bepaalt
function checkMailFormat($email) {
if (preg_match('/[a-z0-9]{2,}@[a-z]{2,}\.[a-z]{2,}$/i', $email)) {
    return TRUE;
  }
  else return FALSE;
}

// we creëren voorwaarden voor nieuwe invoer door de registrerende gebruiker
if (isset($_POST['submit']) && $_POST['submit'] == 'Registreer') {
 $pattern = checkMailFormat($_POST['email']);
if (!isset($_POST['naam']) || $_POST['naam'] == "" || strlen($_POST['naam']) < 3) {
$message .= '<P>Vul een username in a.u.b. (minimaal 3 karakters)</P>';
// we zorgen dat de invoer blijft staan om te verbeteren
$naam2 = $_POST['naam'];
$email2 = $_POST['email'];
}
if (!isset($_POST['email']) || $_POST['email'] == "" || $pattern == FALSE )
  {
    $message .= '<p>vul een emailadres in (het format moet tekst@tekst.tekst zijn)</p>';
    // we zorgen dat de invoer blijft staan om te verbeteren
    $email2 = $_POST['email'];
    $naam2 = $_POST['naam'];
  }
  echo $message;
if ($message =="") {
 $naam2 = "";
 $email2="";
//als aan de voorwaarden voldaan is, verwerken we de invoer in de database
$naam = trim($_POST['naam']);
$email = $_POST['email'];

function random_char($string) {
$length = strlen($string);
$position = mt_rand(0, $length - 1);
return($string[$position]);
}

function random_string ($password_string, $length) {
$return_string = "";
for ($x = 0; $x < $length; $x++)
  $return_string .= random_char($password_string);
  return($return_string);
}
$klein = "abcdefghijklmnopqrstuvwxyz";
$groot = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$cijfers = "1234567690";
mt_srand((double)microtime() * 1000000);
$random_string = random_string($groot, 1);
$random_string .= random_string($cijfers, 1);
$random_string .= random_string($klein, 1);
$random_string .= random_string($klein.$groot.$cijfers, 5);

$perswachtwoord = str_shuffle($random_string);
$perswachtwoord1 = md5($perswachtwoord);

$query1 = "INSERT INTO bloggers (Username, Password, Email) VALUES('$naam','$perswachtwoord1','$email')";
$result1 = mysqli_query($conn, $query1);

if (mysqli_affected_rows($conn) == 1) {
$message = "<P>Je bent geregistreerd en je wachtwoord wordt naar je verstuurd per e-mail. Log in en je bent klaar om te bloggen!</P>";
$address = $email;
$subject = "Uw registratie bij Blogfest";
$body = "Beste $naam,\r\n Hartelijk dank voor je aanmelding.\r\n Je wachtwoord is $perswachtwoord\r\nVeel plezier met bloggen!\r\nGroetjes, Blogfest";
$extra_header_str="From: Blogfest";
$formsent= mail($address, $subject, $body, $extra_header_str);
echo $message;
} else {
  print mysqli_error($conn);
  error_log(mysqli_error($conn));
  $message = "<P>Er is een onbekende fout opgetreden</P>";
  }
}
}


// De invoermogelijkheid wordt in de browser getoond
$thisfile = "051R7-user.php";
$message = <<< MESSAGE
<P>schrijf uzelf in als blogger</P>
<FORM METHOD="post" ACTION="$thisfile">
<label>Username: </label><INPUT TYPE="text" SIZE=32 NAME="naam" value="$naam2" autofocus>
<BR><br>
<label>Email:</label> <INPUT TYPE="email" SIZE=32 NAME="email" value="$email2">
<BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Registreer">
</FORM>
MESSAGE;

$message2 = <<< MSG2
    <h1>Log in als Blogger!</h1>
    <form method="post" action="">
    <label>E-mail: </label><input type="text" name="email" value="$email" placeholder="voer je e-mailadres in" required><br>
    <label>Password: </label><input type="password" name="password" placeholder="voer wachtwoord in" required><br>
    <input type="submit" name = "submit2" value="Log in">
    </form>
MSG2;
    
?>
<HTML>
<HEAD>
<title>inzendopdracht051R7</title>
	<link rel="stylesheet" href="css/051R7.css">
</STYLE>
</HEAD>
<header>
 <div class="box1">
		<h1>Blogfest</h1>
		<p>To blog or to read blogs, that is the question!</p>
	</div>
</header>
<BODY>
<div class="container">
  <div class="menu">
  	<?php
   //include voor het menu
   include("051R7-menu.php");
  	?>
  </div>
  <div class="rechts">
    <TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
    <TR>
    <TD ALIGN=LEFT VALIGN=TOP WIDTH=83%>
    <?php echo $message2; ?>
    </TD>
    </TR>
    </TABLE>
    <!-- de tabel met gebruikers invoer -->
    <TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
    <TR>
    <TD ALIGN=LEFT VALIGN=TOP WIDTH=83%>
    <H1>nog niet aangemeld als blogger?</H1>
    <?php echo $message; ?>
    </TD>
    </TR>
    </TABLE>
  </div>
</div>

</BODY>
</HTML>

  
  