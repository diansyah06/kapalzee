<?php
include("../sis32/db_connect.php");
include "../functions.php";
sec_session_start();
//get var from post
include "../class/init3.php";
include "../modern/dcm.php" ;
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
/* //getalluser
$listUsers=$Users->get_users();

$alluserArray=array(); // store alluseronarray
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

$modul = $_POST['modul'] ;

switch 	($modul) {
			case "training":
				training($kpi,$user_id);
				break;
			case "comreg":
				comreg($dcc,$user_id);
				break;
			case"getActiveSession":
				getActiveSession($dcc,$user_id,$alluserArraydw);
				break;
			

}


function comreg($dcc,$user_id){
$act = $_POST['act'];
$namcomputer=$_POST['name'];
$mac=$_POST['mac'];
$IP=$_POST['ip'] ;


if ($act =="add"){

$dcc->InsertComputer($namcomputer, $mac, $IP);
$listComputer=$dcc->getComputer();

//nilai balik

echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > Name</th>
												<th > Mac</th>
												<th > IP </th>
												<th > Divison</th>
												<th > Action</th

											</tr>
										</thead>
										<tbody>"; 
										
									
										foreach($listComputer as $listTodo ){

										$macformat=AddSeparator($listTodo['mac']);
										
										echo " <tr>
												<td>$listTodo[name]</td>
												<td>$macformat</td>
												<td >$listTodo[ip]</td>
												<td> </td>
											
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a href='#' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										

										}
											
										
										echo "		
											</tr>
										</tbody>
									</table>";
									echo "							<script>
			jQuery(document).ready(function() {

				
				
				TableData.init();
				
				});
</script>	";

}




}

function getActiveSession($dcc,$user_id,$alluserArraydw){

$sessionlist=$dcc->getSession();


//nilaibalik

echo "<table class='table table-condensed table-hover' id='sample-table-3'>
										<thead>
											<tr>
												<th class='center hidden-xs'>
												<div class='checkbox-table'>
													<label>
														<input type='checkbox' class='flat-grey'>
													</label>
												</div></th>
												<th>User</th>
												<th class='hidden-xs'>Joint</th>
												<th><i class='fa fa-time'></i> last seen </th>
												<th class='hidden-xs'>Status</th>
											</tr>
										</thead>
										<tbody>";
										
								
									
									foreach($sessionlist as $sessionlis){
									
									$namuser=$alluserArraydw[$sessionlis['iduser']];
									$tanggalJoint= FormatTanggaljam($sessionlis[start]);
									$tanggalupdate= FormatTanggaljam($sessionlis[lasupdate]);
									echo "<tr>
												<td class='center hidden-xs'>
												<div class='checkbox-table'>
													<label>
														<input type='checkbox' class='flat-grey'>
													</label>
												</div></td>
												<td>
												<a href='#'>
													$namuser
												</a></td>
												<td class='hidden-xs'>$tanggalJoint</td>
												<td>$tanggalupdate</td>
												<td class='hidden-xs'><span class='label label-sm label-success'>Active</span></td>
											</tr>";

									}
										
										
										echo "

										</tbody>
									</table>";


}













	


?>