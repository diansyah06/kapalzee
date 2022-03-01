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
	$fullName = substr($fullName, 0, 196) . "..._";
}


if(($grantedid!=$_SESSION['user_id']) || ($downloadtime>3)){
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

		if ($statMod==1){ // bila sudah di stamp maka tinggal di read saja
		    $dumby=stream_get_contents ($decrypted);
			file_put_contents($fullName . '.pdf', $dumby);

			$currentTimeinSeconds = time();  

		    $temp_file_name =  $currentTimeinSeconds . '_download.zip' ;

			$zip = new ZipArchive;
			if ($zip->open($temp_file_name , (ZipArchive::CREATE | ZipArchive::OVERWRITE) ))
			{
			    $zip->addFile($fullName . '.pdf');
			    $zip->close();
			}

			header('Content-type: application/zip');
			header("Content-Disposition: attachment; filename=$temp_file_name");
			header('Content-Transfer-Encoding: binary');
		    header('Content-Length: ' . filesize($temp_file_name));
		    header('Connection: close');
			readfile($temp_file_name);


		}else{
			//bila terpaksa dipakai dihilngkan create watermark
 				$dumby=stream_get_contents ($decrypted);
			file_put_contents($fullName . '.pdf', $dumby);

			/*$dumby=stream_get_contents ($decrypted);
		    $watermark = new WatermarkerTCPDF(VarStream::createReference($dumby),$fullName . '.pdf' );
		    $watermark->wmText($kodeHide);
		    $watermark->wmText2($kodemun );
		    $watermark->doWaterMark($fullName);*/

		    $currentTimeinSeconds = time();  

		    $temp_file_name =  $currentTimeinSeconds . '_download.zip' ;

			$zip = new ZipArchive;
			if ($zip->open($temp_file_name , (ZipArchive::CREATE | ZipArchive::OVERWRITE) ))
			{
			    $zip->addFile($fullName . '.pdf');
			    $zip->close();
			}

			header('Content-type: application/zip');
			header("Content-Disposition: attachment; filename=$temp_file_name");
			header('Content-Transfer-Encoding: binary');
		    header('Content-Length: ' . filesize($temp_file_name));
		    header('Connection: close');
			readfile($temp_file_name);
		}

		if(file_exists($temp_file_name)){ //bersihkan file sampah 
		    unlink($temp_file_name);
		    unlink($fullName . '.pdf');
		}


?>