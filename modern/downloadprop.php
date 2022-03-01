<?php 

include "../sis32/db_connect.php";
include "../class/init3.php";

$idEvent=$_GET['id'];
$tipehtml=$_GET['html'];

//get info Event
$listEvents=$kpi->getproposalbyID($idEvent);

foreach ($listEvents as $listEvent){
	$description= $listEvent['proposal'] ;
	$titleEvent=$listEvent['judul'] ;
	$peoplelist=$listEvent['peneliti'];
	$peoplelist=substr($peoplelist, 1); // hilangkan , dalam huruf pertama
	$cost=$listEvent['cost'];
	$status=$listEvent['status'];
	
	$topic= $listEvent['type'] ;

	$dateStart=date("d M Y",strtotime($listEvent['start'])) ;
	$dateEnd=date("d M Y",strtotime($listEvent['end'])) ;
}
if($tipehtml==0){
	header("Content-type: application/word");
	header("Content-Disposition: attachment; filename=$titleEvent.doc");
}else{
	header("Content-type: text/html");
	header("Content-Disposition: attachment; filename=$titleEvent.html");	
}
echo $description;

?>