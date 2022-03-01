<?php
$pagenum_id=9;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("profile");
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("button");
			echo set_java_script_plugin_load ("table");
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("summer");


$idEvent=$_GET['id'];
$salting = $_SESSION['salt'];
//get info Event
$listEvents=$kpi->getproposalbyID($idEvent);

foreach ($listEvents as $listEvent){
	$description= $listEvent['proposal'] ;
	$titleEvent=$listEvent['judul'] ;
	$peoplelist=$listEvent['peneliti'];
	$peoplelist=substr($peoplelist, 1); // hilangkan , dalam huruf pertama
	$cost=$listEvent['cost'];
	$status=$listEvent['status'];
	
	$topic= $listEvent['type'] ;
	$createby=$listEvent['oleh'];
	$dateStart=date("d M Y",strtotime($listEvent['start'])) ;
	$dateEnd=date("d M Y",strtotime($listEvent['end'])) ;
	$dateLAstUpdate=date("d M Y H:i",strtotime($listEvent['update_on'])) ;
	$updateBy=$listEvent['update_by'];
}




?>
<script src='js/plan.js'></script>
							<div class="page-header">
								<h1>Proposal <small>discussion <?php echo "<a href='panel.php?module=Seleksi' > " . $titleEvent  . "</a>" ; ?></small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					
					<div class="row">
						<div class="col-md-8">
							<!-- start: BLOCKQUOTES PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-quote-left"></i>
									Proposal 
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="icon-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="icon-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="icon-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="icon-remove"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">

			
									<div id="inline-column1" >
									<div id="<?php echo $idEvent ; ?>" <?php if (($user_id == $createby ) || ($salting > 4)){ echo "contenteditable='true'" ; }?>>
										
											<?php echo $description ;?>
										
									</div>	
									</div></p>	
									<blockquote>	<small><cite title="Source Title"><?php echo $alluserArray[$updateby] ; ?></cite></small>
									</blockquote>
									<div class="clearfix">
										<blockquote class="pull-right">

											<small>Last Update <cite title="Source Title"> <?php echo $dateLAstUpdate . " by " .  $alluserArray[$updateBy];?></cite></small>
										</blockquote>
									</div>

									
									
									<hr>
									</hr>
						<strong>Comments: </strong>
						<p>
						<div id="commenting" class="commenting">
						<ol class="discussion">
						
						<?php 
						$listcommens=$kpi->getCommentproposal($idEvent);
						$n=1 ;
						foreach($listcommens as $listcommen){
						if ($n % 2) { $classs="other";
						}else {
						$classs="self"; 
						}
						$namaPengirim=$alluserArray[$listcommen['oleh']];
							echo "
												<li class='$classs'>
													<div class='avatar'>
														<img width='50px' alt='' src='" . "../" . $listcommen['path'] . "'>
													</div>
													<div class='messages'>
														<p>
															$listcommen[text]
														</p>
														<span class='time'><small>Posted on ". date("d/m/Y H:i",strtotime($listcommen['created_on'])) . " by  <a href:'' >$namaPengirim</a></small></span>
													</div>
												</li>";
								$n++;				
							}					
						?>						
												
						</ol>
										</div>	
						<hr>
						</hr>
									
						<strong>Post comment </strong>
					<textarea placeholder="Insert Comment Here" id="messageComment" class="form-control expand" required></textarea>	
					<p>
					</p>
