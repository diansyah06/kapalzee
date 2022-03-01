<?php 
include("../sis32/db_connect.php");
include "../functions.php";
sec_session_start();
//get var from post
require '../class/init2.php';

if(login_check ($mysqli) == false) {
  echo "<link href='../pengaturan/adminstyle.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
die;}


$modul = $_POST['modul'] ;
$act = $_POST['act'] ;
$id_pegawai = $_POST['id_pegawai'] ;
$code = $_POST['code'] ;
$datetime = $_POST['tanggal'] ;
$date_cek= $_POST['tang_cek'] ;
$pointke = $_POST['pointke'] ;
$jabatan = $_POST['jabatan'] ;

$datetime = date("Y-m-d", strtotime($datetime));
$date_cek = date("Y-m-d", strtotime($date_cek));


switch ($pointke) {
					   
					   	case "1" :
							$data_colom="preparation" ;
							break;
						case "2" :
							$data_colom="teamup" ;
							break;
						case "3" :
							$data_colom="ref" ;
							break;
						case "4" :
							$data_colom="wg" ;
							break;
						case "5" :
							$data_colom="konsenering" ;
							break;
						case "6" :
						    $data_colom="cetak" ;
							break;
						case "7" :
							$data_colom="karakter" ;
							break;
						case "8" :
							$data_colom="adminis" ;
							break;
						case "9":
							$data_colom="komite" ;
							break;
						case "10" :
							$data_colom="scope" ;
							break;
						case "11" :
						    $data_colom="master" ;
							break;
						case "12" :
						    $data_colom="publikasi" ;
							break;
					   
					   default :
					   		$status="ada kesalahan";
					   
					   
					   }

if ($modul=='team' AND $act=='add')   {

$kontrak->Create_proj_team($code, $id_pegawai, $datetime, $jabatan);

	if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_team (id_cek, user, gabung ) VALUES (?, ?, ?)")) {    
		   $insert_stmt->bind_param('iis', $code,$id_pegawai, $datetime   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}
	
 $usericonlist = '<h1>User List</h1>';  
   
   $usericonlist .= '<div class="userthumbs">';
      $zz=$users->get_jabatan();
			foreach ($zz as $z ) {
			$x= $z['id'];
			$jabatn[$x]=$z['nama'] ;
			} 
   if ($load_friend = $mysqli->prepare("SELECT og_team.id, og_team.id_project, og_team.id_user, og_team.proj_jabatan, og_user.nama , rm_biodata.path FROM  og_team JOIN og_user on og_user.id_user=og_team.id_user JOIN  rm_biodata on og_user.id_user= rm_biodata.id_user where og_team.id_project = ? ")) {   
				   // Execute the prepared query.
				       $load_friend->bind_param('s', $code); // Bind "$id_rules" to parameter.
					   $load_friend->execute();
					   $load_friend->bind_result($id,$id_cek, $id_user , $gabung ,$nama ,$almat_wajah );
					   $buang=array();
					   
					   $wajah="img/img-profile.jpg";
					   
					   echo "<div style='overflow-y:scroll; height:370px; margin-top:3px;'>";
					   //Leaderrrr///
					   echo "<div class='friends_area'><img src='$wajah' height='50' style='float:left;' alt=''> 
		   					<label style='float:left' class='name'>
		   					<b>$leader $gabung</b><img id='image2' style='float:left;' src='img/user/crown.png' height='20' /><br>
		    				Vice President Oil and Gas Unit</label></div>";
					   while($load_friend->fetch()){
						 echo "<div id=sapi$id class='friends_area'><img src='$almat_wajah' height='50' width='50' style='float:left;' alt=''> 
						   <label style='float:left' class='name'> 
						   <b>$nama - $jabatn[$gabung]</b>  <span class='read' onclick='fung_del($id,$id_cek); $(sapi$id).remove(); '>Delete</span><br>Institute of Technologies</label></div>";
				
						}
			 			echo '</div>';
			   
	}	   
}


if ($modul=='team' AND $act=='del')   {

$id = $_POST['id_team'] ;


echo $id . $proj_id;
$kontrak->delete_proj_team($id, $code);

		
}


