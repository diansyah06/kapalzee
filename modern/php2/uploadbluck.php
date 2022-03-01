<?php
$pagenum_id=17;
$Users->cekSecuritypeage($user_id,$pagenum_id);

			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");



?>
<script src="js/ogs.js" type="text/javascript"></script>
	<div class="page-header">
								<h1>Document<small> upload</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
<div class="tabbable">
								<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
									<li class="active" id="taboverview" >
										<a data-toggle="tab" href="#panel_overview">
											upload
										</a>
									</li>

									<li>
										<a data-toggle="tab" href="#meeting" onClick="refresheditbulk();">
											Edit
										</a>
									</li>
									<li>
										<a data-toggle="tab" href="#motong"  onclick="refreshmoderationbulk();">
											moderation
										</a>
									</li>
									
									
								</ul>
								<div class="tab-content">
					<div id="panel_overview" class="tab-pane in active">					
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
											
										<select id="topicElement" class="form-control" readonly >
										
											
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
										<input type="hidden" name="modul" id="modul" value="uploadbluck" readonly="readonly" />
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
					
					<div class="panel panel-default">
								<?php echo writePanel("List uploads"); ?>
								<div class="panel-body">

										<p>
										</p>
					<div class="row">
					<div class="refreshgalery" id="refreshgalery">
					
					
					
					</div>
					</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>

					
					</div>
<div id="meeting" class="tab-pane">
				<form id='form1' name='form1' method='post' action=''>
				<input type="hidden" name="modul" id="modul" value="uploadbluck" readonly="readonly" />
				<input type="hidden" name="act" id="act" value="editupload" readonly="readonly" />
<div id="editing" class="editing">edort</div>

                    <table>
                      <tr>
                        <td>
                          <input type="button" name="Submit2" value="Check All" onClick="checkAll();" />
                        </td>
                        <td><input type="button" name="Submit3" value="uncheck All"  onclick="uncheckAll();" /></td>
                        <td>
                          <input type="submit" name="Submit" value="Submit"  />
                        </td>
                      </tr>

                    </table>
					</form>
					
</div>	
<div id="motong" class="tab-pane">
				<form id='form2' name='form2' method='post' action=''>
				<input type="hidden" name="modul" id="modul" value="uploadbluck" readonly="readonly" />
				<input type="hidden" name="act" id="act" value="modtupload" readonly="readonly" />
<div id="moderation" class="moderation">kucrut</div>
                    
					<table>
                      <tr>
                        <td>
                          <input type="button" name="Submit2" value="Check All" onClick="checkAll();" />
                       </td>
                        <td><input type="button" name="Submit3" value="uncheck All"  onclick="uncheckAll();" /></td>
                        <td>
                          <input type="submit" name="Submit" value="Submit" />
                        </td>
                      </tr>

                    </table>
					</form>
								
</div>						
					</div>
					</div>
					
					
					<div class="row">
						<div class="col-sm-12"></div>
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
				  <script language="JavaScript">

function checkAll()
{
 var cbs = document.getElementsByTagName('input');
 for(var i=0; i < cbs.length; i++)
 {
    if(cbs[i].type == 'checkbox')
    {
        cbs[i].checked = true;
     }
 }
}

function uncheckAll()
{
 var cbs = document.getElementsByTagName('input');
 for(var i=0; i < cbs.length; i++)
 {
    if(cbs[i].type == 'checkbox')
    {
        cbs[i].checked = false;
     }
 }
}
</script>		
			<!-- end: PAGE -->
					
						<script>
			jQuery(document).ready(function() {
				Main.init();
				
				UIButtons.init();
				refreshuploadbulk();
			});
			
			
			//Program a custom submit function for the form
			$("form#galery").submit(function(event){
			 
			  //disable the default form submission
			  event.preventDefault();
			 
			  //grab all form data  
			  var formData = new FormData($(this)[0]);

			  $.ajax({
				url: 'process-ogs.php',
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
			
			$("form#form1").submit(function(event){
			 
			  //disable the default form submission
			  event.preventDefault();
			 
			  //grab all form data  
			  var formData = new FormData($(this)[0]);

			  $.ajax({
				url: 'process-ogs.php',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (html) {
			$('.editing').html(html);
			$(".editing").hide();
			$(".editing").fadeIn(400);}
			  });
			 
			  return false;
			});


			$("form#form2").submit(function(event){
			 
			  //disable the default form submission
			  event.preventDefault();
			 
			  //grab all form data  
			  var formData = new FormData($(this)[0]);

			  $.ajax({
				url: 'process-ogs.php',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (html) {
			$('.moderation').html(html);
			$(".moderation").hide();
			$(".moderation").fadeIn(400);}
			  });
			 
			  return false;
			});
			
		</script>
		