<?php 
include("../sis32/db_connect.php");
include "../functions.php";

sec_session_start();
//get var from post
include "../class/init3.php";
include "../class/Cdewaruci.php";
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

/* $alluserArray=array(); // store alluseronarray
foreach($listUsers as $listUser){
$idusernya=$listUser['id_user'];
$alluserArray[$idusernya]=$listUser['nama'];
} */

$listUsers=$dcc->GetdccUser();


$alluserArraydw=array(); // store alluseronarray
foreach($listUsers as $listUser){
$idusernya=$listUser['nup'];
$alluserArraydw[$idusernya]=$listUser['nama'];
}

//array kegiatan
$namakegiatan=array("error","Training","Conference","GlaD","Schoolarship","Committee","Seminar","Presentation","Meeting","launcing","Other");

//curency
$currencyarray=array("error","IDR","USD","SGD","GDB","EUR");
	

$modul = $_POST['modul'] ;

switch 	($modul) {
			case "dckontrak":
				addkontrak($DWR,$user_id,$nama_user);
				break;
			case "register";
			   Register($DWR,$user_id,$nama_user);
				break;
			case "kontrakgambar":
				kontrakgambar($DWR,$user_id,$nama_user);
				break;
			case "adddccUser":	
				adddccUser($DWR,$user_id,$nama_user,$dcc);
				break;		
}

function addkontrak($DWR,$user_id,$nama_user){

$nokontrak = $_POST['nokontrak'] ;
$name=$_POST['projecName'] ;
$tglKOntrak = date("Y-m-d",strtotime($_POST['datecontrak'])) ;
$reg = $_POST['register'] ;

$DWR->insertKontrak($nokontrak,$tglKOntrak ,$reg,$name);
$listExperts=$DWR->GetKontrak();
//nilai balik
echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > Contract</th>
												<th > Nama</th>
												<th > Date</th>
												<th > Reg</th>

												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggal_input']));
										$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
										echo " <tr>
												<td>$n</td>
												<td>$listTraining[nokontrak]</td>
												<td >$listTraining[nama]</td>
												<td>$listTraining[tglKOntrak]</td>
												<td>$listTraining[reg]</td>
												
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
											
										
										echo "		
											</tr>
										</tbody>
									</table>";
									
echo "<script>
			jQuery(document).ready(function() {

				TableData.init();
			});
		</script>";	


}

function Register($DWR,$user_id,$nama_user){
$act=$_POST['act'];
$register = $_POST['register'];
$namaKapal =$_POST['namaKapal'];

$LPP =$_POST['LPP'];
$GT =$_POST['GT'];
$thnbangun =$_POST['thnbangun'];
$T =$_POST['T'];


$DWR->insertRegister($register,$namaKapal,$LPP, $T,$GT, $thnbangun);

//nilai balik
$listExperts=$DWR->getRgister();

echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > Register</th>
												<th > Nama Kapal</th>
												<th > LPP</th>
												<th > GT</th>
												<th > T</th>
												<th > year build</th>

												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggal_input']));
										$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
										echo " <tr>
												<td>$n</td>
												<td>$listTraining[reg]</td>
												<td >$listTraining[namaKpl]</td>
												<td>$listTraining[LBP]</td>
												<td>$listTraining[GT]</td>
												<td>$listTraining[T]</td>
												<td>$listTraining[tahun_bangun]</td>
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
											
										
										echo "		
											</tr>
										</tbody>
									</table>";
									


}
function kontrakgambar($DWR,$user_id,$nama_user){
$act=$_POST['act'];
$nokontrak=$_POST["nokontrak"];
$typedraw=$_POST["typedraw"];
$namdraw=$_POST["namdraw"];

if ($act=="add"){
$DWR->insertKontrakgambar($nokontrak,$namdraw,$typedraw);
}elseif($act=="refresh"){

}
//nilai balik
$listkontrakgambar=$DWR->getkontrakgambarbycontract($nokontrak);

echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > Contract</th>
												<th > Nama</th>
												<th > type</th>
												

												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listkontrakgambar as $listTraining ){
										

										echo " <tr>
												<td>$n</td>
												<td>$listTraining[nokontrak]</td>
												<td>$listTraining[namagambar]</td>
												<td>$listTraining[typedraw]</td>
												
												
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
											
										
										echo 		
											"</tr>
										</tbody>
									</table>";


}

function adddccUser($DWR,$user_id,$nama_user,$dcc){
$act=$_POST['act'];
$nup=$_POST['nup'];
$nama=$_POST["nama"];
$divisi=$_POST["divisi"];

$default="bki1964";
	$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	// Create salted password (Careful not to over season)
	$password = hash('sha512', $default.$random_salt);
	
if ($act=="add"){
$dcc->insertDCCuser($nup,$nama,$divisi,$password,$random_salt);
}elseif($act=="refresh"){

}
//nilai balik
$listExperts=$dcc->GetdccUser();
echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > NUP</th>
												<th > Nama</th>
												<th > Divisi</th>
												

												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										
										
										echo " <tr>
												<td>$n</td>
												<td>$listTraining[nup]</td>
												<td >$listTraining[nama]</td>
												<td>$listTraining[divisi]</td>

												
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
											
										
										echo"		
											</tr>
										</tbody>
									</table>";

}

?>