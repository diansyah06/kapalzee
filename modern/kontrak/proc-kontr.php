<?php
include "../functions.php";
sec_session_start();
require '../class/init2.php';
include "../sis32/db_connect.php";
if(login_check ($mysqli) == false) {
  echo "<link href='../pengaturan/adminstyle.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
die;}

$modul = $_POST['modul'] ;
$act = $_POST['act'] ;

if ($modul=='kontrak' AND $act=='add')   {

	
	$id_kontrak=$_POST['id_kontrak'] ; 
	$class_id=$_POST['class_id']; 
	$name=$_POST['name'];
	$tipe=$_POST['tipe'] ;
	$location= $_POST['location'];
	$builder=$_POST['builder'];
	$submited=$_POST['submited'];
	$due_date=$_POST['due_date'];
	$due_date = date("Y-m-d", strtotime($due_date));
	$tanggal= date("Y-m-d");
	$status=0;

	$kontrak->Create_kontrak($id_kontrak, $class_id, $location, $builder, $submited, 0, $tanggal, $name, $status, $due_date, '0000:00:00',$tipe);
	$thelast = $drawing->lastInsertId();

	$alamat="../data/". $thelast;
	if(!is_dir($alamat)){
	   mkdir($alamat, 0700);
 }
 
	$file = fopen("../data/". $thelast."/index.php","w");
	echo fwrite($file,"error!");
	fclose($file);

}


if ($modul=='kontrak' AND $act=='edit')   {

	$id_kon=$_POST['id_kon'] ; 
	$id_kontrak=$_POST['id_kontrak'] ; 
	$class_id=$_POST['class_id']; 
	$name=$_POST['name'];
	$tipe=$_POST['tipe'] ;
	$location= $_POST['location'];
	$builder=$_POST['builder'];
	$submited=$_POST['submited'];
	$due_date=$_POST['due_date'];
	$due_date = date("Y-m-d", strtotime($due_date));
	$tanggal= date("Y-m-d");
	$status=0;

	$kontrak->edit_kontrak($id_kontrak, $class_id, $location, $builder, $submited, 0, $tanggal, $name, $status, $due_date, '0000:00:00',$tipe ,$id_kon );

}

