<?php 
include("../sis32/db_connect.php");
define("HOSTt", "localhost"); // The host you want to connect to.
define("USERt", "datacenter"); // The database username.
define("PASSWORDt", "jttbm"); // The database password. 
define("DATABASEt", "datacenter"); // The database name.
 
$mysqlii = new mysqli(HOSTt, USERt, PASSWORDt, DATABASEt);
// If you are connecting via TCP/IP rather than a UNIX socket remember to add the port number as a parameter.
#########################

$part1= '001002001' ;
$part2= '001002002' ; 	
$part3= '001002007' ;
$part4= '001002003' ;
$part5=	'001002004' ;
$part6= '001002008' ;
$part7= '001002006' ;
$tanggal_saiki = date("Y-m-d");

//Delete all part on Telik sandi
$a=delete_by_group($mysqlii,$part1) ;
$a=delete_by_group($mysqlii,$part2) ;
$a=delete_by_group($mysqlii,$part3) ;
$a=delete_by_group($mysqlii,$part4) ;
$a=delete_by_group($mysqlii,$part5) ;
$a=delete_by_group($mysqlii,$part6) ;
$a=delete_by_group($mysqlii,$part7) ;


//query rules publish//
		$statement1="SELECT id, id_rules , nama, tahun, tipe, link, status,part, vol FROM rm_rulepub"; 
		if ($load_stmt = $mysqli->prepare( $statement1  )) {   
				// Execute the prepared query.
				$load_stmt->execute();
				$load_stmt->bind_result($id, $id_rules, $title, $year , $tipee , $Link , $status , $parts , $vols  );
				// fetch result.
				while($load_stmt->fetch()){

						$codee= "Part " . $parts . " vol " . $vols ;
						$compilasi= $year . " " . $title . " " . $codee ;
								 
						switch ($parts) {
					   
								case "1" :
									$partt="001002001" ;
									break;
								case "2" :
									$partt="001002002" ;
									break;
								case "3" :
									$partt="001002007" ;
									break;
								case "4" :
									$partt="001002003" ;
									break;
								case "5" :
									$partt="001002004" ;
									break;
								case "6" :
									$partt="001002008" ;
									break;
								case "7" :
									$partt="001002006" ;
									break;

									}
						//change path sesuaikan folder		 		 
						$pathhh='../../rms/view_rule_telik.php?module=viewrules&id='. $id; 
						
						//import data ke telik sandi
						$a=add_telik_s($mysqlii,$title,$codee,$pathhh, $partt, $tanggal_saiki,"0",$year,"RMS", $compilasi) ;
								 
								 
								 								 							
						}
			
			echo "done"; 
		 	
	}
						








//function tambahan

function delete_by_group($mysqlii,$part) {
	if ($delet_stmt = $mysqlii->prepare("DELETE FROM  data  where groub =?  ")) {   
		 $delet_stmt->bind_param('s', $part  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();

	    }
}


function add_telik_s($mysqlii,$nama,$code,$path, $groub,$tanggal,$akses,$thn,$lacak, $compilasi) {

	if ($insert_stmt = $mysqlii->prepare("INSERT INTO data (nama_d, code, path, groub, tanggal, akses, thn, lacak, compilasi ) VALUES (?, ?, ?,?,?,?,?,?,?)")) {    
		   $insert_stmt->bind_param('ssssssiss', $nama, $code,$path, $groub,$tanggal,$akses,$thn,$lacak, $compilasi   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}
}

$fp = fopen('t.txt', 'w');
fwrite($fp, $tanggal_saiki  );
fclose($fp);

?>