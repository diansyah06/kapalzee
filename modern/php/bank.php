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
								<h1>Research<small> Resource </small></h1>
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
											Bank
										</a>
									</li>
									<li  id="tabnEvent" >
										<a data-toggle="tab" href="#plan">
											Plan
										</a>
									</li>
									<li  id="tabnotes">
										<a data-toggle="tab" href="#Result">
											Result
										</a>
									</li>
																	
									
								</ul>
								<div class="tab-content">
					<div id="bank" class="tab-pane in active">
										<div class="row">			
						
						
						
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Bank"); ?>
								<div class="panel-body">
								<button type="button" class="btn btn-green" href='#responsive' data-toggle='modal' >
											Add bank
										</button>
										<p>
										</p>
								<div id="researchbank" class="researchbank" >	
							<?php 		echo "		
								<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													<th class='center'>
													Input
													</th>
													<th>Problem Background</th>
													<th class='hidden-xs'>Objective</th>
													<th>Resource</th>
													<th class='hidden-xs'>mark</th>
													<th ></th>

												</tr>
											</thead>";
							$projectlists=$kpi->getbankdata();	
							
							foreach($projectlists as $projectlist ){
							
							echo "
											
											<tbody>
												<tr>
													<td class='center'>
													$projectlist[inputan]</td>
													<td>$projectlist[background]</td>
													<td class='hidden-xs'> $projectlist[objective]</td>
													<td>$projectlist[resource]</td>
													<td class='hidden-xs'>
													$projectlist[mark]</td>
													
													<td class='center'>
													<div class='visible-md visible-lg hidden-sm hidden-xs'>
														<a href='#' onclick= 'dellbank($projectlist[id]);' class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
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
					
					<div id="plan" class="tab-pane">
						<div class="row">			
						
						
						
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Plan"); ?>
								<div class="panel-body">
								<button type="button" class="btn btn-green" href='#planmodal' data-toggle='modal' >
											Add Plan
										</button>
										<p>
										</p>
								<div id="planresearch" class="planresearch" >	
							<?php 		echo "		
								<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													<th class='center'>
													Title
													</th>
													<th class='hidden-xs' >Objective</th>
													<th class='hidden-xs' >Type</th>
													<th >Dana</th>
													<th>Resecher</th>
													<th class='hidden-xs'>Resource</th>

													<th >periode</th>
													<th >prioritas</th>
													<th ></th>													
													

												</tr>
											</thead>";
							$projectlists=$kpi->getPlanResearch();	
							
							foreach($projectlists as $projectlist ){
										$peserta= Extractusername($alluserArray,$projectlist[peneliti]);
										$titlePeserta=$peserta;
										if (strlen($peserta)>50){
										
										$peserta=substr($peserta,0,50) . ".." ;
										}
									$dumb=	$typebidangArray[$projectlist['type']];
							echo "
											
											<tbody>
												<tr>
													<td title='$projectlist[ket]' class='center'>
													$projectlist[judul]</td>
													<td>$projectlist[objective]</td>
													<td>$dumb</td>
													<td class='hidden-xs'> $projectlist[dana]</td>
													<td class='hidden-xs'> $peserta</td>
													<td>$projectlist[resource]</td>
													<td class='hidden-xs'>
													$projectlist[periode]</td>
													<td>$projectlist[prioritas]</td>
													<td class='center'>
													<div class='visible-md visible-lg hidden-sm hidden-xs'>
														<a href='#' onclick='dellplanresearch($projectlist[id]);' class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
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
					
					<div id="Result" class="tab-pane">
						<div class="row">			
						
						
						
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Result"); ?>
								<div class="panel-body">
								<button type="button" class="btn btn-green" href='#resultadad' data-toggle='modal' >
											Add Result
										</button>
										<p>
										</p>
								<div id="resultreserach" class="resultreserach" >	
							<?php 		echo "		
								<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													<th class='center'>
													Title
													</th>
													<th class='hidden-xs' >Result</th>
													<th class='hidden-xs' >Type</th>
													<th >followup</th>
													<th>Resecher</th>
													

													<th >periode</th>
													
													<th ></th>													
													

												</tr>
											</thead>";
							$projectlists=$kpi->getResultResearch();	
							
							foreach($projectlists as $projectlist ){
								$peserta= Extractusername($alluserArray,$projectlist[peneliti]);
										$titlePeserta=$peserta;
										if (strlen($peserta)>50){
										
										$peserta=substr($peserta,0,50) . ".." ;
										}						
							$dumb=	$typebidangArray[$projectlist['type']];
							echo "
											
											<tbody>
												<tr>
													<td title='$projectlist[ket]' class='center'>
													$projectlist[judul]</td>
													<td>$projectlist[hasil]</td>
													<td>$dumb</td>
													<td class='hidden-xs'> $projectlist[followup]</td>
													<td class='hidden-xs'> $peserta</td>
													
													<td class='hidden-xs'>
													$projectlist[periode]</td>
													
													<td class='center'>
													<div class='visible-md visible-lg hidden-sm hidden-xs'>
														<a href='#' onclick='dellResultresearch($projectlist[id]);' class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
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
				<h4 class="modal-title">Create New Project</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Inputan
											</label>
											<div class="col-sm-9">
													<textarea placeholder="Input From Everyware" id="inputan" class="form-control"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2">
												Background
											</label>
											<div class="col-sm-9">
													<textarea placeholder="Problem background" id="background" class="form-control"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-3" >
												Objective
											</label>
											<div class="col-sm-9">
													<textarea placeholder="what will achive" id="Objective" class="form-control"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-4" >
												Reseource 
											</label>
											<div class="col-sm-9">
													<textarea placeholder="( software,Hardware,brainware)" id="resource" class="form-control"></textarea>
											</div>											
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-5" >
												Mark / Description
											</label>
											<div class="col-sm-9">
													<textarea placeholder="workplace Description" id="mark" class="form-control"></textarea>
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
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="tambahbank();">
					Save 
				</button>
			</div>
		</div>



				<!-- start: BOOTSTRAP EXTENDED MODALS -->
		<div id="planmodal" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Create New Project</h4>
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
											<label class="col-sm-2 control-label" for="form-field-2">
												Objective
											</label>
											<div class="col-sm-9">
													<textarea placeholder="Objective of research" id="objectiveplan" class="form-control"></textarea>
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
												Resource
											</label>
											<div class="col-sm-9">
													<textarea placeholder="Resource needed (software, hardware ,brainware, etc )" id="resourceplan" class="form-control"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-7">
												Periode
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Execution periode" id="periodeplan" class="form-control">
											</div>
										
										</div>
										<div class="form-group">
										
										
										<label class="col-sm-2 control-label" >
											Priority
										</label>
											<div class="col-sm-9">
												<input type="text" placeholder="input with number" id="prioritiplan" class="form-control">
											</div>
									</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-8">
												Description
											</label>
											<div class="col-sm-9">
													<textarea placeholder="Description / mark " id="descripplan" class="form-control"></textarea>
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
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="tambahPlanResearch();">
					Save changes
				</button>
			</div>
		</div>
		
						<!-- start: BOOTSTRAP EXTENDED MODALS -->
		<div id="resultadad" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Create New Project</h4>
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
												<input type="text" placeholder="Title of research" id="titleresult" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2">
												Result
											</label>
											<div class="col-sm-9">
												<textarea placeholder="Result of research" id="result_result" class="form-control"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-3" >
												type
											</label>
											<div class="col-sm-9">
											<select id="typeresult" class="form-control" >
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
												Resecher
											</label>
											<div class="col-sm-9">
												<select multiple="multiple" id="Resecher" class="form-control search-select" name="sapi[]">
											<?php foreach($listUsers as $listUser){
											
											echo "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
											
											} ?>
											
										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-5" >
												Periode
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="execution periode" id="perioderesult" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-6">
												Follow up
											</label>
											<div class="col-sm-9">
												<textarea placeholder="Follow up " id="followupresult" class="form-control"></textarea>	
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-8">
												Description
											</label>
											<div class="col-sm-9">
													<textarea placeholder=" Description" id="descriptionresult" class="form-control"></textarea>
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
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="tambahResultResearch();">
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