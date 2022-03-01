<?php


	$salting = $_SESSION['salt'];



if(isset($_GET['error'])) { 
   
   echo 'Error Logging In!';
   
   }

if($salting < 5) {
	
 echo "<script type='text/javascript'>
 <!-- 
 window.location = 'panel.php?module=home' //
 --> </script>" ;
 die;
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
                    Description</h2>
                <div class="block">
                    <!-- paragraphs -->
                    <p class="start">
                        <img src="img/horizontal.jpg" alt="Ginger" class="right" />Lorem Ipsum is simply dummy
                        text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only
                        five centuries, but also the leap into electronic typesetting, remaining essentially
                        unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
                        Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum.</p>
                    <p>
                        It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point of using Lorem Ipsum is that it
                        has a more-or-less normal distribution of letters, as opposed to using 'Content
                        here, content here', making it look like readable English. Many desktop publishing
                        packages and web page editors now use Lorem Ipsum as their default model text, and
                        a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various
                        versions have evolved over the years, sometimes by accident, sometimes on purpose
                        (injected humour and the like).</p>
					 <p>
                        It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point of using Lorem Ipsum is that it
                        has a more-or-less normal distribution of letters, as opposed to using 'Content
                        here, content here', making it look like readable English. Many desktop publishing
                        packages and web page editors now use Lorem Ipsum as their default model text, and
                        a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various
                        versions have evolved over the years, sometimes by accident, sometimes on purpose
                        (injected humour and the like).</p>
					<p>
                        It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point of using Lorem Ipsum is that it
                        has a more-or-less normal distribution of letters, as opposed to using 'Content
                        here, content here', making it look like readable English. Many desktop publishing
                        packages and web page editors now use Lorem Ipsum as their default model text, and
                        a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various
                        versions have evolved over the years, sometimes by accident, sometimes on purpose
                        (injected humour and the like).</p>
                    
					</div>
 </div>

            <div class="box round">
                <h2>
                    Create New List Technical Paper </h2>
                <div class="block">
                    <p class="start">
<?php                       
					   if (isset($_POST['textfield'])and ($_POST['textfield']!= "" ) ){

//get var from post

$judul = $_POST['textfield'] ;
$tahuun = $_POST['textfield3'] ;
$tipe = $_POST['select2'] ;
$kategori = $_POST['select3'] ;
$volume = $_POST['textfield2'] ;

//insert database ruleList
if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_ruleslist (Rules, Tipe, Part, volume ) VALUES (?, ?, ?, ?)")) {    
		   $insert_stmt->bind_param('siii', $judul,$tipe, $kategori , $volume   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		  $id_akhir= $insert_stmt->insert_id; //last id
	}

//input database rule_pub
$sts=1; // publish
$link=0; // 0 karena tidak di buat dengan RMS
	if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_rulepub ( id_rules, nama, tahun, tipe, part, vol, link, status ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )")) {    
		   $insert_stmt->bind_param('isiiiiii',$id_akhir, $judul,$tahuun, $tipe, $kategori , $volume ,$link, $sts    ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   $id_akhir= $insert_stmt->insert_id; //last id
	}


//upload publikasi pdf

//cek panjang path 
					if (strlen($judul)> 65 ){ $judul=substr($judul, 0, 35) . "___" ;} // 



				if ($tipe==1) {									//Bila rules di tulis pakai angka romawi
						$awalan_vol= $nama_vol[$volume] ;		//Bila rules di tulis pakai angka romawi
				}else{$awalan_vol= "( Vol " . $volume . " )" ;}	////Bila lainnya di tulis pakai angka biasa		
			 
			 if ($tipe==3) {$awalan_vol= $nama_vol_G[$volume];}
			 
			
			//buat pathnya berdasarkan nama dan jenis rules tahun
			$path= "publish/";
			$path = $path . $JenisTechnical_paper[$tipe];
			if(!is_dir($path)){mkdir($path, 0700); }//periksa dan buat masing2 foldel dalam path exist.
			
			$path = ($path . "/" . $part_arrays[$kategori]) ;
			if(!is_dir($path)){mkdir($path, 0700); }//periksa dan buat masing2 foldel dalam path exist.
			
			$path = ($path . "/" . $awalan_vol . " " . $judul ) ;
			if(!is_dir($path)){mkdir($path, 0700); }//periksa dan buat masing2 foldel dalam path exist.
			
			$path = ($path . "/" . $tahuun ) ;
			if(!is_dir($path)){mkdir($path, 0700); }//periksa dan buat masing2 foldel dalam path exist.
			
			//copykan kesana.
			$tanggal = date("Y-m-d");
						
						$alamat = $path ; 
						
						
						for($j=0; $j < count($_FILES["item_file"]['name']); $j++) { //loop the uploaded file array
						$filen = $_FILES["item_file"]['name']["$j"]; //file name
						
						$random_digit=rand(0000,9999);
						$namabaru = $random_digit. "_" .  $judul . "_" . $tahuun  . "-" . $kategori . "_" . $volume . ".pdf" ;
						$path =$alamat . "/" .  $namabaru;
					
					
						$nama_file=$_FILES["item_file"]['name']["$j"] ;
						
						if(move_uploaded_file($_FILES["item_file"]['tmp_name']["$j"],$path)) { //upload the file
							
							$tipes=1;			 
						//masukan ke database uploadmaster
							   if ($insertt_stmt = $mysqli->prepare("INSERT INTO rm_upload_tanpa_rms ( 	id_rules_pub, tipe 	,  nama, path , tanggal ) VALUES (?,?, ?, ?, ?)")) {    
							   $insertt_stmt->bind_param('iisss', $id_akhir,$tipes, $nama_file , $path , $tanggal ); 
							   // Execute the prepared query.
							   $insertt_stmt->execute();
					
							   }
						}
						
						}
						
//upload administrasi
  
			
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
						
						}
				
						
						
//input databse file




} else {}




