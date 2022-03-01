<?php
header('Content-type:application/pdf');
include "../../functions.php";
sec_session_start();
require '../../class/init4.php';


$id_gam=$_GET['gam'];
$id_kon=$_GET['kon'];
$user_id = $_SESSION['user_id'];

//cek hak akses page
$memb = $Users->hak_akses_page($user_id,$id_kon);
	if (!$memb){
		die ;
	}
	




	

if ($_GET[module]=='read'){
if ($drawing->get_status_proj_gambar_id($id_gam)==9){ die;}//cek status gambar

	$gambars = $drawing->get_gamb_id_terakir($id_gam,$id_kon);

	foreach ($gambars as $gambar) {
		$alamat = $gambar['alamat'];
		
	}
	$alamat="../../" .$alamat ;
	readfile($alamat);
}

if ($_GET[module]=='re'){

	$gambars = $drawing->get_gamb_by_id($id_gam,$id_kon);

	foreach ($gambars as $gambar) {
		$alamat = $gambar['alamat'];
		$id_gam_induk=$gambar['id_project_gamb']; 	//ambil nama gambar induk buat ambil status
		
	}
	
	if ($drawing->get_status_proj_gambar_id($id_gam_induk)==9){ die;}//cek status gambar
	
	$alamat="../../" .$alamat ;
	readfile($alamat);
}



?>
