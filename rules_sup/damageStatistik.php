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




?>

<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();
			$('.datatable').dataTable();
			
			setSidebarHeight();
			
			$( "#dialog" ).dialog({autoOpen: false});


        });
</script>
<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<div class="box round first">
                <h2>
                    Damage Statistik data</h2>
   <div class="block">
   <?php  echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Date</th>
											<th>Date of Case</th>
											<th>People</th>
											<th>Register</th>
											<th>Ship Type</th>
											<th>Damage Type</th>
											</tr>
									</thead>
									<tbody>";
   $no=1;
   
   



   while($row = mssql_fetch_array($result))
{


echo "<tr class='odd gradeX'>
									<td >$no</td>
									
									<td>". $row["tgl_input"] ."</a></td>
									<td>" . $row["tgl_kejadian"] . "</a></td>
									<td>". $row["person"]. "</a></td>
									<td>" . $row["reg"] . "</td>
									<td>". $row["tipe_kapal"]. "</td>
									<td>". $row["tipe_damage"]."</td>
									
									
									</tr>";


 $no++ ;
 
  }
   
   
   echo "</tbody></table><hr>";
   //close the connection
mssql_close($dbhandle);
   ?>
   
   </div>
 </div>


