<?php
include("../sis32/db_connect.php");
include "../functions.php";
include "../class/init5.php";
require_once('../class/watermar.php');
require_once('../class/wraper.php');
sec_session_start();
include "../modern.php" ;

$idDonwloadreq=$_GET['id'];
$getparamet=$drawing->get_DownloadDrawingId($idDonwloadreq);
foreach($getparamet as $getparame){
	$grantedid=$getparame['userid'];
	$iddrawing= $getparame['id_drawing'];
	$id_kon	=$getparame['id_kon'];
	$downloadtime=$getparame['download'];
	$drawingno=$getparame['drawingno'];	
}


$drawingInfo = $drawing->get_proj_gambar_id($iddrawing);
foreach($drawingInfo as $dri)
{
	$title = $dri['judul'];
}

$fullName = $drawingno." - ".$title;
if(strlen($fullName) > 200)
{
	$fullName = substr($fullName, 0, 196) . "..._" ;
}


if(($grantedid!=$_SESSION['user_id']) || ($downloadtime>2)){
	echo "your link expired or you have no granted access";
	die;
}

$drawing->DownloadDrawingRequest(getUserAgent() . getOS() , getIp() ,$idDonwloadreq );

//kode muncul
$kodemun= "BK-" . $idDonwloadreq ;
$kodeHide= "BT-" . base64_encode($idDonwloadreq) . "###";

	$gambars = $drawing->get_gamb_id_terakir($iddrawing,$id_kon);

	foreach ($gambars as $gambar) {
		$statMod=$gambar['status']; //bila uda ada yg stamp download yg stamp.
		if ($statMod==1){
			$alamat = $gambar['file'];
		}else{
			$alamat = $gambar['alamat'];
		}
		$id_subgambar=$gambar['id'];
	}

	$fullName = $fullName . "###". $id_subgambar . "###". ".pdf" ;
	
	$decrypted = $drawing->decrypt_file($alamat);

		if ($statMod==1){
		    $dumby=stream_get_contents ($decrypted);
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="'. $fullName . '"');
			echo $dumby;

		}else{
			$dumby=stream_get_contents ($decrypted);
			//bila terpaksa dipakai dihilngkan create watermark
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="'. $fullName . '"');
			echo $dumby;

		    /*$watermark = new WatermarkerTCPDF(VarStream::createReference($dumby));
		    $watermark->wmText($kodeHide);
		    $watermark->wmText2($kodemun );
		    $watermark->doWaterMark($fullName);*/
		}


?>