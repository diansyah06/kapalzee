<?php
$pagenum_id=20;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			


?>

	<div class="page-header">
								<h1>Rules Public<small> all rules</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					
					<div class="row">
						<div class="col-sm-12"></div>
					</div>
					<div class="row">
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List document"); ?>
								<div class="panel-body">
								
								
 <form id="form1" name="form1" method="post" action="">
  <label>
  <input type="checkbox" name="checkbox" id="cekall" value="all" onclick="load_rulepub();" />
  <span class="meraha">See Everything</span></label>
  <label></label><label>
  <input name="radiobutton" type="radio" onclick="load_rulepub();" value="0" checked="checked" />
  View All</label>
  <label>
  <input name="radiobutton" type="radio" onclick="load_rulepub();" value="1" />
  Rules</label>
  <label>
  <input name="radiobutton" type="radio" value="2" onclick="load_rulepub();" />
  Guidelines</label>
  <label>
  <input name="radiobutton" type="radio" value="3" onclick="load_rulepub();" />
  Guidance</label>
  <label>
  <input name="radiobutton" type="radio" value="4" onclick="load_rulepub();" />
  Reference Noted</label>
</form>

<p></p>
								
								<div id="ruless" class="ruless" >
								
								
								<?php
								
$Statuss=array("Error","Active", "No  Publish", "Obsolete");
$JenisTechnical_paper=array("Error","Rules", "Guidelines", "Guidance", "Reference Note");
// jika 0 tampilkan semua

$rulepubss=$rms->list_rules_pub($Load_tipe,$Load_all);

	echo "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
	<th>No </th>
	<th>ID </th>
	<th>Rules ID</th>
	<th>Technical Papaer </th>
	<th>Year </th>
	<th>Part</th>
	<th>Vol </th>
	<th>Type </th>
	<th>Link </th>
	<th>Status</th>
	<th>Action</th>
	</tr></thead><tbody>";

	$no=1;
	foreach ($rulepubss as $rulepubs) {
	 echo 							"<tr>
									<td >$no</td>
									
									<td><a href='panel.php?module=viewrules&id=$rulepubs[id]'>". $rulepubs['id'] ."</a></td>
									<td><a href='panel.php?module=viewrules&id=$rulepubs[id]'>" . $rulepubs['id_rules'] . "</a></td>
									<td><a href='panel.php?module=viewrules&id=$rulepubs[id]'  target='_blank' >". $rulepubs['nama']. "</a></td>
									<td>" . $rulepubs['tahun'] . "</td>
									<td>". $rulepubs['part']. "</td>
									<td>". $rulepubs['vol']. "</td>
									<td>". $JenisTechnical_paper[$rulepubs['tipe']]."</td>
									<td>". $rulepubs['link']."</td>
									<td>". $Statuss[$rulepubs['status']]."</td>
									<td><a href=# onclick='Update_status(". $rulepubs['id'].",1);'>P </a> <a href=# onclick='Update_status(". $rulepubs['id'].",2);'>N </a> <a href=# onclick='Update_status(". $rulepubs['id'].",3);'>O </a> <a href=# onclick='dell_status(".$rulepubs['id'].");'>D </a></td>
									
									</tr>";

	
	$no++ ;
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