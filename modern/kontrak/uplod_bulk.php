<?php

$kontraks=$kontrak->get_kontrak();
	$salting = $_SESSION['salt'];



if(isset($_GET['error'])) { 
   
   echo 'Error Logging In!';
   
   }

if($salting < 2) {
	
 echo "<script type='text/javascript'>
 <!-- 
 window.location = 'panel.php?module=home' //
 --> </script>" ;
 die;
	}else {$muncul_tomb=true;}
	
	
	if(isset($_GET['del'])) { 

	$ids=$_GET['ids'];
	$gambars = $drawing->get_proj_gambar_temp_almat($ids);
	if (file_exists($gambars)) {
   	unlink($gambars);
	}
   $drawing->Delete_proj_gambar_temp($ids);
   
   }

?>

<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>

<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="css/themes/base/custom.css" rel="stylesheet" type="text/css" />


            <div class="box round first">
                <h2>
                    Upload on Bulks </h2>
                <div class="block">
                    <p class="start">
					<button class="btn btn-yellow" onclick="location.href='panel.php?module=u_bulkss'"> Bulk Editing </button>
					
					<button class="btn btn-green" onclick="location.href='panel.php?module=u_bulksss'"> Moderation Bulk </button> 
                    <p class="start">Upload File Max 40 M or 25 files at each time upload
                      <?php 
					   if (isset($_POST['select2'])and ($_POST['select2']!= "" ) ){

//get var from post


$kontrak = $_POST['select2'] ;



$alamat="data/" . $kontrak  ;

if(!is_dir($alamat)){
	   mkdir($alamat, 0700);
 }
$allowedExts = array("pdf", "PDF");

						
						for($j=0; $j < count($_FILES["item_file"]['name']); $j++) { //loop the uploaded file array
						$filen = $_FILES["item_file"]['name']["$j"]; //file name
						
						$random_digit=rand(0000,9999);
						$namabaru = $random_digit. "_" .  $no_gam1 . "_" . $no_gam . _ . date("Y-m-d") . ".pdf" ;
						$path =$alamat . "/" .  $namabaru;
						
						$temp = explode(".", $_FILES["item_file"]["name"]["$j"]);
						$extension = end($temp);
					
					
						$nama_file=$_FILES["item_file"]['name']["$j"] ;
						if (($_FILES['item_file']['type']["$j"] == "application/pdf") or (in_array($extension, $allowedExts))){
						
						if(move_uploaded_file($_FILES["item_file"]['tmp_name']["$j"],$path)) { //upload the file
							
							$no_gamb="";
							$judul="";
							$tipe="";
							$doc_tipe=0;
							$tanggal=date("Y-m-d");
										 
						//masukan ke database uploadmaster
						
							   $drawing->insert_data_gambar_temp1($_FILES["item_file"]['name']["$j"], $path, $no_gamb, $judul , $tipe,$kontrak,$doc_tipe,$tanggal) ; 
						}
						}
						
						}
						
/* //upload administrasi
  
			
			//buat pathnya berdasarkan nama dan jenis rules tahun
			$path= "master/";
			$path = $path . $JenisTechnical_paper[$tipe];
			if(!is_dir($path)){mkdir($path, 0700); }//periksa dan buat masing2 foldel dalam path exist.
			
			$path = ($path . "/" . $part_arrays[$kategori]) ;
			if(!is_dir($path)){mkdir($path, 0700); }//periksa dan buat masing2 foldel dalam path exist.
			
			$path = ($path . "/" .  $awalan_vol. " " . $judul ) ;
			if(!is_dir($path)){mkdir($path, 0700); }//periksa dan buat masing2 foldel dalam path exist.
			
			$path = ($path . "/" . $tahuun ) ;
			if(!is_dir($path)){mkdir($path, 0700); }//periksa dan buat masing2 foldel dalam path exist.
			
			//copykan kesana.
			$tanggal = date("Y-m-d");
						
						$alamat = $path ; 
						
						
						for($k=0; $k < count($_FILES["item_file2"]['name']); $k++) { //loop the uploaded file array
						$filen = $_FILES["item_file2"]['name']["$j"]; //file name
						
						$random_digit=rand(0000,9999);
						$namabaru = $random_digit. "_" .  $judul . "_" . $tahuun  . ".mas" ;
						$path =$alamat . "/" .  $namabaru;
					
					
						$nama_file=$_FILES["item_file2"]['name']["$k"] ;
						
						if(move_uploaded_file($_FILES["item_file2"]['tmp_name']["$k"],$path)) { //upload the file
							
							$tipes=2;			 
						//masukan ke database uploadmaster
							   if ($insertt_stmt = $mysqli->prepare("INSERT INTO rm_upload_tanpa_rms ( 	id_rules_pub, tipe 	,  nama, path , tanggal ) VALUES (?,?, ?, ?, ?)")) {    
							   $insertt_stmt->bind_param('iisss', $id_akhir,$tipes, $nama_file , $path , $tanggal ); 
							   // Execute the prepared query.
							   $insertt_stmt->execute();
					
							   }
						}
						
						} */
				
						
						
//input databse file




} else {}









