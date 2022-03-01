<?php

include("../sis32/db_connect.php");
include "../functions.php";
//get var from post
sec_session_start();

include("../class/init2.php");

$modul = $_POST['modul'] ;
$act = $_POST['act'] ;
$user_id = $_SESSION['user_id'];

//modul kamusssss
if ($modul=='kamus' AND $act=='add')   {
$englisha = $_POST['english'] ;
$indonesiaa = $_POST['indonesia'] ;
$tanggal = date("Y-m-d");

			if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_kamus (indonesia, english , user , tanggal ) VALUES (?, ?, ? ,?)")) {    
		   $insert_stmt->bind_param('ssis', $indonesiaa ,$englisha, $user_id,$tanggal  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
			}
			$statement = "SELECT  rm_kamus.id, rm_kamus.indonesia, rm_kamus.english, rm_kamus.user , rm_kamus.tanggal , og_user.nama  FROM rm_kamus JOIN og_user ON rm_kamus.user=og_user.id_user Order by english ASC" ;
					
						   if ($load_stmt = $mysqli->prepare($statement)) {   	
							// Execute the prepared query.
						   $load_stmt->execute();
						   $load_stmt->bind_result($id_kamus, $indonesia , $english , $id_user , $tanggal , $user  );
						   $no=1;
						   
						   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Indonesia </th>
											<th>English</th>
											<th>User</th>
											<th>Date Input</th>
											<th> Status</th>
										</tr>
									</thead>
									<tbody>";
				
					while($load_stmt->fetch()){
						if ($id_user == $user_id ){
						$kond="<a href='#' onclick='fung_del_kamus($id_kamus);'>Hapus</a>" ;}else {$kond="" ;}
						 echo "<tr class='odd gradeX'>
									<td >$no</td>
									<td >$indonesia</td>
									<td >$english</td>
									<td>$user</td>
									<td>$tanggal</td>
									<td>" . $kond ." </td></tr>";
									
									$no++ ;
							}
							echo "</tbody>
								</table> <script type='text/javascript'>

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>";



//log activity				
$Activity->Insert_activity(25, $user_id , $englisha,'./panel.php?module=kamus');

								
					}
				//End Load Part.........
}

// kirim nilai balik




if ($modul=='kamus' AND $act=='del')   {
$id = $_POST['id'] ;


				if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_kamus  where id =?  AND user = ? LIMIT 1")) {   
				 $delet_stmt->bind_param('ii', $id , $user_id  ); 
			   // Execute the prepared query.
				 $delet_stmt->execute();
				 
				 $Activity->Insert_activity(26, $user_id , 'some words','./panel.php?module=kamus');
				 }
		
		
$statement = "SELECT  rm_kamus.id, rm_kamus.indonesia, rm_kamus.english, rm_kamus.user , rm_kamus.tanggal , og_user.nama  FROM rm_kamus JOIN og_user ON rm_kamus.user=og_user.id_user Order by english ASC" ;
					
						   if ($load_stmt = $mysqli->prepare($statement)) {   	
							// Execute the prepared query.
						   $load_stmt->execute();
						   $load_stmt->bind_result($id_kamus, $indonesia , $english , $id_user , $tanggal , $user  );
						   $no=1;
						   
						   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Indonesia </th>
											<th>English</th>
											<th>User</th>
											<th>Date Input</th>
											<th> Status</th>
										</tr>
									</thead>
									<tbody>";
				
					while($load_stmt->fetch()){
						if ($id_user == $user_id ){
						$kond="<a href='#' onclick='fung_del_kamus($id_kamus);'>Hapus</a>" ;}else {$kond="" ;}
						
						 echo "<tr class='odd gradeX'>
									<td >$no</td>
									<td >$indonesia</td>
									<td >$english</td>
									<td>$user</td>
									<td>$tanggal</td>
									<td>" . $kond ." </td></tr>";
									
									$no++ ;
							}
							echo "</tbody>
			</table><script type='text/javascript'>

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>";
				
								
					}
				//End Load Part.........		
					
		}

// kirim nilai balik


