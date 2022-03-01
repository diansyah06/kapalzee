<?php 
include "../class/Cdewaruci.php";
$pagenum_id=6;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			$listExperts=$dcc->GetdccUser();
?>

<script src='js/dw_script.js'></script>	
					
					<div class="page-header">
								<h1>DCC <small>user Management</small></h1>
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
								<?php echo writePanel("Insert user Dewaruci"); ?>
								<div class="panel-body">
								
										<form role="form" class="expert form-horizontal" id="expert" action="#" >

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												User Name:
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="nama lengkap" name="usrname" id="usrname" class="form-control" ruquired >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												NUP :
											</label>
											<div class="col-sm-9">
												<input type="number" placeholder="induk Pegawai " name="nup" id="nup" class="form-control" ruquired >
											</div>
										</div>										

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Divisi :
											</label>
											<div class="col-sm-9">
											<input type="text" placeholder="Nama Divisi" name="divisi" id="divisi" class="form-control">
											</div>

										</div>																		
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												 
											</label>					
											<div class="col-sm-9">											<p>
											<p>
											</p>
										<button type="button" class="btn btn-primary" onclick="userAdddcc('training');" >
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
								<?php echo writePanel("List User"); ?>
								<div class="panel-body">
								<div id="training" class="training">
								<?php echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > NUP</th>
												<th > Nama</th>
												<th > Divisi</th>
												

												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										
										
										echo " <tr>
												<td>$n</td>
												<td>$listTraining[nup]</td>
												<td >$listTraining[nama]</td>
												<td>$listTraining[divisi]</td>

												
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