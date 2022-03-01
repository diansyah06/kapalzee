<?php

include("../../sis32/db_connect.php");
include "../../functions.php";
sec_session_start();
//get var from post
include "../../class/init4.php";
include "../../modern.php" ;
date_default_timezone_set('Asia/Jakarta');


$proj_id=intval($_GET['idproj']);
		// get jabatan
$user_id = $_SESSION['user_id'];
		$jabatans=$Users->Get_team_by_id($user_id ,$proj_id);
			foreach ($jabatans as $jabatan ) {
					$jabatanx=$jabatan['proj_jabatan'];
			} 
		//get kuasa 
		$kuasas=$Users->Get_kuasa_by_jabatn($jabatanx);
		foreach ($kuasas as $kuasa ) {
					$kuasax=$kuasa['kuasa_gambar'];
			} 
			$pizza  = $kuasax;
			$pieces = explode(",", $pizza);

		//get gambar
		
		foreach ($pieces as $piece){
			
			$gamb=$drawing->get_tipe_gambar_id($piece);
				foreach ($gamb as $gam ) {
					$drawing_list= $drawing_list . "<option value='" . $gam['id'] . "'> " . $gam['nama']. "</option>"  ;
				}
			
			}

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

			var oTable = $('#sample_3').dataTable({
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
        $('#sample_3_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        // modify table search input
        $('#sample_3_wrapper .dataTables_length select').addClass("m-wrap small");
        // modify table per page dropdown
        $('#sample_3_wrapper .dataTables_length select').select2();
        // initialzie select2 dropdown
        $('#sample_3_column_toggler input[type="checkbox"]').change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
			});
</script
