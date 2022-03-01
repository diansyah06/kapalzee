<?php 
include("../sis32/db_connect.php");
include "../functions.php";

sec_session_start();
//get var from post
include "../class/init3.php";
include "../class/CdamageS.php";
include "../modern.php" ;
date_default_timezone_set('Asia/Jakarta');


cekLoginStatus ($mysqli) ;

//get profile user login
	$user_id = $_SESSION['user_id'];
	$nama_user=$Users->get_users_with_title($user_id); //nama 
	$biodata_users= $Users->getUser_biodata($user_id);
	$salting = $_SESSION['salt'];
	
	foreach ($biodata_users as $biodata_user) { 
		$displayPicture = "../" . $biodata_user['path'] ; //wajah
		$jabatanUser = $biodata_user['jabatan'] ; 
		$emailUser = $biodata_user['email'] ;
		$hpUer = $biodata_user['handphone'] ;
	}
//getalluser
$listUsers=$Users->get_users();

$alluserArray=array(); // store alluseronarray
foreach($listUsers as $listUser){
$idusernya=$listUser['id_user'];
$alluserArray[$idusernya]=$listUser['nama'];
}

//array kegiatan
$namakegiatan=array("error","Training","Conference","GlaD","Schoolarship","Committee","Seminar","Presentation","Meeting","launcing","Other");

//curency
$currencyarray=array("error","IDR","USD","SGD","GDB","EUR");
	

$modul = $_POST['modul'] ;

switch 	($modul) {
			case "loadCombo":
				loadCombo($DSR,$user_id,$nama_user);
				break;
			case "addexpert":
				addexpert($DSR,$user_id,$nama_user);
				break;
			case "damageStatitik":	
				damageStatitik($DSR,$user_id,$nama_user);
				break;			
			
}

function loadCombo($DS,$user_id,$nameUser){

$data=$_POST['Nama'] ;
$module=$_POST['mod'] ;
$clas=$_POST['clas'] ;

switch ($module) {
    case "caseProperty":
        $statement = caseProperty($data);
		$boxInfo = "--Select Cause Area--";
        break;
    case "CauseArea":
		$statement = CauseArea($data,$DS);
        $boxInfo = "------Select Specific-----";
        break;
    case "MoreSpecific":
		$statement = MoreSpecific($data);
        $boxInfo = "--Select more Specific--";
        break;
	case "specifick" :
		$statement = specifick($data,$DS);
        $boxInfo = "--Select type Damage--";
		break;
	case "insiden" :
		$statement = "select * from insidendetail where  grup= $data " ;
        $boxInfo = "--Incident Detail--";
		break;
	case "causefaktor" :
		$statement = "select * from causefaktordetail where  grup= $data " ;
        $boxInfo = "--Cause Factor Detail--";
		break;		
		
		
	

}


$dataQery= $DS->ReadTable($statement);
echo "$boxInfo<select id='$clas' name='$clas' class='$clas'>";	
echo "<option selected='selected' value='0' >$boxInfo</option>";
foreach ($dataQery as $dataQer){

echo '<option value="'.$dataQer['Symbol'].'">'.$dataQer['nama'].'</option> ';


}



}

function caseProperty($data){
	$statement="select * from $data " ;
	return $statement ;

}

function CauseArea($data,$DS){

	$pieces = explode("#", $data);

	if ( $pieces[1]=="general_mesin"){
		$pieces[0]= $DS->get_nameItembytablesymbol("general_mesin",$pieces[0]);
		$id="gm_".$pieces[0];
		$id = str_replace(" ", "", "$id");
	}elseif ( $pieces[1]=="elektrical"){
	
		$pieces[0]= $DS->get_nameItembytablesymbol("elektrical",$pieces[0]);
		$id="el_".$pieces[0];
		$id = str_replace(" ", "", "$id");
	}elseif( $pieces[1]=="structural_detail_failures"){
		$pieces[0]= $DS->get_nameItembytablesymbol("structural_detail_failures",$pieces[0]);
		$id="sd_".$pieces[0];
		$id = str_replace(" ", "", "$id");
	}

	$statement="select * from $id order by Nama" ;
	return $statement ;
}

function MoreSpecific($data){

	$pieces = explode("#", $data);

	if ( $pieces[1]=="general_mesin"){
	
		$id="'dmg"."%'";
		
		
	}elseif ( $pieces[1]=="elektrical"){
	
		$id="'dme"."%'";
		
	}elseif( $pieces[1]=="structural_detail_failures"){
	
		$id="'dms"."%'";
		
	}
	
	$statement="select * from db_tipealldamage where `Symbol` LIKE $id  " ;
	return $statement ;

}

function specifick($data,$DS){

	$pieces = explode("#", $data);
	
	if ($pieces[1]=="structural_detail_failures") {
		$statement="Select * from  m_specifik where tipe = '$pieces[2]' ";
		return $statement ;
	}elseif ($pieces[1]=="general_mesin"){
		$statement="Select * from m_specifik where tipe= '$pieces[2]' ";
		
		return $statement ;
		
	}
	elseif ($pieces[1]=="elektrical"){
		$statement="Select * from m_specifik where tipe= '$pieces[2]' ";
		
		return $statement ;
		
	}

}