//Load Part.........
	if ($load_part = $mysqli->prepare("SELECT id, nama FROM rm_part  ")) {   
	   // Execute the prepared query.
		   $load_part->execute();
		   $load_part->bind_result($id_part,$part );
		   $parts=array();
		   while($load_part->fetch()){ $parts[]= "<option value='$id_part' >$part</option> "; }	   
	}
//End Load Part.........

//Load categori.........
	if ($load_kategori = $mysqli->prepare("SELECT id, nama FROM rm_paper  ")) {   
	   // Execute the prepared query.
		   $load_kategori->execute();
		   $load_kategori->bind_result($id_kategori,$kategori );  
		   $kategoris=array();
		   while($load_kategori->fetch()){ $kategoris[]= "<option value='$id_kategori' >$kategori</option> "; }	
	}
//End Load categori.........






?>

<form method="post" enctype="multipart/form-data" name="form1" action="panel.php?module=clistrules" >

<table width="101%" bordercolor="#000000" class="form">
  <tr>
    <td width="15%"><label> Name Technical Paper </label></td>
    <td colspan="5"><input type="text" name="textfield" id="textfield" value="" class="medium" required></td>
    </tr>
  <tr>
    <td><label>Year</label></td>
    <td><label>
      <input type="text" name="textfield3" required>
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label> Type paper </label></td>
    <td width="14%"><select name="select2">
      <?php foreach ($kategoris as $isi) { echo $isi ;} ?>
    </select></td>
    <td width="11%"><label> category ( Part ) </label></td>
    <td width="10%"><select name="select3">
      <?php foreach ($parts as $isi) { echo $isi ;}    ?>
    </select></td>
    <td width="14%"><label> Volume (with Number)</label></td>
    <td width="36%"><input type="text" name="textfield2" required></td>
  </tr>
  <tr>
    <td><label>Pdf Publication</label></td>
    <td><label>
      <input type="file" name="item_file[]" multiple size="100" required>
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Master Publication</label></td>
    <td><label>
      <input type="file"name="item_file2[]" multiple size="100" required>
    </label></td>
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
          			List Technical Paper </h2>
                <div class="block">
                   <?php 



$saringr= "%" . $_POST['search_query'] ."%" ;
$saring= $_POST['saring'] ;


//Load categori.........
	if ($load_kategori = $mysqli->prepare("SELECT id, nama FROM rm_paper  ")) {   
	   // Execute the prepared query.
		   $load_kategori->execute();
		   $load_kategori->bind_result($id_kategori,$kategori );  
		   $kategoris=array();
		   while($load_kategori->fetch()){ $kategoris[]= "$kategori"; }	
	}
//End Load categori.........

//Load Part.........
	if ($load_part = $mysqli->prepare("SELECT id, nama FROM rm_part  ")) {   
	   // Execute the prepared query.
		   $load_part->execute();
		   $load_part->bind_result($id_part,$part );
		   $parts=array();
		   while($load_part->fetch()){ $parts[]= "$part"; }	   
	}
//End Load Part.........


if ( $saring != 0 ) { $dimana= "where Rules like ? and  Tipe = ? order by id_rules DESC" ;} else { $dimana= "where Rules like ? order by id_rules DESC"  ;}

//Load list rule.........
	if ($load_rulest = $mysqli->prepare("SELECT id_rules, Rules, Tipe , Part , volume  FROM rm_ruleslist " .$dimana )) {   
	   // Execute the prepared query.
		  
		   if ( $saring != 0 ) { 
			 	  $load_rulest->bind_param('ss',$saringr, $saring); // Bind "$id_rules" to parameter.
			   }else {  $load_rulest->bind_param('s', $saringr);  }// Bila semua di tampilkan
			   
		   $load_rulest->execute();
		   $load_rulest->bind_result($id_rules,$Rules,$tipe,$part,$volume );
		   
		    echo "<table class='data display datatable' id='example'>
					<thead>
						<tr>
							<th>No</th>
							<th>Unix ID</th>
							<th>Nama Technical Paper</th>
							<th>Kategori</th>
							<th>Part </th>
							<th>Volume</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>";
			$no=1;
		  	while($load_rulest->fetch()){
	     $tipe = $tipe - 1 ;
		 $part = $part -1 ;
				echo "<tr class='odd gradeX'>
					<td>$no</td>
					<td>$id_rules</td>
					<td>$Rules</td>
					<td> $kategoris[$tipe]</td>
					<td>$parts[$part]</td>
					<td>$volume</td>
					<td> | <a href='./rules_sup/dell_crules.php?id=$id_rules'>Hapus</a></td></tr>";
					
					 $no++;
			}
	    	echo "</tbody></table>" ;

		   		
	}
//End Load Part.........

?>

					</div>
					</div>
			
       