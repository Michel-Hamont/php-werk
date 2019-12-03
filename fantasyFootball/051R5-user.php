<?php
//de log in op de mySQL-server
include("051R5-connection.php");

 // we starten een sessie en laten een gebruiker inloggen

    if (isset($_POST['submit2'])) {     
    session_start();
    $naam=$_POST['username'];
    $wachtwoord=md5($_POST['password']);
    $_SESSION['login_user']=$naam; 
    $query = "SELECT username FROM users WHERE username='$naam' and password='$wachtwoord'";
    $result=mysqli_query($conn, $query);
     if (mysqli_num_rows($result) != 0)
    {
     header("Location: 051R5-showTablesSecure.php");   
      }
      else
      {
    echo ("U hebt een incorrecte Username of Password ingegeven!");
    }
    }
// als een bezoeker nog geen gebruiker is dan kan hij zich aanmelden, maar de aanmelding moet wel aan voorwaarden voldoen
$message ="";

// de functie die de voorwaarden van de email invoer bepaalt
function checkMailFormat($email) {
if (preg_match('/[a-z]{2,}@[a-z]{2,}\.nl$/i', $email)) {
    return TRUE;
  }
  else return FALSE;
}

// we creëren voorwaarden voor nieuwe invoer door de registrerende gebruiker
if (isset($_POST['submit']) && $_POST['submit'] == 'Registreer') {
 $pattern = checkMailFormat($_POST['email']);
if (!isset($_POST['naam']) || $_POST['naam'] == "" || strlen($_POST['naam']) < 3) {
$message .= '<P>Vul een username in a.u.b. (minimaal 3 karakters)</P>';
}
if (!isset($_POST['password']) || $_POST['password'] == "" || strlen($_POST['password']) < 8)
  {
    $message .= '<p>vul een password in (minimaal 8 karakters)</p>';
  }
if (!isset($_POST['email']) || $_POST['email'] == "" || $pattern == FALSE )
  {
    $message .= '<p>vul een emailadres in (het format moet tekst@tekst.nl zijn)</p>';
  }
  echo $message;
if ($message =="") {

//als aan de voorwaarden voldaan is, verwerken we de invoer in de database
$naam = trim($_POST['naam']);
$passw = md5($_POST['password']);
$email = $_POST['email'];

$query = "INSERT INTO users (username, password, email)
VALUES('$naam', '$passw', '$email')";
$result = mysqli_query($conn, $query);
if (mysqli_affected_rows($conn) == 1) {
$message = '<P>uw gegevens zijn opgeslagen, u kunt nu inloggen</P>';
echo $message;
} else {
	print mysqli_error($conn);
	error_log(mysqli_error($conn));
$message = '<P>er ging helaas iets mis bij de invoer, probeert u het aub nog een keer.</P>';
}
}
}

// een if om de waarde van de username en het emailadres te bewaren als de invoer niet gelijk goed is (wachtwoord moet voor de veiligheid altijd opnieuw worden ingeven)
if (isset($_POST['naam'])) $naam2 = $_POST['naam'];
else $naam2 = "";
if (isset($_POST['email'])) $email2 = $_POST['email'];
else $email2 = "";

// De invoermogelijkheid wordt in de browser getoond
$thisfile = "051R5-user.php";
$message = <<< MESSAGE
<P>schrijf uzelf in als gebruiker</P>
<FORM METHOD="post" ACTION="$thisfile">
<label>Username: </label><INPUT TYPE="text" SIZE=32 NAME="naam" value="$naam2" autofocus>
<BR><br>
<label>Password:</label><INPUT TYPE="password" SIZE=32 NAME="password"><br><br>
<label>Email:</label> <INPUT TYPE="email" SIZE=32 NAME="email" value="$email2">
<BR><BR>
<INPUT TYPE="submit" NAME="submit" VALUE="Registreer">
</FORM>
MESSAGE;

$message2 = <<< MSG2
    <h1>Log in als gebruiker</h1>
    <form method="post" action="">
    <label>Username: </label><input type="text" name="username" placeholder="voer gebruikersnaam in" required><br>
    <label>Password: </label><input type="password" name="password" placeholder="voer wachtwoord in" required><br>
    <input type="submit" name = "submit2" value="Log in">
    </form>
MSG2;
    
?>
<HTML>
<HEAD>
<title>inzendopdracht 051R5</title>
<STYLE TYPE="text/css">
BODY, P {color: black; font-family: verdana;
font-size: 10pt; }
H1 {color: black; font-family: arial; font-size: 12pt; }
</STYLE>
</HEAD>
<BODY>
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=17%>
</TD>
<TD BGCOLOR="#4da5f2" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<?php echo $message2; ?>
</TD>
</TR>
</TABLE>
<!-- de tabel met gebruikers invoer -->
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=17%>
</TD>
<TD BGCOLOR="#4da5f2" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<H1>nog niet aangemeld als gebruiker?</H1>
<?php echo $message; ?>
</TD>
</TR>
</TABLE>


</BODY>
</HTML>

  
  