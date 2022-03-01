<?php
include "../functions.php";

include "../sis32/db_connect.php";
sec_session_start();
include "../class/init3.php";
include "../modern.php" ;

if(login_check ($mysqli) == false) {
  echo "<link href='../pengaturan/adminstyle.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
die;}



//get profile user login
	$user_id = $_SESSION['user_id'];
	$nama_user=$Users->get_users_with_title($user_id); //nama 
	$biodata_users= $Users->getUser_biodata($user_id);
	
	foreach ($biodata_users as $biodata_user) { 
		$displayPicture = "../" . $biodata_user['path'] ; //wajah
		$jabatanUser = $biodata_user['jabatan'] ; 
		$emailUser = $biodata_user['email'] ;
		$hpUer = $biodata_user['handphone'] ;
	} 


$modul= $_GET['module'];


if ($modul=="download"){

$getobject=$_GET['id'];
$obj->updateDatabasedownloaddetail($getobject,$user_id);
$linkFile=$obj->getfilelastrevision($getobject);


//nilai balik
echo "<script type='text/javascript'>
<!--
window.location = '$linkFile'
//-->
</script>"; 


}


?>