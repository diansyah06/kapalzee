<?php
include ("../sis32/db_connect.php");

include "../functions.php";

sec_session_start();

// get var from post

include "../class/init3.php";

include "../modern.php";

date_default_timezone_set('Asia/Jakarta');
cekLoginStatus($mysqli);


//get data gambar drawing

$projectID=$_GET['idproj'];	
$drwaingstipeapprovals=$drawing->GetTipeapprovalDrawing();
$nameRelated= $obj->get_wokspaceByid($projectID);


  	foreach($nameRelated as $namedsd){
   	$nameRela=$namedsd['project'];
   	$description = 	$namedsd['description'];
   	$leader=$namedsd['lead'];
   	$starting=$namedsd['starting']; 	 	
   	$due=$namedsd['due'];
   	$target=$namedsd['target'];
   	$purpose ="Rp. " . number_format($target) ;
   
   	$contract=$namedsd['id_kontrak'];
   	$vesell=$namedsd['vessel'];
   	$lokasi=$namedsd['lokasi'];
   	$builder=$namedsd['builder'];
   	$submited=$namedsd['submited'];
   	$class=$namedsd['class_id'];
   	$kontractlink=$namedsd['kontractlink'];
      $sistercontract=$namedsd['sister'];
   
   	
   
   }

foreach ($drwaingstipeapprovals as $drwaingstipeapproval) {
	$codeApprovaldrawing[$drwaingstipeapproval[id_status]]=$drwaingstipeapproval[code];
	$DescripApprovaldrawing[$drwaingstipeapproval[id_status]]=$drwaingstipeapproval[desck];
}


$resultTables= $drawing->GetAlldrawingandComment($projectID);

		$statu_s = array(
			"Open",
			"closed",
			"Info"
		);



$strtable="<table class='table table-striped table-bordered table-hover' id='drawing_1'>
									<thead>
										<tr>
											<th>No</th>
											<th>Title</th>
											<th>Rev.</th>
											<th>id.Comm.</th>
											<th>Comment</th>
											<th>Comment.Stat</th>
											<th>Draw.Stat</th>						
										</tr>
									</thead>
									<tbody>";


$no =1 ;
foreach ($resultTables as $resultTable) {
	$strDescriptapproval=$DescripApprovaldrawing[$resultTable['drawingstatus']];
	$strtable=$strtable . "<tr >
									<td >$no</td>
									<td>$resultTable[judul]</td>
					
									<td>$resultTable[revisi]</td>
									<td>$resultTable[nomer_comment]</td>
									<td>$resultTable[comment]</td>
									<td>" . $statu_s[$resultTable['commentstatus']] ."</td>
									<td title='$strDescriptapproval'>". $codeApprovaldrawing[$resultTable['drawingstatus']] . "</td>
									</tr>"; 


$no++;
}

$strtable=$strtable . "</tbody></table><script>GenerateDrawingComment(1);</script>" ; 


?>

<!DOCTYPE html>
<html>
<head>
	<title>Bahtera Zee | Project Manajement System | Biro kLasifikasi Indonesia</title>

	

<script src="assets/js/pace.min.js"></script>
		 <link href="assets/css/pace_theme.css" rel="stylesheet" />
		
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<?php 	
			echo set_java_script_plugin_load ("main"); //MAIN JAVASCRIPTS


		?>
		<link rel="shortcut icon" href="favicon.png" />

<link rel='stylesheet' href='https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css'>



<script src="js/ogs.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>



<script src='https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js'></script>


<link href="https://cdn.datatables.net/rowgroup/1.0.2/css/rowGroup.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/rowgroup/1.0.2/js/dataTables.rowGroup.min.js"></script>
</head>
<body>




<div class="container">
					<!-- start: PAGE HEADER -->
					<div class="row">
						<div class="col-sm-12">

<h1>Project <small><?php echo $nameRela ; ?></small></h1>
<hr>
<?php

echo "<h3>Preview Time : <strong>" . date('Y-M-d h:i:sa') . "</strong></h3>";

?>

<?php 

echo $strtable ; 

?>
							
							
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>


</body>
</html>




