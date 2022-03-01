<?php
include "../class/CdamageS.php";
$pagenum_id=4;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
		
$listExperts=$DSR->Get_DamageStat();			
			
			
			
?>
<div class="page-header">
	<script src='js/ds_script.js'></script>	
								<h1>Database  <small>Damage Statistik</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
			<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					
					<div class="row">
						
							
								
							
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Database Damage Statistik"); ?>
								<div class="panel-body">
								<div id="training" class="training">
								<?php echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
											 	 	 	 	
												<th > no</th>
												<th > Reg.</th>
												<th > Ship Type</th>
												<th > Name</th>
												<th > Date</th>
												<th > Area</th>
												<th > Object</th>
												<th > Specific Area</th>
												<th > Damage</th>
												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){

										$tanggal= date("d M Y",strtotime($listTraining['tgl_input']));

										echo " <tr>
												<td>$n</td>
												<td title='$listTraining[description]' > <a href='#' >  $listTraining[reg]</a></td>
												<td>$listTraining[tipe_kapal]</td>
												<td>$listTraining[namakapl]</td>
												<td >$tanggal</td>
												<td >$listTraining[CP]</td>
												<td >$listTraining[tipe]</td>
												<td >$listTraining[nama]</td>
												<td >$listTraining[tDamage]</td>
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='dellDamageStat($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
											
										
										?>		
											</tr>
										</tbody>
									</table>
								</div>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					
												<script>
			jQuery(document).ready(function() {

				Main.init();
				
				TableData.init();
});
</script>	