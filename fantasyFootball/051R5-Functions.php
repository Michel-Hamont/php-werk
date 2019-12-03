<?php
// allereerst een standaard functie om een tabel te tonen met data vanuit MySQL (met een extra if toegevoegd om te tweaken zie regel 28)
function display_db_query($query_string, $connection,
                       $header_bool, $table_params)
{
  $result_id = mysqli_query($connection, $query_string)
             or die("display_db_query:" . mysqli_error($connection));
  $column_count = mysqli_num_fields($result_id)
                  or die("display_db_query:" . mysqli_error($connection));

  print("<TABLE $table_params >\n");

  if ($header_bool) {
    print("<TR>");
    while ($field_name = mysqli_fetch_field($result_id)) {
      print("<TH>$field_name->name</TH>");
    }
    print("</TR>\n");
  }
  while ($row = mysqli_fetch_row($result_id))
  {
    print("<TR ALIGN=LEFT VALIGN=TOP>");
    for ($column_num = 0;
        $column_num < $column_count;
        $column_num++)
      {
    
  // een extra if om de eerste kolom een hyperlink te geven om scores te kunnen invoeren alleen als de gebruiker ingelogd is en zich op de secure pagina bevindt.
        if ($column_num == 0 && isset( $_SESSION['login_user'] )) {
        print("<TD><a href='051R5-wedstrijd.php'>$row[$column_num]</a></TD>\n");
    }
        else print("<TD>$row[$column_num]</TD>\n");
      }
    print("</TR>\n");
  }
  print("</TABLE>\n");
}


function display_db_table($connection,$header_bool, $table_params, $query_string)
{
  display_db_query($query_string, $connection, $header_bool, $table_params);
}


// een 2e functie om de stand te tonen in de browser
function display_db_table2($tablename, $conn)
{
$query_string = "SELECT teamname, Gespeeld, Gewonnen, Gelijk, Verloren, Voor, Tegen, Doelsaldo, Punten FROM $tablename ORDER BY Punten DESC, Doelsaldo DESC, Voor DESC, teamname ASC";
$result_id = mysqli_query($conn, $query_string);
$column_count = mysqli_num_fields($result_id);
print("<TABLE BORDER=1>\n");
print("<TR ALIGN=LEFT VALIGN=TOP><TH>Teamnaam</TH><TH>Gespeelde wedstrijden</TH><TH>gewonnen wedstrijden</TH><TH>gelijkgespeelde wedstrijden</TH><TH>verloren wedstrijden</TH><TH>doelpunten voor</TH><TH>doelpunten tegen</TH><TH>doelsaldo</TH><TH>punten</TH></TR>");
while ($row = mysqli_fetch_row($result_id))
{
print("<TR ALIGN=LEFT VALIGN=TOP>");
for ($column_num = 0;
$column_num < $column_count;
$column_num++)
print("<TD>$row[$column_num]</TD>\n");
print("</TR>\n");
}
print("</TABLE>\n");


}

?>