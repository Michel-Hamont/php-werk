<?php

// een functie om een menu te tonen in de browser met alle bloggers
function display_db_table($tablename, $conn)
{
 // we hebben maar 1 kolom om te tonen en de admin-user mag niet getoond worden, dus we halen id 1 eruit
$query_string = "SELECT BloggerID, Password, Username FROM $tablename WHERE BloggerID != 1 ORDER BY Username DESC";
$result_id = mysqli_query($conn, $query_string);
$column_count = mysqli_num_fields($result_id);
$wachtwoord = '0baea2f0ae20150db78f58cddac442a9';
print("<TABLE BORDER=1>\n");
print("<TR ALIGN=LEFT VALIGN=TOP><TH class='kop'>Blogger</TH></TR>");

while ($row = mysqli_fetch_row($result_id))
{
print("<TR ALIGN=LEFT VALIGN=TOP>");
 
for ($column_num = 2;
$column_num < $column_count;
$column_num++) 
// als we niet ingelogd zijn dan kunnen we van elke blogger de blogs lezen

if (!isset( $_SESSION['login_user'])) {
print("<TD><a class='link' href='051R7-Blogs.php?id=$row[0]'>$row[$column_num]</TD>\n");
}
// zijn we als admin ingelogd dan kunnen we van elke blogger de blogs lezen en aanpassen
elseif (isset( $_SESSION['login_user']) && $_SESSION['login_user'] == $wachtwoord) {
print("<TD><a class='link' href='051R7-BlogsSecure.php?id=$row[0]'>$row[$column_num]</TD>\n");
}
// zijn we ingelogd als blogger dan kunnen we onze eigen blogs aanpassen en lezen, en de blogs van andere bloggers enkel lezen
elseif (isset( $_SESSION['login_user']) && $_SESSION['login_user'] != $wachtwoord) {
  if ($_SESSION['login_user'] == $row[1]) {
   print("<TD><a class='link' href='051R7-BlogsSecure.php?id=$row[0]'>$row[$column_num]</TD>\n");
   } else {
      print("<TD><a class='link' href='051R7-Blogs.php?id=$row[0]'>$row[$column_num]</TD>\n");
     }
}
     

print("</TR>\n");
}

print("</TABLE>\n");
}
// een 2e functie om de blog te tonen

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
    print("<TD>$row[$column_num]</TD>\n");
      }
    print("</TR>\n");
  }
  print("</TABLE>\n");
}


function display_db_table2($connection,$header_bool, $table_params, $query_string)
{
  display_db_query($query_string, $connection, $header_bool, $table_params);
}
