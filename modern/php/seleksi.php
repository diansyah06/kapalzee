<?php
$pagenum_id=23;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			$listUsers=$Users->get_Active_users();


?>
	<div class="page-header">
	<script src='js/plan.js'></script>
								<h1>Proposal <small> Selection </small></h1>
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
						
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
									<li class="active" id="taboverview" >
										<a data-toggle="tab" href="#bank">
											Proposal
										</a>
									</li>
								</ul>
								<div class="tab-content">
					<div id="bank" class="tab-pane in active">
										<div class="row">			
						
						
						
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Proposal"); ?>
								<div class="panel-body">
								<button type="button" class="btn btn-green" href='#responsive' data-toggle='modal' >
											Add Proposal
										</button>
										<p>
										</p>
								<div id="proposalresearch" class="proposalresearch" >	
							<?php 		echo "		
								<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													<th >Title</th>
													<th class='hidden-xs' >type</th>
													<th class='hidden-xs'>Researcher</th>
													<th>cost</th>
													<th  class='hidden-xs' >Duration</th>
													<th >Status</th>
													<th ></th>

												</tr>
											</thead>";
							$projectlists=$kpi->getproposal();	
							
							foreach($projectlists as $projectlist ){
							
							echo "
											
											<tbody>
												<tr>
													<td ><a href='panel.php?module=selesksipro&id=$projectlist[id]'> $projectlist[judul]</a></td>
													<td class='hidden-xs' >$projectlist[type]</td>
													<td class='hidden-xs'> $projectlist[peneliti]</td>
													<td>$projectlist[cost]</td>
													<td class='hidden-xs'>
													$projectlist[start] $projectlist[end]</td>
													<td>$projectlist[status]</td>
													<td class='center'>
													<div class='visible-md visible-lg hidden-sm hidden-xs'>
														<a href='#' onclick= 'dellproposal($projectlist[id]);' class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
													</div>

													</td>
												</tr>";

									}	
?>									
											</tbody>
										</table>
								
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
					
					</div>
					</div>
					
					
					
								
					
					</div>
					</div>
					</div>
					
					
					
					
					
					
					
				<!-- start: BOOTSTRAP EXTENDED MODALS -->
		<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Create New Proposal</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Title
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Title of research" id="title" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-3" >
												Type
											</label>
											<div class="col-sm-9">
										
										<select id="typeplan" class="form-control" >
											<option value="1">Structure</option>
											<option value="2">Stability</option>
											<option value="3">Machinery</option>
											<option value="4">Offshore</option>
											<option value="5">Other</option>
										
										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-4" >
												Cost
											</label>
											<div class="col-sm-9">
												<input type="costplan" placeholder="Text Field" id="costplan" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-5" >
												Resecher
											</label>

											<div class="col-sm-9">
												<select multiple="multiple" id="penelitiplan" class="form-control search-select" name="sapi[]">
											<?php foreach($listUsers as $listUser){
											
											echo "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
											
											} ?>
											
										</select>
											</div>											
										</div>
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
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="tambahproposal();">
					Save changes
				</button>
			</div>
		</div>
		
		
						<!-- start: BOOTSTRAP EXTENDED MODALS -->
		

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