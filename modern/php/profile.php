<?php
$pagenum_id=13;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("profile");
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("button");
			echo set_java_script_plugin_load ("table");
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("summer");
			echo set_java_script_plugin_load ("galery");

//get task

$userSelect=$_GET['id'];

//if user lain
if ($userSelect==""){
$userSelect=$user_id;
}

$profileUsername=$Users->get_users_with_title($userSelect);
$listbiodatas=$Users->getUser_biodata($userSelect);
foreach ($listbiodatas as $listbiodata){
$profileEmail=$listbiodata['email'];
$profileFb=$listbiodata['fb'];
$profileYm=$listbiodata['ym'];
$profileHP=$listbiodata['handphone'];
$profileObjt=$listbiodata['tujuan'];
$profilePicture=$listbiodata['path'];
$profileAlamat=$listbiodata['alamat'];
$profilejabatan=$listbiodata['jabatan'];
}

$bits = explode("+", $profileAlamat);

$listprojectInvolp= $obj->Get_projectbymember($userSelect);
$listTrainingInvolve=$kpi->getTrainingByuser($userSelect);
$listUrgents=$Activity->getTaskbyidUserUrgent($userSelect);
$laslogin=$Users->lastLogin($userSelect);

?>
							<script src='js/plan.js'></script>
							<div class="page-header">
								<h1>User Profile <small>user profile page</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
									<li class="active">
										<a data-toggle="tab" href="#panel_overview">
											Overview
										</a>
									</li>
									<li>
										<a data-toggle="tab" href="#panel_edit_account">
											Edit Account
										</a>
									</li>
									<li>
										<a data-toggle="tab" href="#panel_projects">
											Projects
										</a>
									</li>
									<li>
										<a data-toggle="tab" href="#panel_training">
											Event
										</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="panel_overview" class="tab-pane in active">
										<div class="row">
											<div class="col-sm-5 col-md-4">
												<div class="user-left">
													<div class="center">
														<h4><?php echo $profileUsername ; ?></h4>
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div class="user-image">
																<div class="fileupload-new thumbnail"><img src="<?php echo "../" . $profilePicture ; ?>" alt="">
																</div>
																<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
																<div class="user-image-buttons">
																	<span class="btn btn-teal btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-pencil"></i></span><span class="fileupload-exists"><i class="fa fa-pencil"></i></span>
																		<input type="file">
																	</span>
																	<a href="#" class="btn fileupload-exists btn-bricky btn-sm" data-dismiss="fileupload">
																		<i class="fa fa-times"></i>
																	</a>
																</div>
															</div>
														</div>
														<hr>
														<p>
															<a class="btn btn-twitter btn-sm btn-squared">
																<i class="fa fa-facebook"></i>
															</a>
															<a class="btn btn-linkedin btn-sm btn-squared">
																<i class="fa fa-linkedin"></i>
															</a>
															<a class="btn btn-google-plus btn-sm btn-squared">
																<i class="fa fa-google-plus"></i>
															</a>
															<a class="btn btn-github btn-sm btn-squared">
																<i class="fa clip-yahoo"></i>
															</a>
														</p>
														<hr>
													</div>
													<table class="table table-condensed table-hover">
														<thead>
															<tr>
																<th colspan="3">Contact Information</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>url</td>
																<td>
																<a href="#">
																	www.bki.co.id
																</a></td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
																<td>email:</td>
																<td>
																<a href="">
																	<?php echo $profileEmail ; ?>
																</a></td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
																<td>phone:</td>
																<td><?php echo $profileHP ; ?></td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
																<td>skye</td>
																<td>
																<a href="">
																	peterclark82
																</a></td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
														</tbody>
													</table>
													<table class="table table-condensed table-hover">
														<thead>
															<tr>
																<th colspan="3">General information</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Position</td>
																<td><?php echo $profilejabatan ;?></td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
																<td>Last Logged In</td>
																<td><?php echo $laslogin ;?></td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															
															
															<tr>
																<td>Status</td>
																<td><span class="label label-sm label-info">Administrator</span></td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
														</tbody>
													</table>
													<table class="table table-condensed table-hover">
														<thead>
															<tr>
																<th colspan="3">Additional information</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Birth</td>
																<td>21 October 1982</td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
																<td>Groups</td>
																<td>New company web site development, HR Management</td>
																<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="col-sm-7 col-md-8">
												<p>
													<?php echo $profileObjt ;?>
												</p>
												<div class="row">
													<p>
													</p>
												</div>
												<div class="panel panel-white">
													<div class="panel-heading">
														<i class="clip-menu"></i>
														Recent Activities
														<div class="panel-tools">
															<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
															</a>
															<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
																<i class="fa fa-wrench"></i>
															</a>
															<a class="btn btn-xs btn-link panel-refresh" href="#">
																<i class="fa fa-refresh"></i>
															</a>
															<a class="btn btn-xs btn-link panel-close" href="#">
																<i class="fa fa-times"></i>
															</a>
														</div>
													</div>
													<div class="panel-body panel-scroll" style="height:300px">
														<ul class="activities">
															<li>
																<a class="activity" href="javascript:void(0)">
																	<i class="clip-upload-2 circle-icon circle-green"></i>
																	<span class="desc">You uploaded a new release.</span>
																	<div class="time">
																		<i class="fa fa-time bigger-110"></i>
																		2 hours ago
																	</div>
																</a>
															</li>
															<li>
																<a class="activity" href="javascript:void(0)">
																	<img alt="image" src="assets/images/avatar-2.jpg">
																	<span class="desc">Nicole Bell sent you a message.</span>
																	<div class="time">
																		<i class="fa fa-time bigger-110"></i>
																		3 hours ago
																	</div>
																</a>
															</li>
															<li>
																<a class="activity" href="javascript:void(0)">
																	<i class="clip-data circle-icon circle-bricky"></i>
																	<span class="desc">DataBase Migration.</span>
																	<div class="time">
																		<i class="fa fa-time bigger-110"></i>
																		5 hours ago
																	</div>
																</a>
															</li>
															<li>
																<a class="activity" href="javascript:void(0)">
																	<i class="clip-clock circle-icon circle-teal"></i>
																	<span class="desc">You added a new event to the calendar.</span>
																	<div class="time">
																		<i class="fa fa-time bigger-110"></i>
																		8 hours ago
																	</div>
																</a>
															</li>
															<li>
																<a class="activity" href="javascript:void(0)">
																	<i class="clip-images-2 circle-icon circle-green"></i>
																	<span class="desc">Kenneth Ross uploaded new images.</span>
																	<div class="time">
																		<i class="fa fa-time bigger-110"></i>
																		9 hours ago
																	</div>
																</a>
															</li>
															<li>
																<a class="activity" href="javascript:void(0)">
																	<i class="clip-image circle-icon circle-green"></i>
																	<span class="desc">Peter Clark uploaded a new image.</span>
																	<div class="time">
																		<i class="fa fa-time bigger-110"></i>
																		12 hours ago
																	</div>
																</a>
															</li>
														</ul>
													</div>
												</div>
												<div class="panel panel-white">
													<div class="panel-heading">
														<i class="clip-checkmark-2"></i>
														To Do
														<div class="panel-tools">
															<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
															</a>
															<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
																<i class="fa fa-wrench"></i>
															</a>
															<a class="btn btn-xs btn-link panel-refresh" href="#">
																<i class="fa fa-refresh"></i>
															</a>
															<a class="btn btn-xs btn-link panel-close" href="#">
																<i class="fa fa-times"></i>
															</a>
														</div>
													</div>
													<div class="panel-body panel-scroll" style="height:300px">
														<ul class="todo">
															<div id="taskrefresh" class="taskrefresh">
											<?php
									
									foreach($listUrgents as $listUrgent ){
									
									if ($userSelect==$user_id){
									$idkegiatann=$listUrgent['idKegiatan'];
									}else{
									$idkegiatann=0;
									}

									echo StyleTask($listUrgent['due'],$listUrgent['id'],$listUrgent['pekerjaan'],$listUrgent['tipeKegiatan'],$listUrgent['idKegiatan']) ;
										
									}
									
									?>
															<div>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="panel_edit_account" class="tab-pane">
										<form action="#" role="form" id="form" onsubmit="sendBio(event);">
											<div class="row">
												<div class="col-md-12">
													<h3>Account Info</h3>
													<hr>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															Name
														</label>
														<input type="text" placeholder="Name" class="form-control" id="firstname" name="firstname" value="<?php echo $profileUsername ; ?>">
													</div>
													<input type="hidden" id="user-id" value=<?php echo $userSelect;?>>
													<div class="form-group">
														<label class="control-label">
															Position
														</label>
														<input type="text" placeholder="Position" class="form-control" id="position" name="position" value="<?php echo $profilejabatan;?>">
													</div>
													<div class="form-group">
														<label class="control-label">
															Email Address
														</label>
														<input type="email" placeholder="Email address" class="form-control" id="email" name="email" value="<?php echo $profileEmail; ?>">
													</div>
													<div class="form-group">
														<label class="control-label">
															Phone
														</label>
														<input type="text" placeholder="(641)-734-4763" class="form-control" id="phone" name="email" value="<?php echo $profileHP ;?>">
													</div>
													<div class="form-group">
														<label class="control-label">
															Password
														</label>
														<input type="password" placeholder="password" class="form-control" name="password" id="password">
													</div>
													<div class="form-group">
														<label class="control-label">
															Confirm Password
														</label>
														<input type="password"  placeholder="password" class="form-control" id="password_again" name="password_again">
													</div>
												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">
																	Zip Code
																</label>
																<input class="form-control" placeholder="Post Code" type="text" name="zipcode" id="zipcode" value="<?php echo $bits[1]; ?>">
															</div>
														</div>
														<div class="col-md-8">
															<div class="form-group">
																<label class="control-label">
																	Address
																</label>
																<input class="form-control tooltips" placeholder="Home address" type="text" data-rel="tooltip"  title="" data-placement="top" name="city" id="city" value="<?php echo $bits[0]; ?>">
															</div>
														</div>
													</div>
													<div class="form-group">
														<label>
															Image Upload
														</label>
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src=" <?php echo "../".$profilePicture ;?>" alt="">
															</div>
															<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
															<div class="user-edit-image-buttons">
																<span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>
																	<input id="file-select" type="file">
																</span>
																<a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
																	<i class="fa fa-times"></i> Remove
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<h3>Additional Info</h3>
													<hr>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															Other Email
														</label>
														<span class="input-icon">
															<input class="form-control" id="othermail" type="text" placeholder="Email address other than BKI" value="<?php echo $profileYm; ?>">
															<i class="clip-stack-empty"></i> </span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															Facebook
														</label>
														<span class="input-icon">
															<input class="form-control" id="facebook" type="text" placeholder="Name in facebook or link to profile" value="<?php echo $profileFb; ?>">
															<i class="clip-facebook"></i> </span>
													</div>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-md-8">
													<p>
														By clicking UPDATE, you are agreeing to the Policy and Terms &amp; Conditions.
													</p>
												</div>
												<div class="col-md-4">
													<button id="submit-button" class="btn btn-teal btn-block" type="submit">
														Update <i class="fa fa-arrow-circle-right"></i>
													</button>
												</div>
											</div>
										</form>
									</div>
									<div id="panel_projects" class="tab-pane">
									<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													<th class='center'>
													<div class='checkbox-table'>
														<label>
															<input type='checkbox' class='flat-grey'>
														</label>
													</div></th>
													<th>Project Name</th>
													<th class='hidden-xs'>Client</th>
													<th>Proj Comp</th>
													<th class='hidden-xs'>%Comp</th>
													<th class='hidden-xs center'>Priority</th>
													<th></th>
												</tr>
											</thead>
					<?php				
									foreach($listprojectInvolp as $projectlist ){
									
									$tanggaldue=FormatTanggal($projectlist['due']);
									
									
							echo "
											
											<tbody>
												<tr>
													<td class='center'>
													<div class='checkbox-table'>
														<label>
															<input type='checkbox' class='flat-grey'>
														</label>
													</div></td>
													<td><a href='panel.php?module=projectMod&idproj=$projectlist[object_id]'>$projectlist[project]</a></td>
													<td class='hidden-xs'>Master Company</td>
													<td>$tanggaldue</td>
													<td class='hidden-xs'>
													<div class='progress progress-striped active progress-sm'>
														<div style='width: 70%' aria-valuemax='100' aria-valuemin='0' aria-valuenow='70' role='progressbar' class='progress-bar progress-bar-warning'>
															<span class='sr-only'> 70% Complete (danger)</span>
														</div>
													</div></td>
													<td class='center hidden-xs'><span class='label label-danger'>Critical</span></td>
													<td class='center'>
													
													<div class='visible-xs visible-sm hidden-md hidden-lg'>
														<div class='btn-group'>
															<a class='btn btn-primary dropdown-toggle btn-sm' data-toggle='dropdown' href='#'>
																<i class='fa fa-cog'></i> <span class='caret'></span>
															</a>
															<ul role='menu' class='dropdown-menu pull-right'>
																<li role='presentation'>
																	<a role='menuitem' tabindex='-1' href='#'>
																		<i class='fa fa-edit'></i> Edit
																	</a>
																</li>
																<li role='presentation'>
																	<a role='menuitem' tabindex='-1' href='#'>
																		<i class='fa fa-share'></i> Share
																	</a>
																</li>
																<li role='presentation'>
																	<a role='menuitem' tabindex='-1' href='#'>
																		<i class='fa fa-times'></i> Remove
																	</a>
																</li>
															</ul>
														</div>
													</div></td>
												</tr>";
												
												
									}	
