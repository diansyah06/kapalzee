<?php
$pagenum_id=19;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");



?>
	<div class="page-header">
<script src='js/plan.js'></script>	
								<h1>Planing <small> & Budgeting</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-sm-12"></div>
					</div>
					<div class="row">
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List document"); ?>
								<div class="panel-body">
								<button type="button" class="btn btn-green" href='#responsive' data-toggle='modal' >
											Add Plan
										</button>
										<p>
										</p>
								<div id="project" class="project" >	
				<?php 			//nilai balik
	echo "		
								<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													<th class='center'>Periode
													</th>

													<th class='center'>By	</th>
													
													<th class='center'>Status</th>
													<th></th>
													

												</tr>
											</thead>";
							$planbudgetlists=$kpi->GetPlanperiode();	
							
							foreach($planbudgetlists as $projectlist ){
								
							$tanggalstart= date("d M Y",strtotime($projectlist['start']));
							$tanggalselesai= date("d M Y",strtotime($projectlist['end']));
							
							$oleh=$alluserArray[$projectlist['by']];
							
							if ($projectlist['status']==1) {
								
								$status= "On" ;
								
							}else {
								
								$status= "Off" ;
							}
							
							echo "
											
											<tbody>
												<tr>

													<td class='center' >$tanggalstart until $tanggalselesai </td>
													<td class='center' > $oleh</td>
													<td class='center' > $status</td>
													<td class='center'>
													<a href='#' onclick='SetOnPlanPeriode($projectlist[id]);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Set On'><i class='fa fa-share'></i></a>
													<a href='#' onclick='DellPlanperiode($projectlist[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</td>
												</tr>";

									}	
										
										echo "		
											
										</tbody></table>";
										?>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
					
					
					
						<!-- start: BOOTSTRAP EXTENDED MODALS -->
		<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Create New Plan Budgeting</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal">
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-6">
												Start
											</label>
											<div class="col-sm-9">
													<span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
												<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="start">
												
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-7">
												due
											</label>
											<div class="col-sm-9">
													<span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
												<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="due">
												
											</div>
										
										</div>
										

										
									</form>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="AddPlanPeriode();">
					Save changes
				</button>
			</div>
		</div>
			<!-- end: PAGE -->
					
						<script>
			jQuery(document).ready(function() {
				Main.init();
				TableData.init();
				
				$('.color-palette').colorPalette()
            .on('selectColor', function (e) {
                $('#selected-color1').val(e.color);
            });
				

				
		$(".search-select").select2({
            placeholder: "Select a Participant",
            allowClear: true
        });

		    //function to initiate daterangepicker
  
        $('.date-picker').datepicker({
            autoclose: true
        });
				
				
				
			});
			
			
		</script>	