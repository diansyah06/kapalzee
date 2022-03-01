<?php
include("/sis32/db_connect.php");
$id_pub=$_GET['id'];
//load database buat cari cek point
if ($load_deskr = $mysqli->prepare("SELECT  id_rules, nama, tahun, tipe, part, vol, link, status FROM rm_rulepub  where id = ? LIMIT 1  ")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('i', $id_pub ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					   $load_deskr->store_result();
					   $load_deskr->bind_result($idrules,$nama_rules,$tahun,$Rule_tipe, $part , $volum ,$link_cek , $statuss );

					   $load_deskr->fetch();
					   
					   //special part di load biar ga perlupkai joint 
					   $part=$part_arrays[$part];
					   
}	


$id_cekp=$link_cek;
$Group_filea=array();
$Group_file_masta=array();
//bila link 0 berarti tak di buat dari RMS

if ($id_cekp==0){


//load file pub

			if ($load_deskr = $mysqli->prepare("SELECT  nama , path  FROM  rm_upload_tanpa_rms  where id_rules_pub = ? and tipe=1  ")) {   
							   // Execute the prepared query.
								   $load_deskr->bind_param('i', $id_pub ); // Bind "$id_rules" to parameter.
								   $load_deskr->execute();
								   $load_deskr->store_result();
								   $load_deskr->bind_result($File_rule_name,$alamat_rule_name);
			
								
								  while($load_deskr->fetch())
								  
								  {
								  $Group_filea[]="<li><a href='$alamat_rule_name' target='_blank'>" .$File_rule_name."</a></li>";
								   $Group_alamata[]=$alamat_rule_name ;
								  }
								   
			}	
}



if ($load_deskr = $mysqli->prepare("SELECT  name , path  FROM rm_uploadpub  where id_cek = ?  ")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('i', $id_cekp ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					   $load_deskr->store_result();
					   $load_deskr->bind_result($File_rule_name,$alamat_rule_name);

					   $Group_file=array();
					  while($load_deskr->fetch())
					  
					  {
					  $Group_file[]="<li><a href='$alamat_rule_name' >" .$File_rule_name."</a></li>";
					  $Group_alamat[]= $alamat_rule_name ;
					  }
					   
}	


$result1 = count($Group_alamat);
$result2 = count($Group_alamata);

if (($result1==1) or ($result2==1)){ //cek jika publikasi cuman 1

header('Content-type:application/pdf');

		if (count($Group_alamat)> 0 ){   //masukan alamat dari database rule publish
		foreach ($Group_alamat as $isi) { $alamat= $isi ;} 
		}
		if (count($Group_alamata)> 0 ){ //masukan alamat dari database cek_point
		foreach ($Group_alamata as $isi) { $alamat = $isi ;} 

		}

	
	readfile($alamat);

} else  //jika publikasi lebih dari 1 maka

{
//tulis link rules
foreach ($Group_file as $isi) { echo $isi ;} 
foreach ($Group_filea as $isi) { echo $isi ;} 

}









?>