?>									
											</tbody>
										</table>
									</div>
								<div id="panel_training" class="tab-pane">
									<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													<th class='center'>
													<div class='checkbox-table'>
														<label>
															<input type='checkbox' class='flat-grey'>
														</label>
													</div></th>
													<th>Project Name</th>
													<th class='hidden-xs'>Event</th>
													<th>On</th>
													
													<th></th>
												</tr>
											</thead>
					<?php				
									foreach($listTrainingInvolve as $projectlist ){
									
									$tanggaldue=FormatTanggal($projectlist['realisasiStart']);
									$nameEvent=$namakegiatan[$projectlist['typeOfevent']];
							echo "
											
											<tbody>
												<tr>
													<td class='center'>
													<div class='checkbox-table'>
														<label>
															<input type='checkbox' class='flat-grey'>
														</label>
													</div></td>
													<td><a href='panel.php?module=dEvent&id=$projectlist[id]'>$projectlist[training]</a></td>
													<td class='hidden-xs'>$nameEvent</td>
													<td>$tanggaldue</td>
													
													<td class='center'>
													
													<div class='visible-xs visible-sm hidden-md hidden-lg'>
														<div class='btn-group'>
															<a class='btn btn-primary dropdown-toggle btn-sm' data-toggle='dropdown' href='#'>
																<i class='fa fa-cog'></i> <span class='caret'></span>
															</a>
															<ul role='menu' class='dropdown-menu pull-right'>
																<li role='presentation'>
																	<a role='menuitem' tabindex='-1' href='#'>
																		<i class='fa fa-edit'></i> Edit
																	</a>
																</li>
																<li role='presentation'>
																	<a role='menuitem' tabindex='-1' href='#'>
																		<i class='fa fa-share'></i> Share
																	</a>
																</li>
																<li role='presentation'>
																	<a role='menuitem' tabindex='-1' href='#'>
																		<i class='fa fa-times'></i> Remove
																	</a>
																</li>
															</ul>
														</div>
													</div></td>
												</tr>";
												
												
									}	
?>									
											</tbody>
										</table>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
		
			});
			
			
		</script>	