function addexpert($DSR,$user_id,$nama_user){

$kasus_prop = $_POST[kasus_prop]  ; 
$CA = $_POST[CA] ; 
$SP = $_POST[SP] ; 
$specipik = $_POST[specipik] ; 
$damages = $_POST[damages] ; 

$sourceClass = $_POST['sourceClass'] ; 
$kojek = $_POST['kojek'] ; 
$casename=$_POST['casename'];

$bkicorel=$_POST['bkicorel'];
$howbecome= $_POST['pesanndee'];
$countermes= $_POST['countermeasure'];
$act=$_POST['act'];
$kompilasi= $howbecome . $countermes ;
 

if ($act=="add"){
$DSR->inserTableTexpert(1,$kojek,$kasus_prop, $CA, $SP, $specipik, $damages, $howbecome, $countermes, $sourceClass, $user_id, $bkicorel, $kojek, $kompilasi, $casename);
$dsCode=$DSR->lastInsertId();

$dir_dest= "data" ;
$files = array();
    foreach ($_FILES['item_file'] as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
    }

    // now we can loop through $files, and feed each element to the class
    foreach ($files as $file) {

        // we instanciate the class for each element of $file
        $handle = new Upload($file);

        // then we check if the file has been uploaded properly
        // in its *temporary* location in the server (often, it is /tmp)
        if ($handle->uploaded) {
		
			$handle->allowed = array('image/*');
			$randomname=getRandomFilename();
			$handle->file_name_body_add = $randomname . '_uploaded';
		


            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->Process('/home/www/my_uploads/');
            $handle->Process($dir_dest);

            // we check if everything went OK
            if ($handle->processed) {
			
			//update database
			
			//$handle->createTubnail( $dir_dest.'/' . $handle->file_dst_name, $dir_dest.'/Thumbs'  , 100 );
		 
			$handle->makeThumbnails($dir_dest, $dir_dest.'/' . $handle->file_dst_name, 2);
			
			//$Activity->Insert_docGalery($handle->file_dst_name, 1, $idKegiatan,$tipeKegiatan, $dir_dest.'/' . $handle->file_dst_name );

			$DSR->AdddataBaseFotoEP($dsCode, $dir_dest.'/' . $handle->file_dst_name);
			
            } else {
                // one error occured
                echo '<p class="result">';
                echo '  <b>File not uploaded to the wanted location</b><br />';
                echo '  Error: ' . $handle->error . '';
                echo '</p>';
            }

        } else {
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            echo '<p class="result">';
            echo '  <b>File not uploaded on the server</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }
    }

	}elseif($act=="del"){
	
	$id_expert=$_POST['exID'];
	$DSR->dellDatabaseExpert($id_expert);
	
	
	}
	
//nilai balik
$listExperts=$DSR->getdbExpertlist();	
 echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > ID</th>
												<th > Title</th>
												<th > Type</th>
												<th > Date</th>
												<th > Property</th>
												<th > Area</th>
												<th > Region</th>
												<th > Specific</th>
												<th > Damage</th>
												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										
										$property=$listTraining['CP'];
										if ($property=="structural_detail_failures"){
											$Region=$listTraining['namStruc'];
										}elseif($property=="general_mesin"){
											$Region=$listTraining['namEng'];
										}else{
											$Region=$listTraining['namElec'];
										}

										 
										
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggal_input']));
										$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
										echo " <tr>
												<td>$n</td>
												<td>$listTraining[id]</td>
												<td title='$listTraining[description]' > <a href='$listTraining[path]' target='_blank'>  $listTraining[title]</a></td>
												<td>$listTraining[Tipe]</td>
												<td>$tanggalPlan</td>
												<td >$property</td>
												<td >$Region</td>
												<td >$listTraining[specifik]</td>
												<td >$listTraining[tipe]</td>
												<td >$listTraining[damagee]</td>
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='dellExpert($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
											
										
										echo "		
											</tr>
										</tbody>
									</table><script>
			jQuery(document).ready(function() {
document.body.style.cursor = 'default';
				
				TableData.init();
});
</script>	
";

}

function damageStatitik($DSR,$user_id,$nama_user){

$act=$_POST['act'];
$exID=$_POST['exID'];

if ($act=="del"){

$DSR->deldamagetbl($exID);


}

$listExperts=$DSR->Get_DamageStat();	
//nilai balik
echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
											 	 	 	 	
												<th > no</th>
												<th > Reg.</th>
												<th > Ship Type</th>
												<th > Name</th>
												<th > Date</th>
												<th > Area</th>
												<th > Object</th>
												<th > Specific Area</th>
												<th > Damage</th>
												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){

										$tanggal= date("d M Y",strtotime($listTraining['tgl_input']));

										echo " <tr>
												<td>$n</td>
												<td title='$listTraining[description]' > <a href='#' >  $listTraining[reg]</a></td>
												<td>$listTraining[tipe_kapal]</td>
												<td>$listTraining[namakapl]</td>
												<td >$tanggal</td>
												<td >$listTraining[CP]</td>
												<td >$listTraining[tipe]</td>
												<td >$listTraining[nama]</td>
												<td >$listTraining[tDamage]</td>
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='dellDamageStat($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
											
										
										echo "		
											</tr>
										</tbody>
									</table>
																					<script>
			jQuery(document).ready(function() {
document.body.style.cursor = 'default';
				
				TableData.init();
});
</script>	
";
}	



?>