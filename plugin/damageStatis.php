<?php
$myServer = "10.0.1.76";
$myUser = "userlitbang";
$myPass = "1964bkilitbang";
$myDB = "databasebki";

//connection to the database
$dbhandle = mssql_connect($myServer, $myUser, $myPass)
  or die("Couldn't connect to SQL Server on $myServer");

//select a database to work with
$selected = mssql_select_db($myDB, $dbhandle)
  or die("Couldn't open database $myDB");

//declare the SQL statement that will query the database
$query = "SELECT * FROM DS_DAMAGE_S ";
/* $query .= "FROM cars ";
$query .= "WHERE name='BMW'"; */

//execute the SQL query and return records
$result = mssql_query($query);

//$numRows = mssql_num_rows($result);
//echo "<h1>" . $numRows . " Row" . ($numRows == 1 ? "" : "s") . " Returned </h1>";

//display the results
while($row = mssql_fetch_array($result))
{
  echo "<li>" . $row["id"] . $row["tgl_kejadian"] . $row["person"] . "</li>";
}
//close the connection
mssql_close($dbhandle);
?> 