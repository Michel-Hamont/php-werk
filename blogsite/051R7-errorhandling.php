
<?php
function error_msg($err_type, $err_msg, $err_file, $err_line)
{ 
echo "<div class='errorMsg'>";
echo "<b>Error:</b>";
echo "<p>";
echo "Het spijt ons, maar er is iets misgegaan " .
"op de pagina. ";
echo "kijk a.u.b. op de <a href='/help.html'>Help" .
"</a> pagina, ";
echo "of probeer het nog een keer.";
echo "</div>";
echo "<div class='finePrint'>";
echo "Error type: $err_type: $err_msg in $err_file " .
"at line $err_line";
echo "</div>";
}
?>
