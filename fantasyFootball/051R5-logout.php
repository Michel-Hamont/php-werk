<?php
session_start();
if(session_destroy())
{
header("Location: 051R5_3-showTablesStart.php");
}
