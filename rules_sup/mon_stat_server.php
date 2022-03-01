 <script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();
			$('.datatable').dataTable();

			

          
			setSidebarHeight();



        });
</script>
<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style3 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #FF0000;
}
-->
</style>

 <div class="box round first">
                <h2>
                    FeedBack Rules From Aplikasi BKI Compilation </h2>
                <div class="deskripsi">
				
<?php
define("HOSTt", "10.0.1.203"); // The host you want to connect to.
define("USERt", "masukkk"); // The database username.
define("PASSWORDt", "3twhvjttbm"); // The database password. 
define("DATABASEt", "masukan"); // The database name.
 
/*$mysqlii = new mysqli(HOSTt, USERt, PASSWORDt, DATABASEt);
*/
$link = mysql_connect(HOSTt, USERt, PASSWORDt);

if (!$link) {
    die('Could not connect: ' . mysql_error());
}


if (!mysql_select_db('masukan', $link)) {
    echo 'Could not select database';
    exit;
}

$sql    = 'SELECT * FROM masukan_inet ';
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

echo "<p><hr><table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>ID</th>
											<th>Date</th>
											<th>usulan</th>
											<th>Who</th>
											<th>Mac Address</th>
											<th>Id Rules</th>
											<th>Email</th>
											<th>IP</th></tr>
									</thead>
									<tbody>";
								$no=1;	
									

while ($row = mysql_fetch_assoc($result)) {
	
	echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									
									<td>".$row['id']."</a></td>
									<td>" .$row['tanggal']. "</td>
									<td><a href='panel.php?module=viewrules&id=$row[idpub]' target='_blank'> "  .$row['usulan']. "</a></td>
									
									<td>". $row['siapa']. "</a></td>
									<td>" . $row['mac'] . "</td>
									<td>". $row['id_rules']. "</td>
									<td>". $row['email']."</td>
									<td>".$row['ip']."</td>
									
									</tr>";

	
	$no++ ;
	
	
}

mysql_free_result($result);








		

echo "</tbody></table><hr>";



//cari statistik kemarin

$sql    = 'SELECT * FROM absen ';
$result = mysql_query($sql, $link);
$num_rows_all = mysql_num_rows($result);


//cari jumlah kunjungan kemarin

$sql    = 'SELECT * FROM `absen` WHERE tanggal >CURDATE()-1 and tanggal < CURDATE() ';
$result = mysql_query($sql, $link);
$num_rows_kemarin= mysql_num_rows($result);

//cari jumlah kunjungan minggu kemarin

$sql    = 'SELECT * FROM `absen` WHERE tanggal >CURDATE()-7 and tanggal < CURDATE()';
$result = mysql_query($sql, $link);
$num_rows_week_kemarin= mysql_num_rows($result);


//cari jumlah kunjungan 30 hari kemarin

$sql    = 'SELECT * FROM `absen` WHERE tanggal >CURDATE()-30 and tanggal < CURDATE()';
$result = mysql_query($sql, $link);
$num_rows_bulan_kemarin= mysql_num_rows($result);


//cari jumlah unic by mac

$sql    = 'SELECT DISTINCT mac FROM `absen` ';
$result = mysql_query($sql, $link);
$num_rows_unik= mysql_num_rows($result);

//cari jumlah unic by ip

$sql    = 'SELECT DISTINCT ip FROM `absen` ';
$result = mysql_query($sql, $link);
$num_rows_unik_IP= mysql_num_rows($result);



?>				
				
				
				
				</div>
</div>
				  <div class="box round">
                <h2>
                   Statistik </h2>
                <div class="deskripsi style1">
				<p></p>
                  <ul>
                    <li>Has been access <span class="style3"><?php echo $num_rows_all ;?></span> times </li> 
                    <li>Last day access  <span class="style3"><?php echo $num_rows_kemarin ;?> </span>times</li>
					 <li>Last week access   <span class="style3"><?php echo $num_rows_week_kemarin ;?></span> times</li>
                    <li>Last Month   <span class="style3"><?php echo $num_rows_bulan_kemarin ;?></span> times</li>
                    <li>Unic Visitor MAC   <span class="style3"><?php echo $num_rows_unik ;?></span> times</li>
					<li>Unic Visitor IP   <span class="style3"><?php echo $num_rows_unik_IP ;?></span> times</li>
                  </ul>
                  </div>
				</div>
				