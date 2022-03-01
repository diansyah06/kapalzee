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
$userid = $_SESSION['user_id'];

$X= intval($_GET['x']);
$Y= intval($_GET['y']);

//$file='TB101_ABH18048_H-32-011_Bulwark_Construction_R2.pdf';

$listUsers = $Users->get_users();
$alluserArray = array(); // store alluseronarray

foreach($listUsers as $listUser)
	{
	$idusernya = $listUser['id_user'];
	$alluserArray[$idusernya] = $listUser['nama'];
	}

$idstamp=intval($_GET['idstamp']);
$id_kon=intval($_GET['projid']);
$mode = $_GET['mode'];

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

$drawingInfo = $drawing->get_proj_gambar_id($id_gambar_current);
foreach($drawingInfo as $drw)
{
	$type = $drw['tipe'];
}

$today = date("Y-m-d");
$mailNumber = $contract->getMailNumber($id_kon, $today, $type);

$num = $mailNumber['data'];
if(empty($num) || is_null($num) || $num == "")
{
	$name = $alluserArray[$userid];
	$con = $obj->get_wokspaceByid($id_kon);
	foreach($con as $c)
	{
		$connum = $c['id_kontrak'];
	}

	if($name = "")
	{
		$name = "Supervisor";
	}

	$params = array(
					"kepada"=>$connum,
					"nup_entry"=>$userid,
					"nama_entry"=>$name
					);
	$url = "http://api.bki.co.id:82/api-zee/create_no_surat.php";
	$res = json_decode($obj->httpPost($url, $params), true);
	$num = $res[0]['no_surat'];

	$contract->insertMailNumber($id_kon, $num, $type);
	$mailNumber = $contract->getMailNumber($id_kon, $today, $type);
	$num = $mailNumber['data'];
	if($type == 5)
	{
		$fullNum = "B.$num/SV.001/STA/KI-$year";	
	}else
	{
		$fullNum = "B.$num/SV.001/PRB/KI-$year";	
	}
	
}else
{
	$year = date("y");
	if($type == 5)
	{
		$fullNum = "B.$num/SV.001/STA/KI-$year";	
	}else
	{
		$fullNum = "B.$num/SV.001/PRB/KI-$year";	
	}
}

//die;

$decrypted = $drawing->decrypt_file($alamat);
$dumby=stream_get_contents ($decrypted);

// $decrypted = fopen($file, 'rb');
// $dumby=stream_get_contents ($decrypted);

if($mode == "preview")
{
	$passwords="H89jv3Twhv";
	$path = "../data/temp/";
	if(!file_exists($path))
	{
		mkdir($path, 0775, true);
	}
	$oldName = $path."$userid"."_$id_kon.pdf";
	$watermark = new PDFStampclass(VarStream::createReference($dumby), $oldName);

	$watermark->setCoordinate($X,$Y);
	$watermark->CreatePDFStamp('drawingno',$status,$comment_currents,'0000000000',$noKOntrak);

	$encryptName = $path."temp_"."$userid"."_$id_kon.pdf";
	$drawing->encrypt_file($oldName, $encryptName, $passwords);

	unlink($oldName);
	echo $encryptName;

}else if($mode == "approve")
{
	$passwords="H89jv3Twhv";
	$path = "../data/$id_kon/";
	if(!file_exists($path))
	{
		mkdir($path, 0775, true);
	}
	$randomname = getRandomFilename() . ".pdf";
	$name = $path.$randomname;
	$watermark = new PDFStampclass(VarStream::createReference($dumby), $name);

	$watermark->setCoordinate($X,$Y);
	$watermark->CreatePDFStamp('drawingno',$status,$comment_currents, $fullNum, $noKOntrak);

	$encryptName = $path."approve_stamp_".$randomname;
	$drawing->encrypt_file($name, $encryptName, $passwords);

	unlink($name);
	echo $encryptName;
}

?>