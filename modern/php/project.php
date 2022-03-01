<?php
$pagenum_id=19;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			$listUsers=$Users->get_users();


?>
<script src="js/ogs.js" type="text/javascript"></script>
	<div class="page-header">
								<h1>Project<small> all about project</small></h1>
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
<form id="form1" name="form1" method="post" action="">
<label>
  <input name="radiobutton" type="radio" onclick="refreshProject(1);" value="0"  />
  Archive</label>
  <label>
  <input name="radiobutton" type="radio" onclick="refreshProject(0);" value="1" checked="checked" />
   Project In Progress</label>
</form>
								<button type="button" class="btn btn-green" href='#responsive' data-toggle='modal' >
											Add Project
										</button>
										<p>
										</p>
								<div id="project" class="project" >	
				
								
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					<div id="calback" class="calback" > </div>
					<!-- end: PAGE CONTENT-->
					
					
					
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
												Search Contract Number
											</label>
											<div class="col-sm-9">
												<input id="search-key" type="text" placeholder="search contract number, object name or requester" onkeyup="suggestAPI(this.value, 'contract')" class="form-control">
												 <div class="suggestField" id="suggestField"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												
											</label>
											<div class="col-sm-9">
												
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Project Name
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Name of Unit /vessel" id="projectname" class="form-control" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Contract Number
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="contact number state from survey division for each project" id="nokontract" class="form-control" readonly>
											</div>
										</div>												
<!-- 										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Class number
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Number of vessel/unit classed in Bki register" id="classno" class="form-control">
											</div>
										</div>		 -->									
<!-- 										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2">
												Type
											</label>
											<div class="col-sm-9">
												        <select name="select" id="tipe" class="form-control" onchange="changetipeObject();">
											<?php 
											//$tipe_objeks=$tipe_objeck->get_tipe_objek();
											//foreach ($tipe_objeks as $tipe_objek) {
											//echo "<option value='". $tipe_objek['id'] . "'>" . $tipe_objek['deskrip'] . "</option>" ;  }?>
											</select>
											</div>
										</div> -->
<!-- 										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-3" >
												Project Location
											</label>
											<div class="col-sm-9">
										<input type="text" placeholder="place where unit/vessel constructed" id="location" class="form-control">
											</div>
										</div> -->
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-4" >
												Project Manager
											</label>
											<div class="col-sm-9">
												<select id="leader" class="form-control search-select" >
										
											<?php foreach($listUsers as $listUser){
											
											echo "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
											
											} ?>
										</select>
											</div>
										</div>
<!-- 										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-5" >
												Builder
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Text Field" id="Builder" class="form-control">
											</div>
										</div> -->
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
												Due
											</label>
											<div class="col-sm-9">
													<span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
												<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="due">
												
											</div>
										
										</div>
										
									
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-8">
												Applicant
											</label>
											<div class="col-sm-9">
													<input type="text" placeholder="Applicant name" id="Submited" class="form-control" readonly>
											</div>
										</div>

										
									</form>
					

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="addProject();">
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
				
				
				
			});
			
			refreshProject(0);
		</script>

		<style>
			.suggestField {
			   position:relative;
			   left: 0px;
			   padding:0px;
			   margin:0px;
			   background-color: #999999;
			  }

			.suggestField ul li:hover {
			   background-color: #FC3;
			   color:#000;
		   	}

			.suggestField ul li {
			   list-style:none;
			   margin: 0px;
			   padding: 6px;
			   border-bottom:1px dotted #666;
			   cursor: pointer;
			}
		</style>	