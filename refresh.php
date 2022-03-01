<?php

include "sis32/db_connect.php";

include("class/init.php");
date_default_timezone_set('Asia/Jakarta');

$modul = isset($_POST['modul']) ;
$act = isset($_POST['act']) ;


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





?>