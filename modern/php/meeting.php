<?php
$pagenum_id=21;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			
$projectID=$_GET['idproj'];	
$idproject=$projectID;
$idMom=$_GET['idmom'];
$id_minutes	=$idMom ;
$nameRelated= $obj->get_wokspaceByid($projectID);


foreach($nameRelated as $namedsd){
$nameRela=$namedsd['project'];
$description = 	$namedsd['description'];
$purpose =$namedsd['purpose'];
$leader=$namedsd['lead'];
$starting=$namedsd['starting']; 	 	
$due=$namedsd['due'];
$color=$namedsd['color'];

}

$getDataMOMs=$rms->get_minute_meeting_id($projectID,$idMom);

foreach ($getDataMOMs as $getDataMOM) {
	
	$hasilRapat=$getDataMOM['hasil_rapat'];
	$listPesrta=$getDataMOM['kehadiran'];
	$listExternal=$getDataMOM['externalEmail'];
	$fileattacemnet =$getDataMOM['file'];
	
}

$stringPeople="	<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > No</th>
												<th > Name</th>
												<th class='center' > Action</th>
											</tr>
										</thead>
										<tbody>"; 
$n=1;
$pieces=explode(",",$listPesrta);
foreach($pieces as $DocumentList ){

	$stringPeople= $stringPeople . " <tr>
												<td>$n</td>
												<td> $alluserArray[$DocumentList]</td>
												<td  class='center' >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
												<a onClick='delpeople($idproject,$id_minutes,$DocumentList)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												</td>
											</tr>";
										
	$n++;
}
	$stringPeople= $stringPeople . "</tr></tbody></table>"; 

?>
	<div class="page-header">
								<h1>Meeting<small> <?php echo "<a  href='panel.php?module=projectMod&idproj=$projectID' >" . $nameRela . "</a>" ; ?></small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-sm-12">
							<!-- start: FILE UPLOAD PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Write Minutes of Meeting"); ?>
								<div class="panel-body">
									<textarea class="ckeditor form-control" cols="10" rows="10" id="pesanndee" ><?php echo $hasilRapat ; ?></textarea>
								</div>
								<div class="panel-body">
								<a class="btn btn-blue"  onclick="updateMeeting(<?php echo $projectID . "," . $idMom ;?>);"><i class="fa fa-plus"></i>
											update</a>
								</div>			
							</div>
							<!-- end: FILE UPLOAD PANEL -->
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12"></div>
					</div>

<div class="row">
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Info"); ?>
								<div class="panel-body">
								<form role="form" class="form-horizontal" id="uploadmomForm"  name="uploadmomForm">	
								<label class="col-sm-2 control-label">
												External parties
								</label>
								<div class="col-sm-3">
								
									<?php
										$extArr=explode(",", $listExternal);

										foreach ($extArr as $extAr) {
											echo $extAr . "<br>" ;
										}

									?>
									
									
								</div> 
								<p>
								</p>
								<p>
								</p>
								<hr><hr>


										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
											Attachment [*.PDF]	
											</label>
											<div class="col-sm-4">
												<input type="file" name="uploadAttacmentMOM"  class="form-control"/>
												<input type="hidden" id="modul" name="modul" value="meeting">
												<input type="hidden" id="act" name="act" value="uploadmom">
												<input type="hidden" id="idproj" name="idproj" value="<?php echo $idproject; ?>">
												<input type="hidden" id="idmom" name="idmom" value="<?php echo $id_minutes; ?>">
												
										  </div>
										  <button class="btn btn-purple"  type="submit" >
											Start upload  <i class="fa fa-arrow-circle-right"></i>
										</button>
										</div>										

									<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
											 	
											</label>
											<div class="col-sm-4">
												<div id="asddocument" class="asddocument">
													<a href="#" target=_blank >attachment</a>
												</div>
										  </div>
										  
									</div>
										<hr><hr>				
								
								</form>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>					
					<div class="row">
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Attendance"); ?>
								<div class="panel-body">
								<label class="col-sm-2 control-label">
												Add Attendance
								</label>
								<div class="col-sm-3">
								
									<select id="team" class="form-control" >
										
									<?php foreach($listUsers as $listUser){
											echo "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
									} ?>
									</select>
									
									
								</div>
								<div class="col-sm-3">
								<a class="btn btn-blue"  onclick="addpeopleMeeting(<?php echo $projectID . "," . $idMom ;?>);"><i class="fa fa-plus"></i>Add</a>
								</div>
								<p>
								</p>
								<hr>

								<br>

								
								<div id="document" class="document">
								<?php echo $stringPeople ;?>
								</div>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
					
					
					<!-- start: BOOTSTRAP EXTENDED MODALS -->
		
			<!-- end: PAGE -->
					
<script>
	jQuery(document).ready(function() {
				Main.init();
				TableData.init();
				
				        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();
				
	
        	$("form#uploadmomForm").submit(function(event){
			 
			  //disable the default form submission
			  event.preventDefault();
			  //var sapii=document.getElementById('textfield').value;
			  //var test = CKEDITOR.instances['narasisurvey'].getData();
			  //grab all form data  
			  var formData = new FormData($(this)[0]);
			  //formData.set('narasisurvey', test);
			  $.ajax({
				url: 'process.php',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (html) {
			$('.asddocument').html(html);
			$(".asddocument").hide();
			$(".asddocument").fadeIn(400);}
			
			  });
			 
			  return false;
			});	

	});
			
			

			
</script>	