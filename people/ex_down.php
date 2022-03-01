<?php 
$file ="report_". date("Y-m-d"). ".csv";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$file\"");
header("Content-Transfer-Encoding: binary");
include("../sis32/db_connect.php"); include "../functions.php";
sec_session_start();
require("../class/init2.php");

$XML = "No,Nama Kegiatan,Jenis Kegiatan,Group,Mulai,Selesai,Lampiran Surat tugas,Keterangan\n";

$user_id=$_GET['user'];

if(!isset($user_id) & ($user_id == "")){
$user_id = $_SESSION['user_id'];
 }


	$year= $_GET['yr'];
	$month= $_GET['bul'];
	$bulan=$month;
	
	
	$PreviousMonth = mktime(0, 0, 0, $month - 1, 1, $year);
	$CurrentMonth = mktime(0, 0, 0, $month, 1, $year);
	$NextMonth = mktime(0, 0, 0, $month + 1, 1, $year);
	
	$awal=date('Y-m-d', $CurrentMonth);
	$akhir=date('Y-m-d', $NextMonth);
if ($bulan==0){
	
		$kpiss=$kpi->get_kpi_user_stahun($user_id,$awal,$akhir);
					} else {
		$kpiss=$kpi->get_kpi_user($user_id,$awal,$akhir);
	}
	



$no=1;
	foreach ($kpiss as $kpis) {
	$kett= strip_tags($kpis['keterangan']);
	$kett= str_replace (array("\r\n", "\n", "\r"), ' ', $kett);
	$kett = ereg_replace("[\r\n]", ' ', $kett);  
	$kett = trim(preg_replace('/\t+/', '', $kett));
		  $XML.= $no. ",";
		  $XML.= $kpis['name']. ",";
		  $XML.= $kpis['jenis']. ",";
		  $XML.= $kpis['Grup']. ",";
		  $XML.= $kpis['star']. ",";
		  $XML.= $kpis['finish']. ",";
		  $XML.= $kpis['surat']. ",";
		  $XML.= $kett. "\n";
	

	$no++ ;
	}



if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
    header('Cache-Control: public');
}
echo $XML;
exit;
?> 