<?php
$pagenum_id=23;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			$listUsers=$Users->get_users();

    $proj_id=intval($_GET['id']);
	$draw_id=intval($_GET['draw']);
	$get_draws=$drawing->get_proj_gambar_id($draw_id);
	$getNamaproject=$obj->getprojectNameid($proj_id);
	$get_hist_draws=$drawing->get_UploadStampByidnolimit($draw_id,$proj_id) ;

	$getCommentdrawing=$comment->GetCommentonDrawingid($proj_id,$draw_id);
	
	$statu_s=array("Open","Closed","Info");
	$commentStatus=array('','','Waiting','Publish');
	
	   $strtablle= "<table class='table table-striped table-bordered table-hover' id='sample_1'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Title </th>
											<th>rev</th>
											<th>Masuk</th>
											<th>by</th>
											<th>review</th>
											<th>approved</th>
											<th>open</th>
																						
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	

	foreach ($get_hist_draws as $get_hist_draw) {

	$perant=$proj_id . "," . $get_hist_draw['id']. "," . $draw_id  ;
	
	 $strtablle=$strtablle. 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td > " . $get_hist_draw['nodrawing']. "</td>
									<td >". $get_hist_draw['gambar'] . " </a></td>
									<td >".  $get_hist_draw['rev']. "</td>
									<td>" . $get_hist_draw['tanggal'] . "</td>
									<td>" . $alluserArray[$get_hist_draw[userid]]  . "</td>
									<td>" . $get_hist_draw[reviewdate]  . "</td>
									<td>" . $alluserArray[$get_hist_draw[review]]  . "</td>

									<td>" . "<a href='enginerrview.php?module=stamp&kon=". $proj_id. "&gam=$get_hist_draw[id]' target=_blank>" . "Open</a>" ."</td>
								
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	$strtablle=$strtablle.  "</tbody></table>";			

	$strComment= "<table class='table table-striped table-bordered table-hover' id='sample_1'>
									<thead>
										<tr>
											<th>No</th>
											<th>Num </th>
											<th>Date</th>
											<th>Review </th>
											<th>rev</th>
											<th>status</th>
											<th>point</th>
																						
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	

	foreach ($getCommentdrawing as $get_hist_draw) {

	
	
	 $strComment=$strComment. 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td > <a target=_blank href='panel.php?module=replaycom&id=$proj_id&com=$get_hist_draw[id_comment]'>" . $get_hist_draw['nomer_comment']. "</a></td>
									<td >". $get_hist_draw['tanggal'] . " </a></td>
									<td >".  $alluserArray[$get_hist_draw['create_by']]. "</td>
									<td>" . $get_hist_draw['revisi'] . "</td>
									<td>" . $statu_s[$get_hist_draw['status']] . "</td>
									<td>" . $commentStatus[$get_hist_draw['point']] . "</td>
								
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	$strComment=$strComment.  "</tbody></table>";



	//list drawing revision 

	$get_hist_draws=$drawing->get_histori_gambar($draw_id,$proj_id) ;
	
	
	   $strtabllerevisiion= "<table class='table table-striped table-bordered table-hover' id='sample_1'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Title </th>
											<th>revisi</th>
											<th>Masuk</th>
											<th>Drawing</th>
											<th>Open</th>
											<th>Action</th>
																						
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($get_draws as $get_draw) {
	$nama_gam=$get_draw['judul'] ;
	$no_gam=$get_draw['no_gambar'] ;
	}
	foreach ($get_hist_draws as $get_hist_draw) {
	$z=$get_draw['tipe'];
	if ($get_hist_draw['alamat']=="none"){ $edraw="No avaible" ; }else { $edraw="Avaible" ; }
	
	$perant=$proj_id . "," . $get_hist_draw['id']. "," . $draw_id  ;
	
	 $strtabllerevisiion=$strtabllerevisiion. 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td > " . $no_gam. "</td>
									<td >". $nama_gam . " </a></td>
									<td >".  $get_hist_draw['revisi']. "</td>
									<td>" . $get_hist_draw['tanggal'] . "</td>
									<td>" . $edraw . "</td>
									<td>" . "<a href='enginerrview.php?module=re&kon=$proj_id&gam=$get_hist_draw[id]'" .  "target='_blank'>" . " Open</a> " ."</td>
									<td> <a href='#'  onclick=". "fung_del_gambar_rev(" . $perant ."); > Delete </a> "  . "</td>									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	$strtabllerevisiion=$strtabllerevisiion.  "</tbody></table>";		


?>
<script src="js/kontrak-po.js" type="text/javascript"></script>
<script src="js/ogs.js" type="text/javascript"></script>
	<div class="page-header">
								<h1>Project<small> <?php echo "<a href='panel.php?module=projectMod&idproj=$proj_id'>" . $getNamaproject . "</a>" ; ?></small></h1>
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
								<?php echo writePanel("List Revision"); ?>
								<div class="panel-body">

										<p>
										</p>
								<div id="project" class="project" >	
									<?php echo $strtabllerevisiion ; ?>
								
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Stamp"); ?>
								<div class="panel-body">

										<p>
										</p>
								<div id="project" class="project" >	
									<?php echo $strtablle ; ?>
								
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
						<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List comment"); ?>
								<div class="panel-body">

										<p>
										</p>
								<div id="drawing_comment" class="drawing_comment" >	
									<?php echo $strComment ; ?>
								
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
					
					
					
						<!-- start: BOOTSTRAP EXTENDED MODALS -->
		
			<!-- end: PAGE -->
					
						<script>
			jQuery(document).ready(function() {
				Main.init();
				TableData.init();


				
				
				
			});
			
			
		</script>	