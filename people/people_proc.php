<?php  include("../sis32/db_connect.php"); include "../functions.php";

$nott_whiteboard=true ;


sec_session_start();
include("../class/init3.php");
date_default_timezone_set('Asia/Jakarta');
$modul = isset($_POST['modul']) ;
$act = isset($_POST['act']) ;
//get info user
$user_id = $_SESSION['user_id'];
$profil_pic=get_profil_pic($mysqli);
$nama_user = $_SESSION['usernama'] ;



//modul profil
if ($modul=='profil' AND $act=='add')   {


$jabatan=$_POST['jabatan'];

$alamat=$_POST['alamat'];

$email=$_POST['email'];

$ym=$_POST['ym'];

$fb=$_POST['fb'];

$handphone=$_POST['handphone'];

$tujuan=$_POST['tujuan'];

$edukasi=$_POST['edukasi'];

$pekerjaan=$_POST['pekerjaan'];
$dpn=$_POST['dpn'];
$blkng=$_POST['blkng'];
$path="img/user";


$random_digit=rand(0000,9999);
$namabaru = $random_digit. "_" .  $pointke . "_" . date("Y-m-d") . ".jpg" ;
$path = $path . "/" .$namabaru; //generate the destination path
			
//cek duplicate di database


if ($load_deskr = $mysqli->prepare("SELECT jabatan FROM rm_biodata  where id_user  = ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('s', $user_id ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($desk );

				
					   $load_deskr->fetch();
					   
					    if($load_deskr->num_rows == 1) {
						$ganda= true ; } 
						else { $ganda=false ; }
					
					}
					   

if (!$ganda ) {

			if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_biodata (id_user, jabatan, alamat, email, ym, fb, handphone, tujuan, edukasi, pekerjaan, path  ) VALUES (?,?,?,?,?, ?, ? ,? , ? ,? ,?)")) {    
		   $insert_stmt->bind_param('isssssssiss', $user_id ,$jabatan, $alamat,$email, $ym, $fb , $handphone , $tujuan , $edukasi , $pekerjaan , $path  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   echo "Sukses ";

			}
		
}else {


	if ($insert_stmt = $mysqli->prepare("UPDATE rm_biodata SET  jabatan = ? , alamat = ? , email = ? ,ym = ? ,fb = ? , handphone = ? , tujuan = ? , edukasi = ? , pekerjaan = ? ,dpn =? ,blk=?  where id_user= ?")) {    
		   $insert_stmt->bind_param('sssssssisssi', $jabatan, $alamat, $email, $ym, $fb , $handphone , $tujuan , $edukasi , $pekerjaan , $dpn ,$blkng, $user_id ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	   echo "Sukses";
	}




}		
		
		/*
			if(move_uploaded_file($_FILES["filed"]['tmp_name'],$path)) { //upload the file
			echo "suksse";
			}	else{echo "gagal";}
			//upload poto*/
			
	$Activity->Insert_activity(5, $user_id , 'profile','./panel.php?module=profile&id=' . $user_id);		
}

// kirim nilai balik

//modul profil
if ($modul=='profil' AND $act=='add_edukasi')   {

$edukasi=$_POST['edukasi'];
$awal=$_POST['awal'];
$akhir=$_POST['akhir'];
$tipe=$_POST['tipe'];


	if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_sub_biodata (id_user, tipe, mulai, akhir, nama) VALUES (?,?,?,?,?)")) {    
			   $insert_stmt->bind_param('iiiis', $user_id ,$tipe, $awal,$akhir, $edukasi  ); 
			   // Execute the prepared query.
			   $insert_stmt->execute();
			
	
	$Activity->Insert_activity(5, $user_id , 'education','./panel.php?module=profile&id=' . $user_id);	
	}
	//refresh page
	echo "<script type='text/javascript'>
        $(document).ready(function () {
   
   	window.location.reload();
	
	});
    </script>";

}


//modul profil
if ($modul=='profil' AND $act=='add_email_integrasi')   {

$username=$_POST['username'];
$passwords=$_POST['passwords'];

$kpi->add_email_integeration($user_id ,$username,$passwords) ;

echo     "<script type='text/javascript'>
        $(document).ready(function () {
            window.location.reload();
           
		   
        });
    </script>"	;

}

if ($modul=='profil' AND $act=='dell_email_integrasi')   {


$kpi->dell_email_integeration($user_id);

echo     "<script type='text/javascript'>
        $(document).ready(function () {
            window.location.reload();
           
		   
        });
    </script>"	;

}

//modul profil
if ($modul=='profil' AND $act=='add_ogs_integrasi')   {

$username=$_POST['username'];
$passwords=$_POST['passwords'];

$kpi->add_ogs_integeration($user_id ,$username,$passwords) ;

echo     "<script type='text/javascript'>
        $(document).ready(function () {
            window.location.reload();
           
		   
        });
    </script>"	;

}

if ($modul=='profil' AND $act=='dell_ogs_integrasi')   {


$kpi->dell_ogs_integeration($user_id);

echo     "<script type='text/javascript'>
        $(document).ready(function () {
            window.location.reload();
           
		   
        });
    </script>"	;

}






if(isset($_POST['whiteboard'])) {


$whiteboard=$_POST['whiteboard'];
$whiteboard = preg_replace('/(<\/[^>]+?>)(<[^>\/][^>]*?>)/', '$1 $2', $whiteboard);
$whiteboard = strip_tags($whiteboard);


$tipe=2;
$tanggal = date("Y-m-d H:i:s");
$r_tanggal = "" ;
$ke= "";
$read= "";


	if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_message (message, dari, ke, tipe, r_read, tanggal, r_tanggal ) VALUES (?,?,?,?,?,?,?)")) {   
			   $insert_stmt->bind_param('sisisss',$whiteboard, $user_id, $ke ,$tipe, $read,$tanggal, $r_tanggal  ); 
			   // Execute the prepared query.
			   $insert_stmt->execute();
			   $id_akhir= $insert_stmt->insert_id;
			   
			   $whiiitee = substr($whiteboard,0,40).'...';
			   
			   $Activity->Insert_activity(15, $user_id ,$whiiitee,'./panel.php?module=whiteboard');	
			   
//whiteboard notification			   
	if ($nott_whiteboard==true){

	$anggotas=$Users->get_users();
		//require("../newsmtp/smtp.php");
		//require("../newsmtp/sasl.php");
		//$smtp=new smtp_class;

		foreach ($anggotas as $anggota ){
		
				$to= $anggota['email'] ;
				
				$from="rms@bki.co.id";
				
				
				$subject = "user id " . $nama_user. " Post In  WhiteBoard RMS INFO";
				$message = $whiteboard.  "<p>
				Sent From RMS BKI [ <a href='http://rnd.bki.co.id/rms/' > http://rnd.bki.co.id/rms/ </a> ] 
				";
				//include('../newsmtp/smtpwork.php');
		
		$toemailbyiduser=$toemailbyiduser . "," . $anggota['id_user'] ;		
				
		}
		$toemailbyiduser=substr($toemailbyiduser, 1); // hilangkan , dalam huruf pertama
		
		$obj->sendEmail($from,$toemailbyiduser,$message,$subject);	
				}			   
			   

	}



//kirim nilai baalik

 echo "<div class='separate' id='id-$id'><a  href='panel.php?module=profile&id=$user_id'><img src='$profil_pic'style='height:60px;' /></a> <div class='tanggal'>  $tanggal </div><p>$whiteboard</p></div>"; 
		

}

if(isSet($_POST['lastmsg'])) {

$lastmsg=$_POST['lastmsg'];

if ($load_deskr = $mysqli->prepare("SELECT r.id , r.message, r.dari,  r.tipe, r.tanggal,u.path  FROM rm_message r inner join rm_biodata u on u.id_user=r.dari where r.tipe = '2' AND r.id < ? order by id DESC LIMIT 5")) {   
				   // Execute the prepared query.
						 $load_deskr->bind_param('i', $lastmsg ); 
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($id, $message, $dari,$tipe,$tanggal,$alamat );
					   $row_cnt = $load_deskr->num_rows;
					  $emboh = $load_deskr->num_rows;
				
// cek bila sudah habiss
				if($emboh !=0 ) {
					   while($load_deskr->fetch()){
					   echo "<div class='separate' id='id-$id'><a  href='panel.php?module=profile&id=$dari'><img src='$alamat'style='height:60px;' /></a> <div class='tanggal'>  $tanggal </div><p>$message</p></div>"; 
				
		
						}
						echo "<div id='more'><a  id='$id' class='load_more' href='#'>more</a>  </div>";
				}		
				else {
				
				echo "<div id='more'><a  id='end' class='load_more' href='#'>no more post</a>  </div>";

				}		
					}


}

//del edukasi skill, etc
if ($modul=='del_edu' AND $act=='del')   {
$id_edu=$_POST['id'];



	if ($insert_stmt = $mysqli->prepare("DELETE FROM rm_sub_biodata  where id  = ?  LIMIT 1")) {   
			   $insert_stmt->bind_param('i',$id_edu  ); 
			   // Execute the prepared query.
			   $insert_stmt->execute();
			   
			   

	}
	//refresh page
   echo "<script type='text/javascript'>
        $(document).ready(function () {
   
   	window.location.reload();
	
	});
    </script>";


}



if ($modul=='wisdom' AND $act=='add')   {

$tanggal = date("Y-m-d");
$isi=$_POST['isi'];


	if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_wisdom (isi, tanggal, id_user  ) VALUES (?,?,?)")) {   
			   $insert_stmt->bind_param('ssi',$isi, $tanggal,  $user_id  ); 
			   // Execute the prepared query.
			   $insert_stmt->execute();
			   $id_akhir= $insert_stmt->insert_id;
			   
			    $whiiitee = substr($isi,0,40).'...';
				
			   $Activity->Insert_activity(16, $user_id ,$whiiitee,'./panel.php?module=wisdom');	

	}
	
//kirim nilai balik

	if ($load_tipe= $mysqli->prepare("SELECT id , isi, tanggal , id_user  FROM  rm_wisdom  ")) {
				   // Execute the prepared query.
					   $load_tipe->execute();
					   $load_tipe->bind_result($id,$isi,$tanggal , $user );
					   $buang=array();
					   while($load_tipe->fetch()){ 
					   
					   
					   echo " $tanggal <p> $isi <p> $user <hr> " ;
					   
					   
					    }	   	   
				}	     


}

