<?php
$pagenum_id=21;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			


?>
	<div class="page-header">
								<h1>Document<small> document keeper</small></h1>
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
								<?php echo writePanel("Upload document"); ?>
								<div class="panel-body">
									<form class="form-horizontal" id="galery" action="#">
										
										<div class="form-group">
											<div class="col-sm-4">
												<label>
													Advanced
												</label>
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
												<label>
											Associated :
										</label>
										<input name="textfield32" type="text" class="country form-control" id="textfield3" onblur="fill();" onkeyup="suggest(this.value,<?php echo intval($_GET[id]). ", " . intval($_GET[point]);?>);" size="100"  autocomplete="off">      	
	  <div class="suggestionsBox" id="suggestions" style="display: none;"></div>
	
        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
		
		<input type="text" name="textfield" id="textfield"  class="form-control" disabled="disabled" required/>
										<input type="hidden" name="tipekegiatan" id="tipekegiatan" />
										<input type="hidden" name="idKegiatan" id="idKegiatan" />
										<input type="hidden" name="modul" id="modul" value="document" readonly="readonly" />
										<input type="hidden" name="act" id="act" value="add" readonly="readonly" />
										<p></p>
										
								
												<button data-style="expand-right" class="btn btn-teal ladda-button"  type="submit" >
											<span class="ladda-label"> Start upload </span>
											<i class="fa fa-arrow-circle-right"></i>
											<span class="ladda-spinner"></span>
										<span class="ladda-spinner"></span><div style="width: 0px;" class="ladda-progress"></div></button>
										
											</div>
										</div>
										
		
										
										
										
									</form>
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
								<?php echo writePanel("List document"); ?>
								<div class="panel-body">
								<div id="document" class="document">
								<?php echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > No</th>
												<th > Name</th>
												<th > Type</th>
												
												<th > Action</th>

											</tr>
										</thead>
										<tbody>"; 
										$n=1;
										$DocumentLists=$Activity->getdocGalery(2);
										foreach($DocumentLists as $DocumentList ){
										
										
										echo " <tr>
												<td>$n</td>
												<td><a href='$DocumentList[path]' target='_blank' > $DocumentList[nama]</a></td>
												<td >Document</td>
												
												<td >
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a onClick='changeModalDocument($DocumentList[id], &#39;$DocumentList[nama]&#39;);' href='#responsive' data-toggle='modal' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
												
													<a onClick='Deldocument($DocumentList[id])' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
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
					
					
					<!-- start: BOOTSTRAP EXTENDED MODALS -->
		<div id="responsive" class="modal fade" tabindex="-1" data-width="360" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Update name Of picture</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<h4>Caption</h4>
						<p>
							<input class="form-control" type="text" id="namadocument">
						</p>
						
						<input name="idPicture" id="iddocument" type="hidden"  />
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="updatedocument();">
					Save changes
				</button>
			</div>
		</div>
			<!-- end: PAGE -->
					
						<script>
			jQuery(document).ready(function() {
				Main.init();
				TableData.init();
			});
			
			
			//Program a custom submit function for the form
			$("form#galery").submit(function(event){
			 
			  //disable the default form submission
			  event.preventDefault();
			 
			  //grab all form data  
			  var formData = new FormData($(this)[0]);
			 
			  $.ajax({
				url: 'process.php',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (html) {
			$('.document').html(html);
			$(".document").hide();
			$(".document").fadeIn(400);}
			  });
			 
			  return false;
			});
			
		</script>	