if ($modul=="load_managing_arsip")   {

$user_id = $_SESSION['user_id'];
				$previl = cekprevil($mysqli) ;
				
				$user_id = 12 ;
				

				$statement = "SELECT  og_user.nama, rm_paper.Nama, rm_cekpoint.id_cek, rm_cekpoint.tahun, rm_cekpoint.user, rm_cekpoint.duedate , rm_ruleslist.Rules, rm_ruleslist.tipe, rm_ruleslist.Part , rm_ruleslist.volume, rm_cekpoint.preparation, rm_cekpoint.teamup, rm_cekpoint.ref, rm_cekpoint.wg, rm_cekpoint.konsenering, rm_cekpoint.cetak, rm_cekpoint.karakter, rm_cekpoint.adminis, rm_cekpoint.komite, rm_cekpoint.scope, rm_cekpoint.master, rm_cekpoint.publikasi, rm_cekpoint.close 	  FROM rm_cekpoint LEFT JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules 
LEFT JOIN rm_paper ON rm_ruleslist.tipe=rm_paper.id_paper
LEFT JOIN og_user ON rm_cekpoint.user=og_user.id_user where rm_cekpoint.closeby!=0 order by rm_cekpoint.id_cek desc 

" ;
				
	
				
				
						   if ($load_stmt = $mysqli->prepare($statement)) {   	
							// Execute the prepared query.
						   $load_stmt->execute();
						   $load_stmt->bind_result($leader, $tipee, $id_cek, $tahun , $user , $duedate , $namarules, $tipe ,$partt ,$volumee,$cek1,$cek2,$cek3,$cek4,$cek5,$cek6,$cek7,$cek8,$cek9,$cek10,$cek11,$cek12,$cek13  );
						   
						   
						   
						   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Unique Code</th>
											<th>Type</th>
											<th>Technical Paper Name</th>
											<th>Part</th>
											<th>Vol</th>
											<th>Status</th>
											<th>Due</th>
											<th>Leader</th>
										</tr>
									</thead>
									<tbody>";
				   $no=1;
					while($load_stmt->fetch()){
					$nilaicek=array($cek1,$cek2,$cek3,$cek4,$cek5,$cek6,$cek7,$cek8,$cek9,$cek10,$cek11,$cek12,$cek13);
					
					$n=0;
					
					 foreach ($nilaicek as $isi) { if ($isi!="0000-00-00"){ $n=$n+1;} ;} 
					 $n=$n/13 * 100 ;
					 $n=number_format($n,0);
						 $tipe = $tipe - 1 ;
						 $part = $part -1 ;
						 $id_cek= sprintf ("%04d\n",   $id_cek);
						 echo "<tr class='odd gradeX'>
						 <td >$no</td>
									<td >$id_cek</td>
									<td >$tipee</td>
									<td >$namarules $tahun </td>
									<td>$partt</td>
									<td>$volumee</td>
									<td>$n %</td>
									<td>$duedate</td>
									<td>$leader</td></tr>";
									
									$no++ ;
							}
														echo "</tbody>
			</table><script type='text/javascript'>

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>";
				
								
					}
				//End Load Part.........



}


if ($modul=="project_inprogress")   {

$user_id = $_SESSION['user_id'];
				$previl = cekprevil($mysqli) ;
				
				$user_id = 12 ;
				

				$statement = "SELECT  og_user.nama, rm_paper.Nama, rm_cekpoint.id_cek, rm_cekpoint.tahun, rm_cekpoint.user, rm_cekpoint.duedate , rm_ruleslist.Rules, rm_ruleslist.tipe, rm_ruleslist.Part , rm_ruleslist.volume, rm_cekpoint.preparation, rm_cekpoint.teamup, rm_cekpoint.ref, rm_cekpoint.wg, rm_cekpoint.konsenering, rm_cekpoint.cetak, rm_cekpoint.karakter, rm_cekpoint.adminis, rm_cekpoint.komite, rm_cekpoint.scope, rm_cekpoint.master, rm_cekpoint.publikasi, rm_cekpoint.close 	  FROM rm_cekpoint LEFT JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules 
LEFT JOIN rm_paper ON rm_ruleslist.tipe=rm_paper.id_paper
LEFT JOIN og_user ON rm_cekpoint.user=og_user.id_user where rm_cekpoint.closeby=0 order by rm_cekpoint.id_cek desc 

" ;
				
	
				
				
						   if ($load_stmt = $mysqli->prepare($statement)) {   	
							// Execute the prepared query.
						   $load_stmt->execute();
						   $load_stmt->bind_result($leader, $tipee, $id_cek, $tahun , $user , $duedate , $namarules, $tipe ,$partt ,$volumee,$cek1,$cek2,$cek3,$cek4,$cek5,$cek6,$cek7,$cek8,$cek9,$cek10,$cek11,$cek12,$cek13  );
						   
						   
						   
						   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Unique Code</th>
											<th>Type</th>
											<th>Technical Paper Name</th>
											<th>Part</th>
											<th>Vol</th>
											<th>Status</th>
											<th>Due</th>
											<th>Leader</th>
										</tr>
									</thead>
									<tbody>";
				   $no=1;
					while($load_stmt->fetch()){
					$nilaicek=array($cek1,$cek2,$cek3,$cek4,$cek5,$cek6,$cek7,$cek8,$cek9,$cek10,$cek11,$cek12,$cek13);
					
					$n=0;
					
					 foreach ($nilaicek as $isi) { if ($isi!="0000-00-00"){ $n=$n+1;} ;} 
					 $n=$n/13 * 100 ;
					 $n=number_format($n,0);
						 $tipe = $tipe - 1 ;
						 $part = $part -1 ;
						 $id_cek= sprintf ("%04d\n",   $id_cek);
						 echo "<tr class='odd gradeX'>
						 <td >$no</td>
									<td >$id_cek</td>
									<td >$tipee</td>
									<td >$namarules $tahun </td>
									<td>$partt</td>
									<td>$volumee</td>
									<td>$n %</td>
									<td>$duedate</td>
									<td>$leader</td></tr>";
									
									$no++ ;
							}
														echo "</tbody>
			</table><script type='text/javascript'>

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>";
				
								
					}
				//End Load Part.........



}




?>


