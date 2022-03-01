<?php
$pagenum_id=10;
$Users->cekSecuritypeage($user_id,$pagenum_id);
$objectid=$_GET['id'];
$listaccesfiles=$obj->GetaplicationReadlog($objectid);
$listmodifiefiles=$obj->GetLogAplicationLogs($objectid);
$objectName=$obj->Get_objectName_id($objectid);
?>

<div class="page-header">
								<h1>History <small><?php echo $objectName ; ?></small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->


					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-sm-12">
						<div class="tabbable">
												<ul id="myTab4" class="nav nav-tabs tab-padding tab-space-3 tab-blue">
													<li class="active">
														<a href="#panel_tab3_example1" data-toggle="tab">
															Views
														</a>
													</li>
													<li>
														<a href="#panel_tab3_example2" data-toggle="tab">
															Modification
														</a>
													</li>

												</ul>
												<div class="tab-content">
													<div class="tab-pane in active" id="panel_tab3_example1">
													<p>
													</p>
												<table class="table table-hover" id="sample-table-1">
															<thead>
																<tr>
																	<th class="center">#</th>
																	<th>Date</th>
																	<th class="hidden-xs">User</th>
																	<th>Details</th>
																	
																</tr>
															</thead>
															<tbody>
															<?php 
															$n=1;
															foreach($listaccesfiles as $listaccesfile){
															
															$createon=date("F j, Y, g:i a", strtotime($listaccesfile[created_on]));
															
															if ($listaccesfile['action']=="read"){
															$strDetail="The user has accessed the object";
															
															}else {
															$strDetail="The user has download the object";
															
															}
															
															echo "
																<tr>
																	<td class='center'>$n</td>
																	<td class='hidden-xs'>$createon</td>
																	<td><a href='./panel.php?module=profile&id=$listaccesfile[created_by_id]' rel='nofollow' target='_blank'> $listaccesfile[nama]</a></td>
																	<td>$strDetail</td>
																
																<tr>";
															$n++;
															}
															?>	
																
																	
															</tbody>
														</table>	
													</div>
													<div class="tab-pane" id="panel_tab3_example2">
														<p>
													</p>
														<table class="table table-hover" id="sample-table-1">
															<thead>
																<tr>
																	<th class="center">#</th>
																	<th>Date</th>
																	<th class="hidden-xs">User</th>
																	<th>Details</th>
																	
																</tr>
															</thead>
															<tbody>
															<?php 
															$n=1;
															foreach($listmodifiefiles as $listaccesfile){
															
															$createon=date("F j, Y, g:i a", strtotime($listaccesfile[created_on]));
															$logData=substr(strip_tags($listaccesfile['log_data']),0,50) . ".." ;
													
															echo "
																<tr>
																	<td class='center'>$n</td>
																	<td class='hidden-xs'>$createon</td>
																	<td><a href='./panel.php?module=profile&id=$listaccesfile[created_by_id]' rel='nofollow' target='_blank'> $listaccesfile[nama]</a></td>
																	<td>$listaccesfile[nama] $listaccesfile[action]ed $listaccesfile[object_name] ....(<strong> $logData</strong>)</td>
																
																<tr>";
															$n++;
															}
															?>	
																
																	
															</tbody>
														</table>	
													</div>

												</div>
											</div>
											
											
							
							</div>
						</div>
					</div>	
					<script>
			jQuery(document).ready(function() {
				Main.init();
		
			});
			
			
		</script>	