if ($modul=='diary' AND $act=='delete')   {

$id=$_POST['id_diary'];
$user_id = $_SESSION['user_id'];


$kpi->delete_kpi($id,$user_id);

echo     "<script type='text/javascript'>
        $(document).ready(function () {
            window.location.reload();
           
	
		   
        });
    </script>"	;


}

if ($modul=='diary' AND $act=='close')   {

$id=$_POST['id_diary'];
$user_id = $_SESSION['user_id'];


$tanggal=$_POST['tanggal'];
$tanggal=date("Y-m-d", strtotime($tanggal));

$kpi->close_kpi_id($id, $tanggal,$user_id);

echo     "<script type='text/javascript'>
        $(document).ready(function () {
            window.location = '../rms/panel.php?module=diary'; 
           
	
		   
        });
    </script>"	;


}

if ($modul=='diary' AND $act=='show')   {

$user_id = $_POST['user'];
$stat ="user=".  $user_id ;
if (!isset($user_id) & ($user_id=="")){
$user_id = $_SESSION['user_id'];
$stat ="" ;
}

	$year= $_POST['tahun'];
	$month= $_POST['bulan'];
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
	echo "<a href='people/ex_down.php?bul=$month&amp;yr=$year&$stat'>download</a>" ;
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Kegiatan</th>
											<th>Jenis</th>
											<th>Group</th>
											<th>Start</th>
											<th>Finish</th>
											<th>Surat</th>
											<th>Action</th>
											
											
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($kpiss as $kpis) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td title='$kpis[keterangan]'>" . $kpis['name'].  " </a></td>
									<td >". $kpis['jenis']. "</td>
									<td>" . $kpis['Grup'] . "</td>
									<td>" . $kpis['star'] ."</td>
									<td>". $kpis['finish'] ."</td>
									<td>". $kpis['surat']. "</td>
									<td><a href=# onclick='delt($kpis[id_diar]);'>Delete </a>". " |  ". "<a href='#'  onclick=". "show_update(" . $kpis[id_diar] ."); > Close </a> </td>
									
									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table><hr>";
	
	echo "<script type='text/javascript'>

        $(document).ready(function () {
            


			$('.datatable').dataTable();

			

        });
</script>" ;

	




}

