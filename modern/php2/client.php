<?php
$C_client = new client(); 
$pagenum_id=219;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
		


?>
<script src="js/ogs.js" type="text/javascript"></script>
<script src="../js/sha512.js" type="text/javascript"></script>
	<div class="page-header">
								<h1>Project<small> Client managemnt</small></h1>
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
											Add Client
										</button>
										<p>
										</p>
								<div id="project" class="project" >	
				
								
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
				<h4 class="modal-title">Create New Client</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Username
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="nick or username" id="nickuser" class="form-control">
											</div>
										</div>												
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Full name
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="as known as " id="aka" class="form-control">
											</div>
										</div>												
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Email
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="email" id="emailll" class="form-control" required>
											</div>
										</div>						
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Password
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="password" id="pass" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Company
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="text" id="company" class="form-control" required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Office tlp
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="text" id="telp" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												HP /WA
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="text" id="hp" class="form-control" required >
											</div>
										</div>										
										
									</form>
					

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="addClientProject();">
					Save changes
				</button>
			</div>
		</div>
			<!-- end: PAGE -->
					
						<script>
			jQuery(document).ready(function() {
				Main.init();
				TableData.init();
	
		$(".search-select").select2({
            placeholder: "Select a Participant",
            allowClear: true
        });

		    //function to initiate daterangepicker
  
        $('.date-picker').datepicker({
            autoclose: true
        });
				
				
			refreshClientProject();	
			});
			
			
		</script>	