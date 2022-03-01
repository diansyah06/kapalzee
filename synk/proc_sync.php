<?php
include("../sis32/db_connect.php");
include "../functions.php";
sec_session_start();
include "../class/init2.php";
$id_user = $_SESSION['user_id'];
$modul = $_POST['modul'] ;
$id_corigenda = $_POST['id'] ;


if ($modul == "add_corigenda" )   {

//load cek
		$get_koris=$rms->get_corigenda_listallsatu($id_corigenda);
		foreach ($get_koris as $get_kori) {

		if ($get_kori['File2']=="none"){
		$synk->insert_Rules_distribution($get_kori['tipe_amande'],$get_kori['nama'],$get_kori['tipe'],$get_kori['part'],$get_kori['vol'],$get_kori['thn'],$get_kori['File'],$get_kori['id_rule_link'],$get_kori['id_rules']);

		}else{

		$synk->insert_Rules_distribution($get_kori['tipe_amande'],$get_kori['nama'],$get_kori['tipe'],$get_kori['part'],$get_kori['vol'],$get_kori['thn'],$get_kori['File'],$get_kori['id_rule_link'],$get_kori['id_rules']);
		$synk->insert_Rules_distribution($get_kori['tipe_amande'],$get_kori['nama'],$get_kori['tipe'],$get_kori['part'],$get_kori['vol'],$get_kori['thn'],$get_kori['File2'],$get_kori['id_rule_link'],$get_kori['id_rules']);


		}


		}
}

if ($modul == "dell_ditributiion_list" )   {

$synk->delete_Rules_distribution($id_corigenda);

}

if ($modul == "update_name_ditributiion_list" )   {
$nama_baru = $_POST['nama'] ;

$synk->Update_name_Rules_distribution($nama_baru,$id_corigenda);

}


if ($modul == "add_rules_to" )   {
//ambil properti rules
$get_publishs=$rms->get_rules_publish($id_corigenda);

foreach ($get_publishs as $get_publish) {
//get file 

//dell publikasi rules sama sebelumnya

						if ($synk->delete_rule_dist_before($get_publish['id_rules'])) {
						$namaRule=$get_publish['nama'];
									echo "<script type='text/javascript'>
										   alert('done  $namaRule old version has been deleted');
										   </script>" ;

						}
						
						
		if ($get_publish['link'] > 0 ) { //jika upload dengan RMS

		$getFileUploadRMS=$rms->get_file_pub_rms($get_publish['link']);
		
			foreach ($getFileUploadRMS as $getFileUploadRM) {//jika file lebih dari 1 
	
				$synk->insert_Rules_distribution(0,$get_publish['nama'],$get_publish['tipe'],$get_publish['part'],$get_publish['vol'],$get_publish['tahun'],$getFileUploadRM['path'],$get_publish['id'],$get_publish['id_rules']);
		
			}
		}else {
		
		$getFileUploadTanpaRMS=$rms->get_file_pub_tanpa_rms($id_corigenda);//jika upload tanpa rms
		
			foreach ($getFileUploadTanpaRMS as $getFileUploadTanpaRM) {
				
				$synk->insert_Rules_distribution(0,$get_publish['nama'],$get_publish['tipe'],$get_publish['part'],$get_publish['vol'],$get_publish['tahun'],$getFileUploadTanpaRM['path'],$get_publish['id'],$get_publish['id_rules']);
			}
		
		
		}
		





}

}


//nilai balik

	 echo " <h2>Distribution List </h2><p><p> <table class='data display datatableee' id='example' ><thead><tr>
			 <th>No </th>
			 <th>ID </th>
			 <th>ID pub</th>
			 <th>Technical Paper </th>
			 <th>Year </th>
			 <th>Part</th>
			 <th>Vol </th>
			 <th>Type </th>
			 <th>Update Type </th>
			 <th>Action</th>
			 </tr></thead><tbody>";
 $no=1;
$tipe_cor=array("normal", "Corigenda","amandement");
 $ruledistributs=$synk->get_Rules_distribution();
 
 foreach ($ruledistributs as $ruledistribut) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									
									<td>". $ruledistribut['id'] ."</td>
									<td><a href='panel.php?module=viewrules&id=$ruledistribut[id_relation]'>" . $ruledistribut['id_relation'] . "</a></td>
									<td><a href='./$ruledistribut[path]'  target='_blank' >". $ruledistribut['rules']. "</a></td>
									<td>" . $ruledistribut['tahun'] . "</td>
									<td>". $ruledistribut['part']. "</td>
									<td>". $ruledistribut['volume']. "</td>
									<td>". $JenisTechnical_paper[$ruledistribut['tipe_rules']]."</td>
									<td>". $tipe_cor[$ruledistribut['jenis_update']]."</td>
									<td><a href=# onclick='dell_ditributiion_list(". $ruledistribut['id'].");'>Dell  |</a> <a href=# onclick='show_update_name(\""  . $ruledistribut['rules']. "\",". $ruledistribut['id']. ");'>Change name </a></td>
									
									</tr>";

	
	$no++ ;
	}

 echo "</tbody></table><hr>" ;
 
 echo "<script type='text/javascript'>

        $(document).ready(function () {
            
			
			$('.datatableee').dataTable();


			

        });
</script>" ;
 


if ($modul == "create_xml" )   {

$synk->CreateXML();

$Activity->Insert_activity(14, $id_user , 'net','/panel.php?module=rulepub');
echo "<script> alert('done'); </script>";

}



?>