if ($modul=='gambar' AND $act=='delall')   {

		$id_gamb = $_POST['id_gamb'] ;
		$code = $_POST['code'] ;
		date_default_timezone_set('Asia/Bangkok');
		$current_date = Date("Y-m-d\ H:i:s\ "); 
		$id_kon = $code ;
		$user_id = $_SESSION['user_id'];

		
		
		
			$get_jam_tang=$drawing->get_proj_gambar_id($id_gamb);
			foreach ($get_jam_tang as $get_jam_tan){
			$tangg=$get_jam_tan['tanggal'] ;
			$repl= substr($get_jam_tan['judul'], 0, 100);
			}
			
			
				//hapus gambar
		//cek 1jam belum
		
			if ($drawing->cek_waktu_kurang1jam($tangg,$current_date)) {
			
			$drawing->delete_gam($id_gamb,$id_kon) ; //del gambar
			$drawing->Delete_All_revisi_draw($id_gamb  , $id_kon); // del revisi
			
			$comment->insert_comment_log('Menghapus Gambar : <span class=error > ' . $repl . '</span> -..' , $id_gamb, $id_kon, $current_date ,$user_id);

			}else {
			
					if ($users->cek_man_user($user_id)){
		
						if ($users->Get_akses_kont_id($user_id,$id_kon)){
						
						$drawing->delete_gam($id_gamb,$id_kon) ; //del gambar
						$drawing->Delete_All_revisi_draw($id_gamb  , $id_kon); // del revisi	
						$comment->insert_comment_log('Menghapus Gambar : <span class=error > ' . $repl . '</span> -..' , $id_gamb, $id_kon, $current_date ,$user_id);
					
						} else {
							echo "<script> alert('failed to delete, you are not in charge on this project') ;</script>";
						
							}
					
					}else {
					
					echo "<script> alert('failed to delete, delete only < 1 hour') ;</script>";
					
					}
			}
			
			
		

		
		
	}
	
	
	if ($modul=='gambar_rev' AND $act=='del_rev')   {

		$id_gamb = $_POST['id_gamb'] ;
		$code = $_POST['code'] ;
		date_default_timezone_set('Asia/Bangkok');
		$current_date = Date("Y-m-d\ H:i:s\ "); 
		$id_kon = $code ;
		$user_id = $_SESSION['user_id'];

		
		
		
			$get_jam_tang=$drawing->get_histori_gambar_id($id_gamb,$id_kon) ;
			foreach ($get_jam_tang as $get_jam_tan){
			$tangg=$get_jam_tan['tanggal'] ;
			$repl= substr($get_jam_tan['id_project_gamb'], 0, 100);
			}
		
		
		//hapus commnet
		//cek 1jam belum
		
			if ($drawing->cek_waktu_kurang1jam($tangg,$current_date)) {
			
			
			
			$drawing->Delete_id_revisi_draw($id_gamb  , $id_kon); // del revisi
			
			$comment->insert_comment_log('Menghapus Revisi Gambar : <span class=error > ' . $repl . '</span> -..' , $id_gamb, $id_kon, $current_date ,$user_id);

			}else {
			echo "<script> alert('failed to delete, delete only < 1 hour $tangg ') ;</script>";
			
			}
	}
	
	
	if ($modul=='gambar_rev')   {//nilai balik
	
	$proj_id=intval($_POST['code']);
	$draw_id=intval($_POST['id_gam_induk']);
	$get_draws=$drawing->get_proj_gambar_id($draw_id);
	
	$get_hist_draws=$drawing->get_histori_gambar($draw_id,$proj_id) ;
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Nama </th>
											<th>revisi</th>
											<th>Masuk</th>
											<th>Drawing</th>
											<th>Open</th>
											<th>Action</th>
																						
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($get_draws as $get_draw) {
	$nama_gam=$get_draw['judul'] ;
	$no_gam=$get_draw['no_gambar'] ;
	}
	foreach ($get_hist_draws as $get_hist_draw) {
	$z=$get_draw['tipe'];
	if ($get_hist_draw['alamat']=="none"){ $edraw="No avaible" ; }else { $edraw="Avaible" ; }
	
	$perant=$proj_id . "," . $get_hist_draw['id']  ;
	
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td > " . $no_gam. "</td>
									<td >". $nama_gam . " </a></td>
									<td >".  $get_hist_draw['revisi']. "</td>
									<td>" . $get_hist_draw['tanggal'] . "</td>
									<td>" . $edraw . "</td>
									<td>" . "<a href='kontrak/read.php?module=re&kon=$proj_id&gam=$get_hist_draw[id]'" .  "target='_blank'>" . " Open</a> " ."</td>
									<td> <a href='#'  onclick=". "fung_del_gambar_rev(" . $perant ."); > Delete </a> "  . "</td>									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table>";
	
	
	
	
	}
	if ($modul=='gambar')   {//nilai balik
	
	
	$proj_id=intval($_POST['code']);
	$get_draws=$drawing->get_proj_gambar($proj_id);
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Nama </th>
											<th>Tipe Gambar</th>
											<th>Masuk</th>
											<th>Open</th>
											<th>Delete</th>
																						
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($get_draws as $get_draw) {
	$z=$get_draw['tipe'];
	
	$perant=$get_draw[id_kontrak] . "," . $get_draw['id']  ;
	
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td > <a href='panel.php?module=ed_cek&point=1&id=". $proj_id. "&mod=2&draw=$get_draw[id] '>". $get_draw['no_gambar'] . " </a></td>
									<td >". $get_draw['judul'] . " </a></td>
									<td >".  $tipe_gam[$z]. "</td>
									<td>" . $get_draw['tanggal'] . "</td>
									<td>" . "<a href='kontrak/read.php?module=read&kon=$proj_id&gam=$get_draw[id]'" .  "target='_blank'>" . "Open</a> " ."</td>
									<td> <a href='#'  onclick=". "fung_del_gambar(" . $perant ."); > Delete </a> "  . "</td>									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table>";
	
	
	
	}
if ($modul=='kontrak' )   {
//kirim nilai table balik
$kontraks=$kontrak->get_kontrak();
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Id Kontrak</th>
											<th>Nama </th>
											<th>Location</th>
											<th>Status</th>
											<th>Start Date</th>
											<th>Due Date</th>
											<th>Finish</th>
											<th>Link</th>
											
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($kontraks as $kontrak) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td ><a href='panel.php?module=ed_kon&point=2&id=". $kontrak['id']. "'>". $kontrak['id_kontrak'] .  " </a></td>
									<td >". $kontrak['nama']. "</td>
									<td>" . $kontrak['lokasi'] . "</td>
									<td>" . $kontrak['status'] ."</td>
									<td>". $kontrak['dates'] ."</td>
									<td>". $kontrak['due_date']. "</td>
									<td>". $kontrak['finish']. "</td>
									<td>" . $kontrak['linker'] . "</td>
									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table><hr>";

}




//Refresh table

echo "<script type='text/javascript'>

        $(document).ready(function () {
            
			setupLeftMenu();
            $('.datatable').dataTable();
			setSidebarHeight();
			

        });
</script>" ;


?>