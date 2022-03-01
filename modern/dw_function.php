<?php 
include "../class/Cdewaruci.php";
include "../class/init3.php";

date_default_timezone_set('Asia/Jakarta');
$modul = $_POST['modul'] ;
$loginstring =$_POST['lgs'] ;
$mod=$_POST['mod'];

$user_id = $dcc->getIDbysession($loginstring);

switch 	($modul) {
			case "GetKontrak":
				GetKontrak($DWR,$user_id,$loginstring);
				break;
			case "GetDrawingBycontract":
				GetDrawingBycontract($DWR,$user_id,$loginstring);
				break;
			case "GetlistHistoryDrawing":
				GetlistHistoryDrawing($DWR,$user_id,$loginstring);
				break;
			case "saverevisi":
				saverevisi($DWR,$user_id,$loginstring,$dcc);
				break;
			case "inserModEngine":
				inserModEngine($DWR,$user_id,$loginstring,$dcc);
				break;
			case "inserModlodlines":
				inserModlodlines($DWR,$user_id,$loginstring,$dcc);
				break;
			case "inserModstructure":
				inserModStructure($DWR,$user_id,$loginstring,$dcc);
				break;			
			case "is_update":		
				is_update($DWR,$user_id,$loginstring,$dcc);
				break;				
			case "getlinkUpdate":		
				getlinkUpdate($DWR,$user_id,$loginstring,$dcc);
				break;
			case "cekfolder":
				cekfolder($DWR,$user_id,$loginstring,$dcc);
				break;
			case "GetvalueFromModule":
				GetvalueFromModule($DWR,$user_id,$loginstring,$dcc);
				break;
}	

function GetKontrak($DWR,$user_id,$loginstring){
$nokontrak=$_POST['nil'];

$listExperts=$DWR->GetKontrak($nokontrak);

foreach ($listExperts as $listExpert){

/* echo "nokontrak:" . $listExpert['nokontrak'];
echo "nama:" . $listExpert['nama'];
echo "timestamp:" . $listExpert['timestamp']; */

while ($fruit_name = current($listExpert)) {
	if (!is_numeric(key($listExpert))) {
	echo key($listExpert) . "^" . $fruit_name . ";"  ;

	}
	next($listExpert);
}

echo "#";
}

}
function GetDrawingBycontract($DWR,$user_id,$loginstring){
$nokontrak=$_POST['nil'];

$listExperts=$DWR->getkontrakgambarbycontract($nokontrak);
foreach ($listExperts as $listExpert){

	while ($fruit_name = current($listExpert)) {
		if (!is_numeric(key($listExpert))) {
		echo key($listExpert) . "^" . $fruit_name . ";"  ;

		}
		next($listExpert);
	}

	echo "#";
	}

}

function GetlistHistoryDrawing($DWR,$user_id,$loginstring){

$IDgambar=$_POST['nil'];

$listExperts=$DWR->getRevisibyIDgambar($IDgambar);
foreach ($listExperts as $listExpert){

	while ($fruit_name = current($listExpert)) {
		if (!is_numeric(key($listExpert))) {
		echo key($listExpert) . "^" . $fruit_name . ";"  ;

		}
		next($listExpert);
	}

	echo "#";
	}


}

function GetvalueFromModule($DWR,$user_id,$loginstring){

$IDgambar=$_POST['nil'];
$tipemodul=$_POST['mod'];
$nokontrak=$_POST['idcont'];

if ($tipemodul=="eng"){
$tipegambar=2;
}elseif ($tipemodul=="sc"){
$tipegambar=1;
}elseif ($tipemodul=="ll"){
$tipegambar=3;
}


$id_gam= $DWR->getkontrakgambartype($nokontrak,$tipegambar);
if ($tipegambar==2){
$listExperts=$DWR->getmoduleEngine($nokontrak,$id_gam);
}elseif($tipegambar==1){
$listExperts=$DWR->getmoduleStructure($nokontrak,$id_gam);
}elseif($tipegambar==3){
$listExperts=$DWR->getmoduleloadline($nokontrak,$id_gam);
}
foreach ($listExperts as $listExpert){

	while ($fruit_name = current($listExpert)) {
		if (!is_numeric(key($listExpert))) {
		echo key($listExpert) . "^" . $fruit_name . ";"  ;

		}
		next($listExpert);
	}

	//echo "#";
	}


}

function saverevisi($DWR,$user_id,$loginstring,$dcc){
$IDgambar=$_POST['nil'];
$namaFile=$_POST['file'];
$nokontrak=$_POST['nocontract'];
$tipemodul=$_POST['mod'];

if ($tipemodul=="eng"){
$tipegambar=2;
}elseif ($tipemodul=="sc"){
$tipegambar=1;
}elseif ($tipemodul=="ll"){
$tipegambar=3;
}


	if($dcc->cekSessionActive($loginstring)==true){
		
		if ($DWR->cekKontrakexist($nokontrak)==true){
		$DWR->insertRevGambar($nokontrak,$namaFile, $user_id,$tipegambar );

		echo "1";
		
		}else{
		echo "0";
		
		}
	}else{

		echo "0";
	}
}

