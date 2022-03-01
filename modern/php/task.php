<?php
$pagenum_id=15;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");




?>



<div class="page-header">
								<h1>Social <small>Task and job</small></h1>
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
								<?php echo writePanel("Input task list to-do"); ?>
								<div class="panel-body">
									<div class="form-group">
										<label for="form-field-22">
											Todo :
										</label>
										<input type="text" placeholder="Work To do" id="todo" class="form-control">
									</div>
									<div class="form-group">
											<label for="form-field-22">
												Due :											</label>
											
											<span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
											<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="tanggalan">
												
											
										</div>
									<div class="form-group">
										<label for="form-field-23">
											Associated :
										</label>
										<input name="textfield32" type="text" class="country form-control" id="textfield3" onblur="fill();" onkeyup="suggest(this.value,<?php echo intval($_GET[id]). ", " . intval($_GET[point]);?>);" size="100"  autocomplete="off">      	
	  <div class="suggestionsBox" id="suggestions" style="display: none;"></div>
	
        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
		
		<input type="text" name="textfield" id="textfield"  class="form-control" disabled="disabled" required/>
										<input type="hidden" name="tipekegiatan" id="tipekegiatan"  />
										<input type="hidden" name="idKegiatan" id="idKegiatan" />
									</div>
									<div>
										<label for="form-field-24">
											Description :
										</label>
										<textarea placeholder="Default Text" id="form-field-22" class="form-control"></textarea>
									</div>
									<div>
									<p></p>
									<a class="btn btn-blue"  onclick="addTask();"><i class="fa fa-plus"></i>
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
								<?php echo writePanel("List urgen Todo"); ?>
								
								<div class="panel-body panel-scroll" style="height:300px">
								
									<ul class="todo">
								<div id="taskrefresh" class="taskrefresh">	
									<?php
								
									foreach($listUrgents as $listUrgent ){
									

									
									echo StyleTask($listUrgent['due'],$listUrgent['id'],$listUrgent['pekerjaan'],$listUrgent['tipeKegiatan'],$listUrgent['idKegiatan']);
										
									}
									
									?>
									
									</div>	
									</ul>
									
								</div>
								
								</div>
							</div>
							<!-- end: SELECT BOX PANEL -->
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Todo"); ?>
								<div class="panel-body">
								<div id="task" class="task">
								<?php 
								
								echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > ID</th>
												<th > To do </th>
												<th > Related </th>
												<th > due</th>
												
												<th > Action</th

											</tr>
										</thead>
										<tbody>"; 
										$n=1;
										$listTodos= $Activity->getTaskbyidUser($user_id,1000);
										foreach($listTodos as $listTodo ){
										//$label= labelStyle($listTraining[status],$listTraining[status]);
										
										//$taskStart = date("M d , Y", strtotime($listTodo[finish]));
										
										$taskEnd =date("M d , Y", strtotime($listTodo[due]));
										
										if ($listTodo[finish]=="0000-00-00 00:00:00"){
										$taskEnd=Getbadge($taskEnd,0);
										}else{
										$taskEnd=Getbadge($taskEnd,1);
										}
										
										if ($listTodo[tipeKegiatan]=="3"){
										$relatedProject= "project : " . $listTodo[project];
										}elseif($listTodo[tipeKegiatan]=="2"){
										$relatedProject=$listTodo[training];
										}else{
										
										$relatedProject="no related";
										}
										
										echo " <tr>
												<td>$n</td>
												<td title='$listTodo[desck]'>$listTodo[pekerjaan]</td>
												<td >$relatedProject</td>
												<td title='done at $listTodo[finish]'>$taskEnd</td>
												
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a href=''  onclick='dellTask($listTodo[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
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


	<script>
			jQuery(document).ready(function() {

				Main.init();
				
				TableData.init();
				    //function to initiate daterangepicker
  
        $('.date-picker').datepicker({
            autoclose: true
        });
		
		$('.drop-down-wrapper').perfectScrollbar({
        wheelSpeed: 50,
        minScrollbarLength: 20,
        suppressScrollX: true
    });

				
});
</script>				