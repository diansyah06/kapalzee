<?php
include("../../sis32/db_connect.php");
include "../../functions.php";
sec_session_start();
//get var from post
include "../../class/init4.php";
include "../../modern.php" ;
date_default_timezone_set('Asia/Jakarta');

$idproject=$_GET['idproj'];
//get typegambar
$tipe_gambars=$drawing->get_tipe_gambar();
$tipe_gam=array();
foreach ($tipe_gambars as $tipe_gambar) {
	$strtipegmabr= $strtipegmabr .  "<option value='$tipe_gambar[id]'> $tipe_gambar[nama]</option>" ;
	$id=$tipe_gambar['id'];
	$tipe_gam[$id]=	$tipe_gambar['nama'];
}
$get_draws=$drawing->get_proj_gambar($idproject);

$strlistgambar= "<table class='table table-striped table-bordered table-hover' id='sample_2'>
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
	
	 $strlistgambar=$strlistgambar. "<tr >
									<td >$no</td>
									<td > <a href='panel.php?module=listrevision&id=". $idproject. "&mod=2&draw=$get_draw[id] '>". $get_draw['no_gambar'] . " </a></td>
									<td >". $get_draw['judul'] . " </a></td>
									<td >".  $tipe_gam[$z]. "</td>
									<td>" . $get_draw['tanggal'] . "</td>
									<td>" . "<a href='kontrak/read.php?module=read&kon=$idproject&gam=$get_draw[id]'" .  "target='_blank'>" . "Open</a> " ."</td>
									<td> <a href='#'  onclick=". "fung_del_gambar(" . $perant ."); > Delete </a> "  . "</td>									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	$strlistgambar=$strlistgambar. "</tbody></table>";




?>
<script src="js/kontrak-po.js" type="text/javascript"></script>
	

<div class="row">
	<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-stats"></i>
									List Drawing
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">								
									<div id="listgambar" class="listgambar">
									
									<?php echo $strlistgambar; ?>
								
									</div>
								</div>
							</div>
	</div>
</div>

<style >
	#hidden_content{display:none;}
	</style>
	
<script>
			jQuery(document).ready(function() {

			var oTable = $('#sample_2').dataTable({
            "aoColumnDefs": [{
                "aTargets": [0]
            }],
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Rows",
                "sSearch": "",
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },
            "aLengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10,
        });
        $('#sample_2_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        // modify table search input
        $('#sample_2_wrapper .dataTables_length select').addClass("m-wrap small");
        // modify table per page dropdown
        $('#sample_2_wrapper .dataTables_length select').select2();
        // initialzie select2 dropdown
        $('#sample_2_column_toggler input[type="checkbox"]').change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
			});
</script
					