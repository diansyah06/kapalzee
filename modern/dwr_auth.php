<?php
include("../sis32/db_connect.php");
include "../functions.php";
include "../class/init3.php";
include "../modern/dcm.php" ;
include "../modern.php" ;
date_default_timezone_set('Asia/Jakarta');

$modul = $_POST['modul'] ;

switch 	($modul) {
			case "login":
				logindcc($dcc,$mysqli);
				break;
			case "ceklogin":
				ceklogin($dcc,$mysqli);
				break;
				
}				

function logindcc($dcc,$mysqli){
 $gabung = $_POST['x'];
 $mac=$_POST['mac'];
 $pieces = explode("#", $gabung);
 
 $user_name=base64_decode($pieces[0]);
 $pass=base64_decode($pieces[1]);
 //$pass=openssl_digest($pass, 'sha512');

 if(login_comp2($user_name, $pass, $mysqli) == true) {
	
		//insert  dcc_logstamp
		//$userId=$dcc->GetId($user_name);
		$userId=$user_name;
		$key= hash('sha512', $pass. $user_name); 
		$lasupdate=date("Y-m-d H:i:s");

		
		$dcc->InsertdcclogStamp($userId, $mac, "login");
		//dc_session
		$dcc->InsertSession($userId, $key, $lasupdate);
		//delloldsession
		$dcc->DeletedSession();
		
		
		echo  $key ;	
   } else {
      // Login failed
	  //$userId=$dcc->GetId($user_name);
	  
	  $userId=$user_name;
	  if ($userId==""){$userId=0; }
	  $dcc->InsertdcclogStamp($userId, $mac, "failed");
	  
      echo "gagal";
   }
   
   
   

}

function ceklogin($dcc,$mysqli){
$loginString = $_POST['logstr'];


if ($dcc->cekSessionActive($loginString)){

echo "1" ;

}else{
echo "0";
}





}









?>