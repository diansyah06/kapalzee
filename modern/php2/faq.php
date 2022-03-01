<?php
$pagenum_id=218;
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
								<h1>Project<small> Insert Faq</small></h1>
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
								<?php echo writePanel("List FAQ"); ?>
								<div class="panel-body">
								<button type="button" class="btn btn-green" href='#responsive' data-toggle='modal' >
											Add FAQ
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
				<h4 class="modal-title">Create New FAQ</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Subject
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Subject" id="subject" class="form-control">
											</div>
										</div>												
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Description
											</label>
											<div class="col-sm-9">
												<textarea placeholder="Description" id="descr" class="form-control" rows=9></textarea>
											</div>
										</div>												
										

									</form>
					

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="addfaq();">
					Save changes
				</button>
			</div>
		</div>
			<!-- end: PAGE -->
					
						<script>
			jQuery(document).ready(function() {
				Main.init();
				TableData.init();
	


		    //function to initiate daterangepicker
  
        $('.date-picker').datepicker({
            autoclose: true
        });
				
				
			refreshfaq();	
			});
			
			
		</script>	