if ($modul=='descr_team' AND $act=='add')   {

$deskripsi = $_POST['deskripsi'] ;

	//isi ke tabel diskripsi
	
		if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_cek_desk (id_cek, point , desk ) VALUES (?, ?, ?)")) {    
		   $insert_stmt->bind_param('iis', $code,$pointke, $deskripsi   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}
	
	//update cek point
	
	if ($insert_stmt = $mysqli->prepare("UPDATE rm_cekpoint SET teamup= ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $date_cek, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}
	//kirim balik nilai ke halaman sebelum
	if ($load_deskr = $mysqli->prepare("SELECT desk FROM rm_cek_desk  where id_cek  = ? AND point= ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('ss', $code ,$pointke ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($desk );

				
					   while($load_deskr->fetch()){
						 echo $desk ;

						}
										
					}
}

if ($modul=='descr_team' AND $act=='del')   {
//rodok ga aman mestine ada pengecekan previlage where cek point and poit = 

		$id = $_POST['id'] ;
		
		if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_cek_desk  where id =?  LIMIT 1")) {   
		 $delet_stmt->bind_param('i', $id  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();
		 }
}

//cek point 2 start


if ($modul=='descr_kind' AND $act=='add')   {

$deskripsi = $_POST['deskripsi'] ;

//cek duplicate di database

if ($load_deskr = $mysqli->prepare("SELECT desk FROM rm_cek_desk  where id_cek  = ? AND point= ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('ss', $code ,$pointke ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($desk );

				
					   $load_deskr->fetch();
					   
					    if($load_deskr->num_rows == 1) {
						$ganda= true ; } 
						else { $ganda=false ; }
					
					}
//akn menghasilkan status ganda 

if (!$ganda ) {
	//isi ke tabel diskripsi
	
		if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_cek_desk (id_cek, point , desk ) VALUES (?, ?, ?)")) {    
		   $insert_stmt->bind_param('iis', $code,$pointke, $deskripsi   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}
	
	//update cek point
	
	if ($insert_stmt = $mysqli->prepare("UPDATE rm_cekpoint SET " . $data_colom ."= ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $date_cek, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}
	//kirim balik nilai ke halaman sebelum
	if ($load_deskr = $mysqli->prepare("SELECT desk FROM rm_cek_desk  where id_cek  = ? AND point= ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('ss', $code ,$pointke ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($desk );

				
					   while($load_deskr->fetch()){
						 echo $desk ;
				
						}
					
					}
		}
		//jika ganda tdak lakukan apa2 dan tampil kan nilai yang ada
		//kirim balik nilai ke halaman sebelum
	if ($load_deskr = $mysqli->prepare("SELECT desk FROM rm_cek_desk  where id_cek  = ? AND point= ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('ss', $code ,$pointke ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($desk );

				
					   while($load_deskr->fetch()){
						 echo $desk ;
				
						}
					
					}
}


if ($modul=='descr_kind' AND $act=='del')   {
//rodok ga aman mestine ada pengecekan previlage where cek point and poit = 

		if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_cek_desk  where id_cek =? AND point = ?  LIMIT 1")) {   
		 $delet_stmt->bind_param('ii',  $code ,$pointke  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();
		 }
		 
		//kirim nilai balik
		if ($load_deskr = $mysqli->prepare("SELECT desk FROM rm_cek_desk  where id_cek  = ? AND point= ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('ss', $code ,$pointke ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($desk );

				
					   while($load_deskr->fetch()){
						 echo $desk ;
				
						}
					
					}
					
		 
}

//cek point lock

if ($modul=='lock' AND $act=='clik')   {
$close = $_POST['nilai'] ;

		if ($insert_stmt = $mysqli->prepare("UPDATE rm_cekpoint SET  close = ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $close, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   
		 
	}


}

if ($modul=='adminis' AND $act=='del')   {
$close = "0000-00-00" ;
$alamat = $_POST['alamat'] ;

		if ($insert_stmt = $mysqli->prepare("UPDATE rm_cekpoint SET  adminis = ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $close, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();  
		 
		}
	
	if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_evidance  where id_cek =? AND point = ?  LIMIT 1")) {   
		 $delet_stmt->bind_param('ii',  $code ,$pointke  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();
		 
		 unlink( "../adms/" . $code . "/" . $alamat );
		 
		 }


}

if ($modul=='uploadpublis' AND $act=='del')   {
$close = "0000-00-00" ;

$id = $_POST['id'] ;

if ($load_stmt = $mysqli->prepare("SELECT path FROM  rm_uploadpub  where id_cek =? and id=? ")){//ambil alamat buat di hapus
		 $load_stmt->bind_param('ii',  $code ,$id  ); 
		 $load_stmt->execute();
		 $load_stmt->store_result();
		 $load_stmt->bind_result($alamat );
		 $load_stmt->fetch();
		 
		 
		}		   
	
	if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_uploadpub  where id_cek =? AND id= ? ")) {   
		 $delet_stmt->bind_param('ii',  $code ,$id  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();
					 
		 unlink( "../" . $alamat );
		 
		 }
		 
		 if ($delet_stmt = $mysqli->prepare("SELECT path FROM  rm_uploadpub  where id_cek =? and id=? ")){
		 $delet_stmt->bind_param('ii',  $code ,$id  ); 
		 $delet_stmt->execute();
		 $delet_stmt->store_result();
		 $delet_stmt->bind_result($path );
		 $delet_stmt->fetch();
		  if($delet_stmt->num_rows == 0) {$habis= true ; }else { $habis=false ; }
		 
		 
		}		   
			 
/*echo     "<script type='text/javascript'>
        $(document).ready(function () {
            window.location.reload();
           
	
		   
        });
    </script>"	;	*/	 
			 
			 
if($habis) {
		if ($insert_stmt = $mysqli->prepare("UPDATE rm_cekpoint SET  publikasi = ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $close, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();  
		 
		}
}

}


if ($modul=='delmaster' AND $act=='del')   {
$close = "0000-00-00" ;
$alamat = $_POST['alamat'] ;
$id = $_POST['id'] ;


if ($load_friend = $mysqli->prepare("SELECT id, id_cek, name, path, tanggal FROM  rm_uploadmaster where id_cek = ?  AND id = ? LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_friend->bind_param('ss', $code , $id); // Bind "$id_rules" to parameter.
					   $load_friend->execute();
					   $load_friend->bind_result($id,$id_cek, $nama_files , $path , $tanggal  );
					   $buang=array();
					    while($load_friend->fetch()){}
					  }

	
	if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_uploadmaster  where id_cek =? AND id= ? LIMIT 1")) {   
		 $delet_stmt->bind_param('ii',  $code ,$id  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();
					 
		 unlink( "../" . $path );
		 
		 }
		 
		 if ($delet_stmt = $mysqli->prepare("SELECT path FROM  rm_uploadmaster  where id_cek =?  ")){
		 $delet_stmt->bind_param('i',  $code   ); 
		 $delet_stmt->execute();
		 $delet_stmt->store_result();
		 $delet_stmt->bind_result($path );
		 $delet_stmt->fetch();
		  if($delet_stmt->num_rows == 0) {$habis= true ; }else { $habis=false ; }
		 
		 
		}		   
			 
if($habis) {
		if ($insert_stmt = $mysqli->prepare("UPDATE rm_cekpoint SET  master = ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $close, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();  
		 
		}
}

}

//karakter rules add

if ($modul=='addchar' AND $act=='add')   {

$id_rules = $_POST['id'] ;
$tahun = $_POST['tahun'] ;
$deskripsi= $_POST['deskripsi'] ;
$nama= $_POST['nama'] ;//nama rules
$gol= $_POST['gol'] ; //gae mbedakno referensi luar atau dalam
$tanggal_saiki = date("Y-m-d");

if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_ruleschar (id_rules,  id_cekpoint, gol, nama, desk, tahun ) VALUES (?, ?, ?, ?, ?, ?)")) {    
		   $insert_stmt->bind_param('iiissi', $id_rules, $code, $gol , $nama, $deskripsi , $tahun   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   
	}


	//update rm_cekpoint 

			if ($insert_stmt = $mysqli->prepare("UPDATE rm_cekpoint SET karakter= ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $tanggal_saiki, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		
			}
			
			//kasih nilai balik
			
	if ($load_rules = $mysqli->prepare("SELECT id_rules,  id_cekpoint, gol, nama, desk, tahun  FROM rm_ruleschar where  id_cekpoint = ? ")) { 
	   $load_rules->bind_param('s', $code  );   
	   // Execute the prepared query.
		   $load_rules->execute();
		    $load_rules->store_result();
		   $load_rules->bind_result($id_rules, $id_cekpoint, $gol , $nama, $desk , $tahun  );

		   while($load_rules->fetch()){ echo  "
		   <p><h5> <b> $nama " . $tahun . "</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-red'>Remove</button></h5></p>
			<p> $desk  </p>
			<hr />"; }	   
				}

}



if ($modul=='addchar' AND $act=='del')   {
$close = "0000-00-00" ;
$id = $_POST['id'] ;




	
	if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_ruleschar  where id_cekpoint =? AND id= ? LIMIT 1")) {   
		 $delet_stmt->bind_param('ii',  $code ,$id  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();
		 
		 }
		 
		 if ($delet_stmt = $mysqli->prepare("SELECT nama FROM  rm_ruleschar  where id_cekpoint =?  ")){
		 $delet_stmt->bind_param('i',  $code   ); 
		 $delet_stmt->execute();
		 $delet_stmt->store_result();
		 $delet_stmt->bind_result($path );
		 $delet_stmt->fetch();
		  if($delet_stmt->num_rows == 0) {$habis= true ; }else { $habis=false ; }
		 
		 
		}		   
			 
if($habis) {
		if ($insert_stmt = $mysqli->prepare("UPDATE karakter SET  master = ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $close, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();  
		 
		}
}
//kirim nilai balik

	if ($load_rules = $mysqli->prepare("SELECT id, id_rules,  id_cekpoint, gol, nama, desk, tahun  FROM rm_ruleschar where  id_cekpoint = ?  ")) {   
	   // Execute the prepared query.
	      $load_rules->bind_param('s', $code  );   
		   $load_rules->execute();
		     $load_rules->store_result();
		   $load_rules->bind_result($id, $id_rules, $id_cekpoint, $gol , $nama, $desk , $tahun  );
		   $chara=array();
		   while($load_rules->fetch()){ echo "
		   <p><h5> <b> $nama " . $tahun . "</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class='btn btn-red' onclick='fung_del_char($id ,$id_cekpoint);'>Remove</div></h5></p>
			<p> $desk  </p>
			<hr />"; }	   
				}

}

if ($modul=='addscope' AND $act=='add')   {


$intoforce = $_POST['intoforce'];

$datetime = date("Y-m-d", strtotime($intoforce));

$panjang	= $_POST['panjang'];

	
$hp= $_POST['hp'];

	
$kva	= $_POST['kva'];

	
$dwt	= $_POST['dwt'];

	
$bahan	= $_POST['bahan'];

$tipe= $_POST['tipe'];

	
$operasi= $_POST['operasi'];

	
$cargo= $_POST['cargo'];

	
$purpose	= $_POST['purpose'];

	
$special= $_POST['Special'];
	
$deskrip= $_POST['describ'];

$tanggal_saiki = date("Y-m-d");
//cek data exist

if ($load_deskr = $mysqli->prepare("SELECT id FROM rm_scope  where id_cek  = ?   LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('s', $code  ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($desk );

				
					   $load_deskr->fetch();
					   
					    if($load_deskr->num_rows == 1) {
						$ganda= true ; } 
						else { $ganda=false ; }
					
					}

if (!$ganda ) {
//add
if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_scope (id_cek, intoforce, panjang, hp, kva, dwt, bahan, tipe, operasi, cargo, 	pupose, Special, describ  ) VALUES (?, ?, ?,?,?,?,?,?,?,?,?,?,?)")) {    
		   $insert_stmt->bind_param('issssssssssss', $code, $datetime , $panjang, $hp, $kva, $dwt, $bahan, $tipe, $operasi, $cargo, $purpose,$special, $deskrip   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		 	}
	
	//update cek point
	if ($insert_stmt = $mysqli->prepare("UPDATE rm_scope SET scope = ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $tanggal_saiki, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}
	


}else {
///update

if ($insert_stmt = $mysqli->prepare("UPDATE rm_scope SET intoforce = ? ,panjang = ? ,hp = ? ,kva = ? ,dwt = ? ,bahan = ?,tipe = ?,operasi = ?,cargo = ?,pupose = ?,Special = ?,describ = ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ssssssssssssi', $datetime , $panjang, $hp, $kva, $dwt, $bahan, $tipe, $operasi, $cargo, $purpose,$special, $deskrip, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		    
	}




//update cek point
if ($insert_stmt = $mysqli->prepare("UPDATE rm_cekpoint SET scope = ? where id_cek= ?")) {    
		   $insert_stmt->bind_param('ss', $tanggal_saiki, $code  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}
	
}

//nilai balik

	if ($load_deskr = $mysqli->prepare("SELECT intoforce, panjang, hp, kva, dwt, bahan, tipe, operasi, cargo, 	pupose, Special, describ  FROM rm_scope  where id_cek  = ?   LIMIT 1")) {   
					   // Execute the prepared query.
						   $load_deskr->bind_param('s', $code  ); // Bind "$id_rules" to parameter.
						   $load_deskr->execute();
							$load_deskr->store_result();
						   $load_deskr->bind_result($datetime , $panjang, $hp, $kva, $dwt, $bahan, $tipe, $operasi, $cargo, $purpose,$special, $deskrip  );
	
					
						   $load_deskr->fetch();
						   
						   
			echo  ".,,,,,,,,,,,,,,,,,,,,,,<br /><ul>
<li><strong>IntoForce    		: $datetime</strong></li>
<li><strong>Lenght    	 		: $panjang</strong></li>
<li><strong>Engine Power 		: $hp</strong></li>
<li><strong>Auxelery     		: $kva</strong></li>
<li><strong>Deathwight   		: $dwt</strong></li>
<li><strong>Material   	 		: $bahan</strong></li>
<li><strong>Type     	 		: $tipe</strong></li>
<li><strong>Operation area 		: $operasi</strong></li>
<li><strong>Cargo Contaiment  	: $cargo</strong></li>
<li><strong>Purpose    	 		: $purpose</strong></li>
<li><strong>Special Equipment   : $special</strong></li>
<li><strong>Description    	 	: $deskrip</strong></li>" ;


echo "</ul>	<hr />"	;	
						   
						   
	}					   
}



/*$ourFileName = "testFile.txt";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
fclose($ourFileHandle);*/





?>