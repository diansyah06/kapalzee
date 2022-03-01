<?php 
include("../sis32/db_connect.php");
include "../functions.php";
sec_session_start();
//get var from post
include "../class/init3.php";
include "../modern/dcm.php" ;
include "../modern.php" ;
date_default_timezone_set('Asia/Jakarta');



$user = $_GET['yyy'];
$pass =$_GET['xxx'];

$user= base64_decode($user);
$pass = base64_decode($pass);

if (($user == "") or ($pass == "")) {

		echo 0 ;
	
	
}else {
		

		if ($user == "dewaruci" and $pass == "default") {

		$get_comregis = $dcc->get_FTPuser(1);
		
			foreach ($get_comregis as $get_comreg) {
						
						$ftpUser= $get_comreg['ftpuser'];
						$ftpPass= $get_comreg['passuser'];
						$ftpServer = $get_comreg['server']; 
			}	
		//get form database
		
			echo base64_encode($ftpUser . "#" . $ftpPass . "#" . $ftpServer)  ;
		
		} else {
			
				echo 0 ;
			                      
		}
	
}



?>