if(isSet($_POST['activity'])) {

$lastmsg=$_POST['activity'];

$aktivitys=$Activity->get_activity2($lastmsg);
		

		$emboh=$Activity->get_number_activity($lastmsg);			  

				
// cek bila sudah habiss
				if($emboh !=0 ) {
					 foreach ($aktivitys as $aktivity) {
				
					$sesuaiformat=$Activity->format_tanggal($aktivity['date_hour']);
				
					  echo "<div title='$aktivity[nick]' class='friends_area'><img src='$aktivity[path]' height='45' style='float:left;' alt=''> 
		   					<label style='float:left' class='name'>
		   					<b>$aktivity[nick] </b><br> <span class='aktifitas'> $aktivity[name_activity] </span> <span style='padding: 4px 10 30px 18px; width:30' class='db-ico ico-$aktivity[icon]'> </span> <a class='terusan-$aktivity[icon]' style='font-weight:bold;' href='$aktivity[link]'> $aktivity[object] </a><br>
							<span class='tanggalfeed'>
		    				$sesuaiformat </span></label></div>";
					  
					  
					  }
						
						
						
						echo "<p><div id='more'><a  id='$aktivity[id]' class='load_more' href='#'>more</a>  </div>";
				}		
				else {
				
				echo "<p><div id='more'><a  id='end' class='load_more' href='#'>no more post</a>  </div>";

				}		
					


}

