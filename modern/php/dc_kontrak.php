<?php 
include "../class/Cdewaruci.php";
$pagenum_id=3;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			$listExperts=$DWR->GetKontrak("");
?>

<script src='js/dw_script.js'></script>	
					
					<div class="page-header">
								<h1>DCC <small>contract Management</small></h1>
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
								<?php echo writePanel("Insert Database Expert"); ?>
								<div class="panel-body">
								
										<form role="form" class="expert form-horizontal" id="expert" action="#" >

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Project Name :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Project Name" name="projectname" id="projectname" class="form-control" ruquired >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												No kontrak :
											</label>
											<div class="col-sm-9">
												<input type="number" placeholder="No kontrak " name="nokontrak" id="nokontrak" class="form-control" ruquired >
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Date Contract :
											</label>
											<div class="col-sm-9">
											<input data-date-format="dd-mm-yyyy" id="datecontrak"  name="datecontrak" data-date-viewmode="years" class="form-control date-picker" type="text">
											</div>

										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Register :
											</label>
											<div class="col-sm-9">
											<input type="number" placeholder="No Register jika ada" name="reg" id="reg" class="form-control">
											</div>

										</div>																		
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												 
											</label>					
											<div class="col-sm-9">											<p>
											<p>
											</p>
										<button type="button" class="btn btn-primary" onclick="kontrakadd('training');" >
											Submit
										</button>
										</p>	
										</div>
										</div>
				
									</form>	
											
									</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>				
							
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List contract"); ?>
								<div class="panel-body">
								<div id="training" class="training">
								<?php echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > Contract</th>
												<th > Nama</th>
												<th > Date</th>
												<th > Reg</th>

												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggal_input']));
										$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
										echo " <tr>
												<td>$n</td>
												<td>$listTraining[nokontrak]</td>
												<td >$listTraining[nama]</td>
												<td>$listTraining[tglKOntrak]</td>
												<td>$listTraining[reg]</td>
												
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
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
						
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Import Register Copps"); ?>
								<div class="panel-body">
								
										<form role="form" class="expert form-horizontal" id="expert" action="#" >

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Register :
											</label>
											<div class="col-sm-9">
												<input type="number" placeholder="No Register" name="regi" id="regi" class="form-control" ruquired >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Nama kapal :
											</label>
											<div class="col-sm-9">
												<input  placeholder="Ship Name " name="nmkplreg" id="nmkplreg" class="form-control" ruquired >
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												data
											</label>
											
											<div class="col-sm-2">
												<input placeholder="LPP" id="LPP" class="form-control" type="text">
											</div>
											<div class="col-sm-2">
												<input placeholder="T" id="T" class="form-control" type="text">
											</div>											
											<div class="col-sm-2">
												<input placeholder="GT" id="GT" class="form-control" type="text">
											</div>
											<div class="col-sm-2">
												<input placeholder="ThBngn" id="ThBngn" class="form-control" type="text">
											</div>
											
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												 
											</label>					
											<div class="col-sm-9">											<p>
											<p>
											</p>
										<button type="button" class="btn btn-primary" onclick="registeradd();" >
											Submit
										</button>
										</p>	
										</div>
										</div>
				
									</form>	
											
									</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>

<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Register"); ?>
								<div class="panel-body">
								<div id="register" class="register">
								<?php echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > Contract</th>
												<th > Nama</th>
												<th > Date</th>
												<th > Reg</th>

												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggal_input']));
										$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
										echo " <tr>
												<td>$n</td>
												<td>$listTraining[nokontrak]</td>
												<td >$listTraining[nama]</td>
												<td>$listTraining[tglKOntrak]</td>
												<td>$listTraining[reg]</td>
												
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
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
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			
			<!-- start: BOOTSTRAP EXTENDED MODALS -->
		
			<!-- end: PAGE -->
	<script>
			jQuery(document).ready(function() {

				Main.init();
				
				TableData.init();
				
				
		
				        $('.date-picker').datepicker({
            autoclose: true
        });



				
			});
		</script>	