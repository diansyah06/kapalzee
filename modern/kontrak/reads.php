<?php
header('Content-type:application/pdf');
include "../functions.php";
sec_session_start();
require '../class/init2.php';


$id_gam=$_GET['gam'];
$id_kon=$_GET['kon'];
$user_id = $_SESSION['user_id'];

if(!isset($user_id))
		            {
		              die;
		            }

	


if ($_GET[module]=='read'){


	$gambars = $drawing->get_proj_gambar_temp_almat($id_gam);


	$alamat="../" .$gambars ;
	readfile($alamat);
}





?>
