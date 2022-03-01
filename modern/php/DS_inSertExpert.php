<?php
include "../class/CdamageS.php";
$pagenum_id=7;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
		
$listExperts=$DSR->getdbExpertlist();			
			
			
			
?>
	<script src='js/ds_script.js'></script>	

					<div class="page-header">
								<h1>Jalapati <small>Advance Surveyour Tools</small></h1>
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
								<?php echo writePanel("Insert Database Expert"); ?>
								<div class="panel-body">
								
										<form role="form" class="expert form-horizontal" id="expert" action="#" >

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Case Name :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Name case" name="casename" id="casename" class="form-control" ruquired >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Source :
											</label>
											<div class="col-sm-9">
											<select id="sourceClass" class="sourceClass form-control"  name="sourceClass" >
											
											<option value="1">BKI</option>
											<option value="2">IACS</option>
											<option value="3">DNV</option>
											<option value="4">GL</option>
											<option value="5">KR</option>
											<option value="6">NK</option>
											<option value="7">ABS</option>
											<option value="8">RINA</option>
											<option value="9">Other</option>

										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Type of Ship :
											</label>
											<div class="col-sm-9">
												<select id="kojek" name="kojek" class="kojek form-control" >
										
											<option value="1">Tanker</option>
											<option value="2">Bulk carrier</option>
											<option value="3">Container</option>
											<option value="4">Tug boat</option>
											<option value="5">Ferry</option>
										</select>
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Cause Property :
											</label>
											<div class="col-sm-9">
										<?php 
										
										echo $DSR->createMenuComboBydatabasenameonname("kasus_prop", "Cause Property");
										
										?>

											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Cause Area :
											</label>
											<div class="col-sm-9">
												<select id="CA" name="CA" class="CA form-control" >
										

										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Specific :
											</label>
											<div class="col-sm-9">
												<select id="SP" name="SP" class="SP form-control" >
										

										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												More Specifik :
											</label>
											<div class="col-sm-9">
												<select  id="specipik" name="specipik"  class="specipik form-control" >
										

										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												type of damage :
											</label>
											<div class="col-sm-9">
										<select  id="damages" name="damages" class="damages form-control" >
										

										</select>
											</div>
										</div>										
										
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Description how become :
											</label>
										  <div class="col-sm-9">
												<textarea placeholder="Description of training here" id="pesanndee" name="pesanndee" class="ckeditor form-control"></textarea>
											    <label>
											   
											    </label>
												<p>

											</p>
											</div>
											
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Counter measure :
											</label>
										  <div class="col-sm-9">
												<textarea placeholder="Description of training here" id="countermeasure" name="countermeasure" class="ckeditor form-control"></textarea>
											    <label>
											   
											    </label>

											</div>
											
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												BKI rules correlation :
											</label>
										  <div class="col-sm-9">
												<textarea placeholder="Description of training here" id="bkicorel" name="bkicorel" class="form-control" ></textarea>

											</div>

										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Sketch :
											</label>
											<div class="col-sm-9">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-group">
														<div class="form-control uneditable-input">
															<i class="fa fa-file fileupload-exists"></i>
															<span class="fileupload-preview"></span>
														</div>
														<div class="input-group-btn">
															<div class="btn btn-light-grey btn-file">
																<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select file</span>
																<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
																<input type="file" class="file-input" name="item_file[]" multiple=""  >
															</div>
															<a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
																<i class="fa fa-times"></i> Remove
															</a>
														</div>
													</div>
												</div>
																								
											
											
											<p>

											</p>
											<p>
										<button data-style="expand-right" class="btn btn-teal ladda-button"  type="submit" >
											<span class="ladda-label"> Submit </span>
											</p>

												</div>

										</div>
<div class="form-group">										
											<div class="col-sm-9">											<p>
										<button type="button" class="btn btn-primary" >
											Foto Synk
										</button>
										</p>	
										</div>
										</div>
										<input type="hidden" name="modul" id="modul" value="addexpert" readonly="readonly" />
										<input type="hidden" name="act" id="act" value="add" readonly="readonly" />
									</form>	
											
									</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>				
							
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Database Expert"); ?>
								<div class="panel-body">
								<div id="training" class="training">
								<?php echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > no</th>
												<th > ID</th>
												<th > Title</th>
												<th > Type</th>
												<th > Date</th>
												<th > Property</th>
												<th > Area</th>
												<th > Region</th>
												<th > Specific</th>
												<th > Damage</th>
												<th width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										$n=1;
										foreach($listExperts as $listTraining ){
										
										$property=$listTraining['CP'];
										if ($property=="structural_detail_failures"){
											$Region=$listTraining['namStruc'];
										}elseif($property=="general_mesin"){
											$Region=$listTraining['namEng'];
										}else{
											$Region=$listTraining['namElec'];
										}

										 
										
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggal_input']));
										$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
										echo " <tr>
												<td>$n</td>
												<td>$listTraining[id]</td>
												<td title='$listTraining[description]' > <a href='$listTraining[path]' target='_blank'>  $listTraining[title]</a></td>
												<td>$listTraining[Tipe]</td>
												<td>$tanggalPlan</td>
												<td >$property</td>
												<td >$Region</td>
												<td >$listTraining[specifik]</td>
												<td >$listTraining[tipe]</td>
												<td >$listTraining[damagee]</td>
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a  onclick='dellExpert($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
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

		pageDatabaseExpert();
				
			});
		</script>	