<?php
$pagenum_id=18;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("profile");
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("button");
			echo set_java_script_plugin_load ("table");
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("summer");
			echo set_java_script_plugin_load ("galery");
			
			
?>			
							<div class="page-header">
								<h1>Messages <small>mailbox sample</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					<button type="button" class="btn btn-info btn-squared btn-lg" href='#Composed_Message' data-toggle='modal' >
											Compose <i class="fa fa-envelope "></i>
										</button>
					<p>
</p>					
					<div class="row">
						<div class="col-md-12">
							<!-- start: INBOX PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-envelope-o"></i>
									Inbox
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="fa fa-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="fa fa-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body messages ">
									<ul class="messages-list">
										<li class="messages-search">
											<form action="#" class="form-inline">
												<div class="input-group">
													<input type="text" class="form-control" placeholder="Search messages...">
													<div class="input-group-btn">
														<button class="btn btn-primary" type="button">
															<i class="fa fa-search"></i>
														</button>
													</div>
												</div>
											</form>
										</li>
										<div class="panel-body panel-scroll" style="height:500px">
										<?php
										$listMessages=$obj->LoadMessage($user_id);
										
										foreach($listMessages as $listMessage){
										
										if($listMessage['status']=="N"){
										$readStatus=" active starred";
										}else{
										$readStatus="";
										}
										
										$jam=date("h:i A",strtotime($listMessage['created_on']));
										$tanggal=  date("F j, Y",strtotime($listMessage['created_on'])) ;
										
										
										
										
										echo "
										<li class='messages-item $readStatus' onClick='Showmmessagee($listMessage[mid]);'>
											<span title='Unread Message' class='messages-item-star'><i class='fa fa-star'></i></span>
											<img alt='' src=../$listMessage[path] class='messages-item-avatar'>
											<span class='messages-item-from'>". $alluserArray[$listMessage['created_by']] . "</span>
											<div class='messages-item-time'>
											<span class='text'>$jam</span>
											</div>
											<span class='messages-item-subject'>$tanggal</span>
											<span class='messages-item-preview'>". substr($listMessage['body'], 0, 70)   ." .." . " </span>
										</li>
										
										";
										
										
										}
										
										
										
										?>

										</div>
									</ul>
									<div id="messagelist" class="messagelist">
									

										</div>
									</div>
								</div>
							</div>
							<!-- end: INBOX PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
			
			<div id="Composed_Message" class="modal fade" tabindex="-1" data-width="560" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Commposed Message</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<h4>To</h4>
						<p>
									<select multiple="multiple" id="subscriber" class="form-control search-select" name="sapi[]">
									<?php 
											$listUsers=$Users->get_users();
											
											foreach ($listUsers as $listUser){
											
											echo "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
											}

									
									 ?>
											
										</select>
						</p>
						<div class="form-group">
										<label for="form-field-22">
											Message
										</label>
										<textarea placeholder="Default Text" id="Pesaanan" class="form-control"></textarea>
									</div>
						
						<input name="listsubscriber" id="listsubscriber" type="hidden"  />
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="saveSubscribertemp(); ComposesMessage();">
					Save changes
				</button>
			</div>
		</div>
			
			<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
		
		
			jQuery(document).ready(function() {

				Main.init();
				
							$(".search-select").select2({
            placeholder: "Select a Participant",
            allowClear: true
        });
				

			});
			
			</script>
		