function findexts ($filename) 
 { 
 $filename = strtolower($filename) ; 
 $exts = split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
 } 


 
?>
                    <form method="post" enctype="multipart/form-data" name="form1" action="panel.php?module=u_bulks" >

<table width="101%" bordercolor="#000000" class="form">
  <tr>
    <td width="15%"><label>Project On </label></td>
    <td width="14%"><label>
      <select name="select2" id="select2" required>
	  <option></option>
	  <?php
	  
	  foreach ($kontraks as $kontrak) {
	  echo "<option value='". $kontrak['id'] . "'>" . $kontrak['nama'] . "</option>"; 
	   $Project_name[$kontrak['id']]=$kontrak['nama'];
	  }
	  
	  ?>
	  
      </select>
    </label></td>
    <td width="11%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="14%">&nbsp;</td>
    <td width="36%">&nbsp;</td>
  </tr>
  <tr>
    <td><label>Pdf Document Or Drawing </label></td>
    <td><input type="file" name="item_file[]" multiple size="100" required /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td> <button class="btn-icon btn-grey btn-plus" onClick="formSubmit()"><span></span> Add </button></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
					   
                </div>
            </div>
			
			 <div class="box round">
                <h2>
          			List Upload Document Or Drawing </h2>
                <div class="block">
<?php 


$get_draws=$drawing->get_proj_gambar_temp(0,30);
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Id</th>
											<th>File Name</th>
											<th>No Drawing</th>
											<th>Title</th>
											<th>Tipe</th>
											<th>Doc Tipe</th>
											<th>Pid</th>
											<th>Action</th>
																						
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($get_draws as $get_draw) {
	$z=$get_draw['tipe'];
	
	$nam_proj=$Project_name[$get_draw['kontrak_id']];
	

	
	 echo 							"<tr class='odd gradeX'>
									<td >" . $no . "</td>
									<td > <a href='kontrak/reads.php?module=read&kon=$proj_id&gam=$get_draw[id]'" .  "target='_blank'>" .$get_draw['id'] ."</a> " .   "</td>
									<td ><a href='kontrak/reads.php?module=read&kon=$proj_id&gam=$get_draw[id]'" .  "target='_blank'>" . $get_draw['nama_file'] . "</a></td>
									<td >". $get_draw['no_gamb'] . " </td>
									<td >".  $get_draw['judul']. "</td>
									<td>" . $get_draw['tipe'] . "</td>
									<td>" . $get_draw['doc_tipe'] ."</td>
									<td>" . $nam_proj."</td>
									<td><a href='panel.php?module=u_bulks&del=y&ids=$get_draw[id]'>"  . Delete . " </a></td>								
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table>";




?>

					</div>
					</div>
			
       