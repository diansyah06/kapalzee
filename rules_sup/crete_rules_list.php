<?php
$previl = cekprevil($mysqli) ;
$user_id = $_SESSION['user_id'];
$rules_guard=$rms->get_rule_guard($user_id);

if (($previl < 5) && (!$rules_guard) ){ die; }


$jenis_teknikal_paper=$rms->get_Teknikal_paper();


if (isset($_POST['textfield2'])){
$nTipe=$_POST['select'];
$nPart=$_POST['textfield4'];
$nvolume=$_POST['textfield5'];
$nNama=$_POST['textfield2'];
$nThn = $_POST['textfield3'];


//cek dulu ada slot apa ga
if($rms->Cek_free_slot_rule_list($nTipe,$nPart,$nvolume)){


	//insert databasse rule list
	$rms->insert_rule_list($nNama,$nTipe,$nPart,$nvolume);
	
	echo "<script>alert('Process Complete')</script>";

}else {

	$data_slot=$rms->get_rule_list_by_partvol($nTipe,$nPart,$nvolume);
	foreach ($data_slot as $data_slo) {$dataasem = $data_slo[Rules] ;echo "<script>alert('Failed, Slot is already exits for $dataasem')</script>";}

	}


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
                    Create New List Technical Paper </h2>
                <div class="block">
                    <p class="start">
<form id="form1" name="form1" method="post" action="">
  <table class="form">
    <tr>
      <td><label>New Name of Rules</label>
      </td>
      <td><label>
        <input type="text" name="textfield2" class="medium"  required="required" />
        </label>
          <label>Year
            <input type="number" name="textfield3" required="required" />
        </label></td>
    </tr>
    <tr>
      <td><label>Part</label>
      </td>
      <td><label>
        <input type="number" name="textfield4" required="required"/>
        </label>
          <label>Volume
            <input type="number" name="textfield5" required="required" />
        </label></td>
    </tr>
    <tr>
      <td><label>Tipe</label></td>
      <td><label>
        <select name="select">
          <?php foreach ($jenis_teknikal_paper as $jenis_teknikal_pape) { echo "<option value='$jenis_teknikal_pape[id_paper]'>$jenis_teknikal_pape[Nama]</option>" ;} ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><label>Submit</label></td>
      <td><label>
        <input type="submit" name="Submit" value="Submit" />
      </label></td>
    </tr>
  </table>
</form>
</p>
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
					<p>
					<hr>
					<div class="box round">
                <h2>
          			List Internasional code </h2>
                <div class="block">
				
				<?php
			$no=1;				
				$listCross=$rms->GetTableLiscrossRef();
				echo "<table class='data display datatable' id='example'>
					<thead>
						<tr>
							<th>No</th>
							<th>International Reff</th>
							<th>Description</th>
							<th>Link</th>
							<th>Rules </th>

						</tr>
					</thead>
					<tbody>";
					
					foreach ($listCross as $listCros){
					
					echo "<tr class='odd gradeX'>
					<td>$no</td>
					<td>$listCros[nama] $listCros[iacsTahun]</td>
					<td>$listCros[desk]</td>
					<td> <a href='panel.php?module=ed_cek&point=2&id=$listCros[id_cek]' > $listCros[id_cek]</a></td>
					<td>$listCros[Rules] $listCros[tahun]</td>

					</tr>";
					
					 $no++;
					
					
					}
				echo "</tbody></table>" ;
				
				
				?>
				
				
				
				</div>
				</div>