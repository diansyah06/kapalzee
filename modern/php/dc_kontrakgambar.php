<?php 
include "../class/Cdewaruci.php";
$pagenum_id=2;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			
			$listExperts=$DWR->getkontrakgambarbycontract('');
			
			$getContractlist=$DWR->GetKontrak("");
			$getlistType=$DWR->gettypeDraw();
			

			
?>

<script src='js/dw_script.js'></script>	
					
					<div class="page-header">
								<h1>DCC <small>contract Drawing</small></h1>
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
								<?php echo writePanel("Tipe drawing"); ?>
								<div class="panel-body">
								
										<form role="form" class="expert form-horizontal" id="expert" action="#" >

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												No contract :
											</label>
											<div class="col-sm-9">
										<select id="nokontrak" class="form-control search-select">
											<option value="">&nbsp;</option>
											<?php
											foreach ($getContractlist as $getContractlis){
											echo "<option value='$getContractlis[nokontrak]'>$getContractlis[nama]</option>";
											
											}
											?>
										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Nama Drawing :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Title Drawing" name="namdraw" id="namdraw" class="form-control" ruquired >
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Type Drawing :
											</label>
											<div class="col-sm-9">
										<select id="typedraw" class="typedraw form-control"  name="typedraw" >
											<?php
											foreach ($getlistType as $getContractlis){
											echo "<option value='$getContractlis[id]'>$getContractlis[nametitle]</option>";
											
											}
											?>

										</select>
											</div>

										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												 
											</label>					
											<div class="col-sm-9">											<p>
											<p>
											</p>
										<button type="button" class="btn btn-primary" onclick="kontrakgambaradd();" >
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

								<div class="form-group">
										<label for="form-field-22">
											No contract
										</label>
										<select id="nokontraktbl" class="form-control search-select">
											<option value="">&nbsp;</option>
											<?php
											foreach ($getContractlist as $getContractlis){
											echo "<option value='$getContractlis[nokontrak]'>$getContractlis[nama]</option>";
											
											}
											?>
										</select>
									</div>
									
										<p>
										</p>


											<hr>
											</hr>
								<div id="training" class="training">
								<?php echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > Contract</th>
												<th > Nama</th>
												<th > type</th>
												

												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										

										echo " <tr>
												<td>$n</td>
												<td>$listTraining[nokontrak]</td>
												<td>$listTraining[namagambar]</td>
												<td>$listTraining[typedraw]</td>
												
												
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
			    //function to initiate Select2

        $(".search-select").select2({
            placeholder: "Select a State",
            allowClear: true
        });

		$("#nokontraktbl").change(function()
		{
		//alert($( "#nokontraktbl" ).val());
		posttable($( "#nokontraktbl" ).val());
		
		});		



				
			});
		</script>	