<button type="button" class="btn btn-green" onclick="addCommentproposal(<?php echo $idEvent ;?>);">
											Post Comment
										</button>					

								</div>
							</div>
							<!-- end: BLOCKQUOTES PANEL -->
							<!-- start: WELLS PANEL -->
							
							<!-- end: WELLS PANEL -->
							<!-- start: DESCRIPTIONS PANEL -->
							<!-- end: DESCRIPTIONS PANEL -->
						</div>
						<div class="col-md-4">
							<!-- start: UNORDERED LISTS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-reorder"></i>
									Action
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="icon-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="icon-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="icon-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="icon-remove"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">

										<li>
											<a href='#responsive' data-toggle='modal' > Edit</a> 
										</li>
										<li>
											<a href='#Buzz' data-toggle='modal' > Buzz</a> 
										</li>
										<li>
											<a href='downloadprop.php?id=<?php echo $idEvent ; ?>&html=1' target='_blank'>Download as html</a>
										</li>
										<li>
											<a href='downloadprop.php?id=<?php echo $idEvent ; ?>&html=0' target='_blank' >Download as docx</a>
										</li>										
										<li>
											<a onClick="Approveproposal(<?php echo $idEvent ; ?>);"> Approve</a>
										</li>										<li>
											<a onClick="Unapprovaeproposal(<?php echo $idEvent ; ?>);"> unApprove</a>
										</li>
								</div>
							</div>
							<!-- end: UNORDERED LISTS PANEL -->
							<!-- start: ORDERED LISTS PANEL -->
							
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-reorder"></i>
									Info
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="icon-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="icon-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="icon-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="icon-remove"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
								<div id="infoo" class="infoo" >
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Item</th>
												<th>Info</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><span class="label label-default"> Title</span></td>
												<td><code> <?php echo $titleEvent ; ?> </code></td>
											</tr>
											<tr>
												<td><span class="label label-success"> Topic</span></td>
												<td><code> <?php echo $typebidangArray[$topic]; ?>  </code></td>
											</tr>
											<tr>
												<td><span class="label label-warning"> Duration</span></td>
												<td><code> <?php echo $dateStart . " to " . $dateEnd ;?> </code></td>
											</tr>
											<tr>
												<td><span class="label label-danger"> Cost</span></td>
												<td><code> <?php echo thousandsCurrencyFormat($cost) ;?>  </code></td>
											</tr>
											<tr>
												<td><span class="label label-info"> Status</span></td>
												<td><code> <?php echo $typeStatus[$status]; ?> </code></td>
											</tr>											<tr>
												<td><span class="label label-success"> Team</span></td>
												<td><code> <?php
												$pieces=explode(",",$peoplelist);
										
										foreach ($pieces as $piece){
										
										echo "<li><a href='./panel.php?module=profile&id=$piece' >" . $alluserArray[$piece] . "</a> </li>";
										} ?> </code></td>
											</tr>

										</tbody>
									</table>
								</div>
								</div>
							</div>							
							<!-- end: ORDERED LISTS PANEL -->
							<!-- start: UNSTYLED LISTS PANEL -->
							<!-- end: UNSTYLED LISTS PANEL -->
							<!-- start: INLINE LIST PANEL -->
							
							<!-- end: INLINE LIST PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
					
					
					
				</div>
			</div>
			<!-- end: PAGE -->
			
			<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Edit Proposal</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Title
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Title of research" id="title" class="form-control" value="<?php echo $titleEvent ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-3" >
												Type
											</label>
											<div class="col-sm-9">
										
										<select id="typeplan" class="form-control" >
										<?php 
										
										$n=0;
										foreach  ( $typebidangArray  as $typebidangArra){
											if ($topic==$n){
											echo "<option value='$n' selected>$typebidangArra</option>" ;
											}else{											
											
											echo "<option value='$n'>$typebidangArra</option>" ;
											}
										$n++;	
										}
										
										?>

										
										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-4" >
												Cost
											</label>
											<div class="col-sm-9">
												<input type="costplan" placeholder="Text Field" id="costplan" class="form-control" value="<?php echo $cost ; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-5" >
												Resecher
											</label>

											<div class="col-sm-9">
												<select multiple="multiple" id="penelitiplan" class="form-control search-select" name="sapi[]">
											<?php 
											
											
										
										
										foreach ($pieces as $piece){
										
										echo "<option value='$piece' selected > $alluserArray[$piece]</option>" ;
										}
										

											foreach($listUsers as $listUser){
											$arrasu=$arrasu . "," . $listUser['id_user'] ;
											}
											
											$pieces2=explode(",",$arrasu);
											$results = array_diff( $pieces2,$pieces);											
											
											
											foreach($results as $result){
											
											echo "<option value='$result'>$alluserArray[$result]</option>"   ;
											
											}  ?>
											
										</select>
											</div>											
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-6">
												Start
											</label>
											<div class="col-sm-9">
													<span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
												<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="start" value="<?php echo date("d-m-Y",strtotime($dateStart))  ; ?>">
												
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-7">
												due
											</label>
											<div class="col-sm-9">
													<span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
												<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="due" value="<?php echo date("d-m-Y",strtotime($dateEnd))  ; ?>">
												
											</div>
										</div>
									</form>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="EditProposal(<?php echo $idEvent ; ?>);">
					Save changes
				</button>
			</div>
		</div>
		
		
		
		<div id="Buzz" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">get Atention SM</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Message
											</label>
											<div class="col-sm-9">
												<textarea placeholder="Write Message Here" id="buzz" class="form-control" rows='8'></textarea>
											</div>
										</div>
										
									</form>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="Sendbuzz(<?php echo $idEvent ; ?>);">
					Save changes
				</button>
			</div>
		</div>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				
				
				 CKEDITOR.disableAutoInline = true;
				 
				 			$('textarea.expand').focus(function () {
    $(this).animate({ height: "10em" }, 500);
});

				$("div[contenteditable='true']" ).each(function( index ) {

					var content_id = $(this).attr('id');
					
					
					

					CKEDITOR.inline( content_id, {
						on: {
							blur: function( event ) {
								var data = event.editor.getData();
								
								var request = jQuery.ajax({
									url: "process.php",
									type: "POST",
									data: {
										content : data,
										content_id : content_id,
										modul : "propdiscus",
										act : "proposal"
										
									},
									dataType: "html"
								});

							}
						}
					} );

				});
				
				
				$(".search-select").select2({
            placeholder: "Select a Participant",
            allowClear: true
        });		
				
		 $('.date-picker').datepicker({
            autoclose: true
        });
				
				
				
				
				
			});
		</script>
	</body>
	<!-- end: BODY -->
