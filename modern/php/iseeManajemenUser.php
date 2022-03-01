<?php 
	
	$saltings = $Users->get_previl($_SESSION['user_id']);
	if ($saltings != 9) {
		echo "<script> window.location.href = './panel.php?modul=notfound';</script>";
		die();
	}

//	$Users->cekSecuritypeage($user_id,$pagenum_id);
	echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
	echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
	echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY

	//getalluser
	//$listUsers=$iSeeuser->iSee_getUser();	 //tidak terpakai
	//$listSessions=$iSeeuser->iSee_getSession(); //tidak terpakai
	

?>

<script src='js/isee_script.js'></script>
<script src='../js/sha512.js'></script>	
					
					<div class="page-header">
								<h1>Manage User Bahtera <small>Insert and edit user</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
			<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					
					<div class="row">
						
							
							<div class="col-sm-6">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Insert user iSee"); ?>
								<div class="panel-body">

										<div class="form-group">
											<label for="form-field-22">
												NUP
											</label>
											<input type="text" placeholder="NUP" id="nup" class="form-control">
										</div>
										<div class="form-group">
											<label for="form-field-22">
												Phone										
											</label>
											<span class="col-sm-9-addon"> </span>	
											<input type="text" placeholder="Phone Number eq 081234567890" id="phone" class="form-control">									
										</div>
										<div class="form-group">
											<label for="form-field-22">
												Password											
											</label>
											<span class="col-sm-9-addon"> </span>	
											<input type="text" placeholder="Password" id="password" class="form-control">
										</div>
										
										<div>
											<p></p>
											<a class="btn btn-blue"  onclick="WebAddUser('user');"><i class="fa fa-plus"></i>
												Submit Entry</a>
													
											<button type="button" class="btn btn-green" onclick="clearFrom();">
													Reset
											</button>		
													
										</div>

											
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>	
						
						<!-- Tabel session : table s -->
						<div class="col-sm-6">
							<!-- start: SELECT BOX PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Special Users"); ?>
								
								<div class="panel-body panel-scroll" style="height:300px">
								
									<ul class="todo">
								<div id="iSeefresh" class="iSeefresh">	
									
									</div>	
									</ul>
									
								</div>
								
								</div>
							</div>						
							
						<!-- Tabel DATA USER : tabel u-->	
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List User"); ?>
								<div class="panel-body">
								<div id="user" class="user">
							
								</div>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
						
				
						<!-- POP UP EDIT DATA USER -->
						<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">Edit User </h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-10">
										<h4>Name</h4>
										<p>
											<input class="form-control" type="text" id="nameedit" readonly>
										</p>
										<h4>NUP</h4>
										<p>
											<input class="form-control" type="text" id="nupedit" readonly>
										</p>
										<h4>Phone Number</h4>
										<p>
											<input class="form-control" type="text" id="newphone">
										</p>
										<h4>Email</h4>
										<p>
											<input class="form-control" type="text" id="newemail">
										</p>
										
									</div>
									
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-dismiss="modal" class="btn btn-light-grey">
									Close
								</button>
								<button type="button" class="btn btn-blue" data-dismiss="modal" onclick="WebEditUser('user');">
									Save changes
								</button>
							</div>
						</div>

						
						<!-- POP UP Reset Password USER -->
						<div id="reset" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">Reset Password </h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-10">
										<h4>Name</h4>
										<p>
											<input class="form-control" type="text" id="namereset" readonly>
										</p>
										<p>
											<input class="form-control" id="nupreset" type="hidden" readonly>
										</p>
										<h4>Password</h4>
										<p>
											<input class="form-control" type="text" id="newpass">
										</p>
										<h4>Confirm Password</h4>
										<p>
											<input class="form-control" type="text" id="conpass">
										</p>
										
									</div>
									
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-dismiss="modal" class="btn btn-light-grey">
									Close
								</button>
								<button type="button" class="btn btn-blue" data-dismiss="modal" onclick="WebResetUser('user');">
									Save changes
								</button>
							</div>
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
				
				AddTableS ("iSeefresh"); //memanggil nilai balik id iSeefresh
				
				AddTableU ("user"); //memanggil nilai balik id user

		
				        $('.date-picker').datepicker({
            autoclose: true
        });
			
				setInterval(function (){ AddTableS ("iSeefresh"); }, 60000);	

				
			});
		</script>	