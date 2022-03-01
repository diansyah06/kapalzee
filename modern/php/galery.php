<?php
$pagenum_id=17;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("galery");
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			


?>
	<div class="page-header">
								<h1>Gallery<small> responsive photo gallery</small></h1>
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
								<?php echo writePanel("Upload Picture"); ?>
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
												<label >
												Type of topic :
											</label>
											
										<select id="topicElement" class="form-control" >
										
											<option value="2">Event</option>
											<option value="3">Project</option>

										</select>
												<label>
											Associated :
										</label>
										<input name="textfield32" type="text" class="country form-control" id="textfield3" onblur="fill();" onkeyup="suggestproj(this.value,<?php echo intval($_GET[id]). ", " . intval($_GET[point]);?>);" size="100"  autocomplete="off">      	
	  <div class="suggestionsBox" id="suggestions" style="display: none;"></div>
	
        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
		
		<input type="text" name="textfield" id="textfield"  class="form-control" disabled="disabled" required/>
										<input type="hidden" name="tipekegiatan" id="tipekegiatan"   />
										<input type="hidden" name="idKegiatan" id="idKegiatan" />
										<input type="hidden" name="modul" id="modul" value="galery" readonly="readonly" />
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
					<div class="refreshgalery" id="refreshgalery">
					
					<?php
					
					$PictureLists=$Activity->getdocGalery(1);
					
					foreach ($PictureLists as $PictureList) {
					
					$thumbnail=basename($PictureList[path]);
					
					echo "<div class='col-md-3 col-sm-4 gallery-img'>
							<div class='wrap-image'>
								<a class='group1' href='$PictureList[path]' title='$PictureList[nama]'>
									<img src='data/Thumbdata/$thumbnail'  alt='' class='img-responsive'>
								</a>
								<div class='chkbox'></div>
								<div class='tools tools-bottom'>
									<a href='#'>
										<i class='clip-link-4'></i>
									</a>
									<a href='#responsive' data-toggle='modal' onClick='changeModalGalery($PictureList[id], &#39;$PictureList[nama]&#39;);'>
										<i class='clip-pencil-3 '></i>
									</a>
									<a  onClick='Delgalery($PictureList[id]);'>
										<i class='clip-close-2'></i>
									</a>
								</div>
							</div>
						</div>" ;

					}
					
					
					

					
					
					
					?>
					
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
							<input class="form-control" type="text" id="namaPicture">
						</p>
						
						<input name="idPicture" id="idPicture" type="hidden"  />
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="updateGalery();">
					Save changes
				</button>
			</div>
		</div>
			<!-- end: PAGE -->
					
						<script>
			jQuery(document).ready(function() {
				Main.init();
				PagesGallery.init();
				UIButtons.init();
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
			$('.refreshgalery').html(html);
			$(".refreshgalery").hide();
			$(".refreshgalery").fadeIn(400);}
			  });
			 
			  return false;
			});
			
		</script>	