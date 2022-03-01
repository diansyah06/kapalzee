<?php
include "../class/Cdewaruci.php";
$pagenum_id=5;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY

include "../modern/dcm.php" ;
//getalluser
$listUsers=$dcc->GetdccUser();


$alluserArraydw=array(); // store alluseronarray
foreach($listUsers as $listUser){
$idusernya=$listUser['nup'];
$alluserArraydw[$idusernya]=$listUser['nama'];
}


$sessionlist=$dcc->getSession();
$listComputer=$dcc->getComputer();

?>

<div class="page-header">
								<h1>DCC <small>Computer Register</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
						<div class="col-sm-6">
							<!-- start: TEXT AREA PANEL -->
							<!-- start: TEXT AREA PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Register Computer"); ?>
								<div class="panel-body">
									<div class="form-group">
										<label for="form-field-22">
											Computer Name
										</label>
										<input type="text" placeholder="Computer Name" id="namcomputer" class="form-control">
									</div>
									<div class="form-group">
											<label for="form-field-22">
												Mac											</label>
											
											<span class="col-sm-9-addon"> </span>	
											<input type="text" placeholder="Mac address eq C8F73391F8F3" id="mac" class="form-control">
												
											
										</div>
									<div class="form-group">
											<label for="form-field-22">
												IP											</label>
											
											<span class="col-sm-9-addon"> </span>	
											<input type="text" placeholder="Ip eq 10.0.1.202" id="IP" class="form-control">
												
											
										</div>
										
									<div>
									<p></p>
									<a class="btn btn-blue"  onclick="addComputer();"><i class="fa fa-plus"></i>
											Submit Entry</a>
											
									<button type="button" class="btn btn-green" onclick="clearFrom();">
											Reset
										</button>		
											
									</div>		
								</div>
							</div>
							</div>
							<!-- end: TEXT AREA PANEL -->
					
						<div class="col-sm-6">
							<!-- start: SELECT BOX PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Active Session DCC"); ?>
								
								<div class="panel-body panel-scroll" style="height:300px">
								
									<ul class="todo">
								<div id="dccfresh" class="dccfresh">	
									<table class="table table-condensed table-hover" id="sample-table-3">
										<thead>
											<tr>
												<th class="center hidden-xs">
												<div class="checkbox-table">
													<label>
														<input type="checkbox" class="flat-grey">
													</label>
												</div></th>
												<th>User</th>
												<th class="hidden-xs">Joint</th>
												<th><i class="fa fa-time"></i> last seen </th>
												<th class="hidden-xs">Status</th>
											</tr>
										</thead>
										<tbody>
										
										<?php 
									
									foreach($sessionlist as $sessionlis){
									
									$namuser=$alluserArraydw[$sessionlis['iduser']];
									$tanggalJoint= FormatTanggaljam($sessionlis[start]);
									$tanggalupdate= FormatTanggaljam($sessionlis[lasupdate]);
									echo "<tr>
												<td class='center hidden-xs'>
												<div class='checkbox-table'>
													<label>
														<input type='checkbox' class='flat-grey'>
													</label>
												</div></td>
												<td>
												<a href='#'>
													$namuser
												</a></td>
												<td class='hidden-xs'>$tanggalJoint</td>
												<td>$tanggalupdate</td>
												<td class='hidden-xs'><span class='label label-sm label-success'>Active</span></td>
											</tr>";
									
									
									
									
									}
										
										
										?>

										</tbody>
									</table>
									
									</div>	
									</ul>
									
								</div>
								
								</div>
							</div>
							<!-- end: SELECT BOX PANEL -->
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Computer List"); ?>
								<div class="panel-body">
								<div id="listcomputer" class="listcomputer">
								<?php 
								
								echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > Name</th>
												<th > Mac</th>
												<th > IP </th>
												<th > Divison</th>
												<th > Action</th

											</tr>
										</thead>
										<tbody>"; 
										
									
										foreach($listComputer as $listTodo ){

										$macformat=AddSeparator($listTodo['mac']);
										
										echo " <tr>
												<td>$listTodo[name]</td>
												<td>$macformat</td>
												<td >$listTodo[ip]</td>
												<td> </td>
											
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a href='#' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										

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

<script src='js/dccModern.js'></script>
						
							<script>
			jQuery(document).ready(function() {

				Main.init();
				
				TableData.init();
				    //function to initiate daterangepicker
  

		
		$('.drop-down-wrapper').perfectScrollbar({
        wheelSpeed: 50,
        minScrollbarLength: 20,
        suppressScrollX: true
    });

	var auto_refresh = setInterval(function (){ refreshSession(); }, 10000);			
});
</script>	