if(isSet($_POST['activity_feed'])) {

$lastmsg=$_POST['activity_feed'];

   $lastaktifiti=$Activity->get_last_activity();
   foreach ($lastaktifiti as $lastaktifit) {
   
   $idlast= $lastaktifit['id'];
   }
   
$aktivitys=$Activity->get_lastactivity_activity($lastmsg);		

echo "<input type='hidden' id='updatee' name='updatee' class='updatee' value=$idlast />";

foreach ($aktivitys as $aktivity) {
				$sesuaiformat=$Activity->format_tanggal($aktivity['date_hour']);
		
					  echo "<div title='$aktivity[nick]' class='friends_area'><img src='$aktivity[path]' height='45' style='float:left;' alt=''> 
		   					<label style='float:left' class='name'>
		   					<b>$aktivity[nick] </b><br> <span class='aktifitas'> $aktivity[name_activity] </span> <span style='padding: 4px 10 30px 18px; width:30' class='db-ico ico-$aktivity[icon]'> </span> <a class='terusan-$aktivity[icon]' style='font-weight:bold;' href='$aktivity[link]'> $aktivity[object] </a><br>
							<span class='tanggalfeed'>
		    				$sesuaiformat </span></label></div>";
					  
					  
					  }	


}


if ($modul=='wisdom' AND $act=='show')   {

if ($load_tipe= $mysqli->prepare("SELECT rm_wisdom.id , rm_wisdom.isi, rm_wisdom.tanggal , rm_wisdom.id_user , og_user.nama  FROM  rm_wisdom JOIN og_user ON og_user .id_user=rm_wisdom.id_user order by rand() Limit 1 ")) {
				   // Execute the prepared query.
					   $load_tipe->execute();
					   $load_tipe->bind_result($id,$isi,$tanggal , $user , $nama );
					   $buang=array();
					   while($load_tipe->fetch()){ 
					   $tanggal=strtotime($tanggal);
					   $tanggal=date('l jS \of F Y',$tanggal);
					   
					   
					   echo " <b>$tanggal <b><p> $isi <p> <b>--$nama <b><hr> " ;
					   
					   
					    }	   	   
				}

}