function inserModEngine($DWR,$user_id,$loginstring,$dcc){

$idcontract=$_POST['idcont'] ;
$idgambar=$_POST['idgam'] ;
$lpp=$_POST['lpp'] ;
$b=$_POST['b'] ;
$t=$_POST['t'] ;
$bhp=$_POST['bhp'] ;
$ds=$_POST['ds'];
$prop25=$_POST['p2'];
$prop35=$_POST['p3'];
$prop60=$_POST['p6'];

$tipemodul=$_POST['mod'];

if ($tipemodul=="eng"){
$tipegambar=2;
}elseif ($tipemodul=="sc"){
$tipegambar=1;
}elseif ($tipemodul=="ll"){
$tipegambar=3;
}

$id_gam= $DWR->getkontrakgambartype($idcontract,$tipegambar);

		if($dcc->cekSessionActive($loginstring)==true){
		
			$DWR->InsertMod_eNg($idcontract, $id_gam, $lpp, $b, $t, $bhp, $ds,$prop25,$prop35,$prop60);

			echo "1";

		}else{

			echo "0";
		}
}

function inserModStructure($DWR,$user_id,$loginstring,$dcc){

$idcontract=$_POST['idcont'] ;

$lpp=$_POST['lpp'] ;
$lwl=$_POST['lwl'] ;
$B=$_POST['b'] ;
$T=$_POST['t'] ;
$H=$_POST['h'] ;
$Cb=$_POST['cb'];
$vo=$_POST['vo'];


$tipemodul=$_POST['mod'];

if ($tipemodul=="eng"){
$tipegambar=2;
}elseif ($tipemodul=="sc"){
$tipegambar=1;
}elseif ($tipemodul=="ll"){
$tipegambar=3;
}

$id_gam= $DWR->getkontrakgambartype($idcontract,$tipegambar);

		if($dcc->cekSessionActive($loginstring)==true){
		
			$DWR->InsertMod_Sc($idcontract, $id_gam, $lpp, $lwl, $B, $H, $T, $Cb, $vo);

			echo "1";

		}else{

			echo "0";
		}
}

function inserModlodlines($DWR,$user_id,$loginstring,$dcc){

$idcontract=$_POST['idcont'] ;
$idgambar=$_POST['idgam'] ;
$H=$_POST['']; 
$code =$_POST['code'];
$L =$_POST[''];
$T=$_POST[''];
$TF=$_POST[''];
$F=$_POST[''];	
$S=$_POST[''];	
$W=$_POST[''];	
$WNA=$_POST[''];
$LTF=$_POST[''];
$LF =$_POST[''];
$LT =$_POST[''];
$LS =$_POST[''];
$LW =$_POST[''];
$LWNA =$_POST[''];
$typeloadline=$_POST['']; 
$pf=$_POST[''];
$tipemodul=$_POST['mod'];

$LPP=$_POST['lpp'];
$LWL=$_POST['Lwl']; 
$B=$_POST['B']; 
$H=$_POST['H'];  
$Cb=$_POST['Cb'];




if ($tipemodul=="eng"){
$tipegambar=2;
}elseif ($tipemodul=="sc"){
$tipegambar=1;
}elseif ($tipemodul=="ll"){
$tipegambar=3;
}

$id_gam= $DWR->getkontrakgambartype($idcontract,$tipegambar);

		if($dcc->cekSessionActive($loginstring)==true){
		
			//$DWR->insertModlodlines($idcontract, $id_gam,$H, $code ,$L ,$T,$TF,$F,	$S,	$W,	$WNA,$LTF,$LF ,$LT ,$LS ,$LW ,$LWNA ,$typeloadline, $pf,$LPP ,	$LWL ,$B ,	$H , $Cb );
			$DWR->insertModlodlines($idcontract, $id_gam,$H, $code ,0 ,0,0,0,	0,	0,	0,0,0 ,0 ,0 ,0 ,0 ,0, 0,$LPP ,	$LWL ,$B ,	$H , $Cb );

			echo "1";

		}else{

			echo "0";
		}
}

function is_update($DWR,$user_id,$loginstring,$dcc){
$version=$_POST['nil'];

$lasupdates=$DWR->getLastupdate();

	foreach ($lasupdates as $lasupdate){

	$vers=$lasupdate['version'];
	$link=$lasupdate['link'];

	}
	
	if ($version !=$vers ){
	echo "0" ;
	
	}else{
	
	echo "1" ;
	
	}

}

function getlinkUpdate($DWR,$user_id,$loginstring,$dcc){
$version=$_POST['nil'];

$lasupdates=$DWR->getLastupdate();

	foreach ($lasupdates as $lasupdate){

	$vers=$lasupdate['version'];
	$link=$lasupdate['link'];

	}
	
	echo $link ;

}


function cekfolder($DWR,$user_id,$loginstring,$dcc){
$foldername=$_POST['nil'];

if ($DWR->cekKontrakexist($foldername)==true){

	if (!is_dir("../datadcc/" . $foldername)) {
		mkdir("../datadcc/" . $foldername, 0777);
		echo "0";
		
	} else {
		echo "1";
	}

}else {

echo "0";

}	


}




?>