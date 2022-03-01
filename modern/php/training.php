<?php
$pagenum_id=14;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
		
			
			
			$listUsers=$Users->get_users();
			
?>
		


					<script src='js/modern.js'></script>

					<div class="page-header">
								<h1>Event <small>capturing all of your important moments</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
			<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					
					<div class="row">
						
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Insert Training"); ?>
								<div class="panel-body">
								
										<form role="form" class="form-horizontal">
										<script> function getnilai(){
										
										var str="",i;
var abc ="" ;										
var e = document.getElementById("form-field-select-4");										

var c=document.getElementById("schedule").value;
var a=c.value ;	

for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        str = str + i + " ";
		
		abc= abc + e.options[i].value  ;
    }
}

alert("Options selected are " + abc);
alert("dataerange " + c);

		
		
var strUser = e.options[e.selectedIndex].value;
		alert (strUser[1]);
		} </script>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Event Name :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Name of Event" id="form-field-1" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Type of Event :
											</label>
											<div class="col-sm-9">
												<select id="form-field-select-3" class="form-control" >
										
											<option value="1">Training</option>
											<option value="2">Conference</option>
											<option value="3">GlaD</option>
											<option value="4">Schoolarship</option>
											<option value="5">Committee</option>
											<option value="6">Seminar</option>
											<option value="7">Presentation</option>
											<option value="8">Meeting</option>
											<option value="9">launcing</option>
											<option value="10">Other</option>

										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Type of topic :
											</label>
											<div class="col-sm-9">
												<select id="form-field-select-1" class="form-control" >
										
											<option value="1">Structure</option>
											<option value="2">Stability</option>
											<option value="3">Machinery</option>
											<option value="4">Offshore</option>
											<option value="5">Other</option>

										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Schedule :
											</label>
											<div class="col-sm-9">
											<span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>
											<input type="text" id="schedule" class="form-control date-time-range">
										</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Realization :
											</label>
											<div class="col-sm-9">
											<span class="icol-sm-9-addon"> <i class="fa fa-calendar"></i> </span>
											<input type="text" class="form-control date-time-range" id="realization">
										</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Participant :
											</label>
											<div class="col-sm-9">
											<select multiple="multiple" id="form-field-select-4" class="form-control search-select" name="sapi[]">
											<?php foreach($listUsers as $listUser){
											
											echo "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
											
											} 
											echo "<option value='0'>ALL RND Member</option>";
											?>
											
										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Location :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Place that event held" id="location" class="form-control">
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Description :
											</label>
										  <div class="col-sm-9">
												<textarea placeholder="Description of training here" id="pesanndee" name="pesanndee" class="ckeditor form-control"></textarea>
											    <label>
											   
											    </label>
												<p>
										<a class="btn btn-blue"  onclick="addTraining(0);"><i class="fa fa-plus"></i>
											Submit Entry</a>
											</p>
											</div>
											
										</div>
										
										
										
									</form>	
											
									</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>				
							
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Training"); ?>
								<div class="panel-body">
								<div id="training" class="training">
								<?php echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > ID</th>
												<th > Title</th>
												<th > Event</th>
												<th > Plan</th>
												<th > Participant</th>
												<th > Status</th>
												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										$listTrainings= $kpi->getTraining();
										
										$n=1;
										foreach($listTrainings as $listTraining ){
										
										$peserta= Extractusername($alluserArray,$listTraining[peserta]);
										$titlePeserta=$peserta;
										if (strlen($peserta)>50){
										
										$peserta=substr($peserta,0,50) . ".." ;
										}									
										 
										$label= labelStyle($listTraining['status'],$listTraining['tanggalStart']);
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggalStart']));
										$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
										echo " <tr>
												<td>$n</td>
												<td title='$listTraining[description]' > <a href='panel.php?module=dEvent&id=$listTraining[id]' >  $listTraining[training]</a></td>
												<td>$nameEvent</td>
												<td>$tanggalPlan</td>
												<td title='$titlePeserta'>$peserta</td>
												<td title='held at : $listTraining[realisasiStart]'>$label</td>
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='dellTraining($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
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
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			
			<!-- start: BOOTSTRAP EXTENDED MODALS -->
		<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Responsive</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<h4>Some Input</h4>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
					</div>
					<div class="col-md-6">
						<h4>Some More Input</h4>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue">
					Save changes
				</button>
			</div>
		</div>
			<!-- end: PAGE -->
	<script>
			jQuery(document).ready(function() {

				Main.init();
				
				TableData.init();
				CKEDITOR.disableAutoInline = true;
				$('textarea.ckeditor').ckeditor();

        $(".search-select").select2({
            placeholder: "Select a Participant",
            allowClear: true
        });

		    //function to initiate daterangepicker
  
        $('.date-range').daterangepicker();
        $('.date-time-range').daterangepicker({
            timePicker: true,
            timePickerIncrement: 15,
            format: 'MM/DD/YYYY h:mm A'
        });

		
				
			});
		</script>					