<?php
$pagenum_id=219;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
		$clientid= $_GET['clientid'];
$C_client = new client(); 		
		//get projectlist
		$projectlists=$obj->get_wokspaceUndone(0);	
		//getClient detail
		$getdataClientdetail=$kontrak->getClientlistid($clientid);
		foreach($getdataClientdetail as $getdataClientdetai){
			$aka=$getdataClientdetai['aka'];
			$nick=$getdataClientdetai['nick'];
			$email=$getdataClientdetai['email'];
			$tipeUser=$getdataClientdetai['kolabolator'];

		}

		if ($tipeUser==0) {
			$clientradio="checked";
		}else{
			$colabolatortradio="checked";
		}


		$listActivityClient=$C_client->GetActivityClient($clientid);

		//doing 1:drawing,2:commneting,3:profile,4:changepassword,5:login,6:technical,7:reqdownload
		//Act 1: add /upload / replay / login , 2: delete /logout

		$doingArr=  array('0','drawing','commneting','profile','changepassword','login','technical','reqdownload');
		$actArr = array('0','add /upload / replay / login','delete /logout' );
		//print_r($listActivityClient);


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
								<?php echo writePanel("Client detail"); ?>
								<div class="panel-body">

<form role="form" class="form-horizontal">

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												As Known As :</label>
											<div class="col-sm-5">
												<input type="text" placeholder="AKA" id="aka"  value="<?php echo $aka ;?>"class="form-control">
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Nick :											</label>
											<div class="col-sm-5">
												<input type="text" placeholder="no space" id="nickuser" value="<?php echo $nick ;?>" class="form-control">
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Email :											</label>
											<div class="col-sm-5">
												<input type="text" placeholder="blabla@gmail.com" id="emailll" value="<?php echo $email ;?>" class="form-control">
											</div>
										</div>										

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												type user :											</label>
											<div class="col-sm-5">
												<input type="radio" name="typeclient" value="0" <?php echo $clientradio ;?> > Client
  												<input type="radio" name="typeclient" value="1" <?php echo $colabolatortradio ;?>> Colabolator<br>
											</div>
										</div>	 										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												<button type="button" class="btn btn-default" disabled onclick="updateClientProject(<?php echo $clientid  ;?>);">
											Update
										</button>											</label>

										</div>
										

										
										
										
									</form>	

							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					</div>
					<div class="row">
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Project Asosiated"); ?>
								<div class="panel-body">
								<label class="col-sm-1 control-label">
												Add Project
								</label>
								<div class="col-sm-2">
								
									<select id="team" class="form-control" >
										
									<?php foreach($projectlists as $listUser){
											echo "<option value='$listUser[object_id]'>$listUser[project]</option>"   ;
									} ?>
									</select>
									
									
								</div>

								<label class="col-sm-1 control-label">
												Group
								</label>
								<div class="col-sm-2">
								
									<select id="builder" class="form-control" >
										<option value="0">Builder Group User</option>
										<option value="1">Owner Group User</option>	
									</select>
								</div>

								<label class="col-sm-1 control-label">
												Colaborator
								</label>
								<div class="col-sm-1">
								
									<select id="colabortorr" class="form-control" >
										<option value="0">Client</option>
										<option value="1">Coloborator</option>	
									</select>
								</div>

								<div class="col-sm-3">
								<a class="btn btn-blue"  onclick="addClientassosiated(<?php echo $clientid  ;?>);"><i class="fa fa-plus"></i>Add</a>
								</div>
								<p>
								</p>
								<hr>

								<br>
										<p>
										</p>
								<div id="projectlist" class="projectlist" >	
				
								
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					</div>

					<div class="row">
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Log Client"); ?>
								<div class="panel-body">
<?php
$strlistgambar= "<table class='table table-striped table-bordered table-hover' id='sample_3'>
									<thead>
										<tr>
											<th>tanggal</th>
											<th>doing </th>
											<th>act </th>
											<th>descript</th>
										</tr>
									</thead>
									<tbody>";

foreach ($listActivityClient as $get_draw) {

	 $strlistgambar=$strlistgambar. "<tr >
									<td width='10%''>". $get_draw['tanggal'] . " </td>
									<td width='5%''>". $doingArr[$get_draw['doing']] . " </a></td>
									<td width='15%''>". $actArr[$get_draw['act']]. "</td>
									<td >". $get_draw['descript']. "</td>								
									</tr>";
									

	$no++;
	}
	$strlistgambar=$strlistgambar. "</tbody></table><script> generatedTable(3);</script>";
	echo $strlistgambar ;

?>								



							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					</div>
				
					<!-- end: PAGE CONTENT-->
					
					
					
		
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
				
			refreshassosiation(<?php echo $clientid  ;?>);	

			});
			
			
		</script>	