<?php
include("../sis32/db_connect.php");
include "../functions.php";
include "../class/init5.php";
require_once('../class/PDFStampclass.php');
require_once('../class/wraper.php');
sec_session_start();
include "../modern.php" ;

date_default_timezone_set('Asia/Jakarta');


cekLoginStatus ($mysqli) ;



$X= intval($_GET['x']);
$Y= intval($_GET['y']);

$file='TB101_ABH18048_H-32-011_Bulwark_Construction_R2.pdf';


	$idstamp=intval($_GET['idstamp']);
	$id_kon=intval($_GET['projid']);

	$noKOntrak= $obj->getNokontrak($id_kon);
	$gambars = $drawing->get_UploadStampByid($idstamp,$id_kon);

	foreach ($gambars as $gambar) {
		$id_gambar_current = $gambar['id_gambar'];
		$alamat = $gambar['file'];
		$ids_curr  = $gambar['id'];
		$rev_current= $gambar['rev'];
		$titleGambar_current= $gambar['gambar'];
		$status = $gambar['drawingstatus'];
	}


	$id_subgambar_current= $drawing->GetDrawingSubFromIdStamp($ids_curr);	//get drawing sub id

	$comment_currents= $comment->Get_allCommentfromIdsubdrawing($id_subgambar_current, $id_kon);	//get comment


//die;

  	$decrypted = $drawing->decrypt_file($alamat);
	$dumby=stream_get_contents ($decrypted);


	// $decrypted = fopen($file, 'rb');
	// $dumby=stream_get_contents ($decrypted);

    $watermark = new PDFStampclass(VarStream::createReference($dumby));
    
    $watermark->setCoordinate($X,$Y);
    $watermark->CreatePDFStamp('drawingno',$status,$comment_currents,'0000000000',$noKOntrak);

?>