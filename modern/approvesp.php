<?php
include "../functions.php";

include "../sis32/db_connect.php";
sec_session_start();
include "../class/init3.php";
include "../modern.php" ;

if(login_check ($mysqli) == false) {
	echo "<link href='../pengaturan/adminstyle.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../index.php><b>LOGIN</b></a></center>";
	die;}

//get profile user login
	$user_id = $_SESSION['user_id'];
	//$nama_user=$Users->get_users_with_title($user_id); //nama 
	$biodata_users= $Users->getUser_biodata($user_id);
	
	foreach ($biodata_users as $biodata_user) { 
		$displayPicture = "../" . $biodata_user['path'] ; //wajah
		$jabatanUser = $biodata_user['jabatan'] ; 
		$emailUser = $biodata_user['email'] ;
		$hpUer = $biodata_user['handphone'] ;
		$nama_user=$biodata_user['nama'] ;
	}

	//getalluser
	$listUsers=$Users->get_users();
	$alluserArray=array(); // store alluseronarray
	foreach($listUsers as $listUser){
	$idusernya=$listUser['id_user'];
	$alluserArray[$idusernya]=$listUser['nama'];
	}

	//getstamptype 
	$jenistipapprovals= $drawing->GetTipeapprovalDrawing();
	$arrtypeApproval= array(); 
	foreach ($jenistipapprovals as $jenistipapproval) {
		$arrtypeApproval[$jenistipapproval['id_status']]=$jenistipapproval['desck'];
	}


	$idstamp=intval($_GET['idstamp']);
	$id_kon=intval($_GET['projid']);

	$getNamaproject=$obj->getprojectNameid($id_kon);

	$gambars = $drawing->get_UploadStampByid($idstamp,$id_kon);

	foreach ($gambars as $gambar) {
		$id_gambar_current = $gambar['id_gambar'];
	}

	$resultsgambars= $drawing->get_UploadStampByidnolimit($id_gambar_current,$id_kon);

	$no=1 ;
	foreach ($resultsgambars as $gambar) {
		if ($no==1) { // jika satu yang current stamp
			$rev_current= $gambar['rev'];
			$enginer_current =$alluserArray[$gambar['userid']];
			$titleGambar_current= $gambar['gambar'];
			$nogambar_current = $gambar['nodrawing'];
			$ids_curr  = $gambar['id'];
			$dokumenApprovaltype_curr= $arrtypeApproval[$gambar['drawingstatus']];
			$statusCurr = $gambar['status'];

		}elseif ($no==2) { // jika dua previous revision
			$rev= $gambar['rev'];
			$enginer =$alluserArray[$gambar['userid']];
			$titleGambar= $gambar['gambar'];
			$nogambar = $gambar['nodrawing'];
			$ids  = $gambar['id'];
			$dokumenApprovaltype= $arrtypeApproval[$gambar['drawingstatus']] ;
		}


	$no++;
	}

	if($statusCurr == 0)
	{
		$approveMenu = "<label class='col-sm-2 control-label'>
					 
					</label>
					<div class='col-sm-2'>
					<input type='number' placeholder='X' id='x-pos' class='form-control' value = 10>
					</div>
					<div class='col-sm-2'>
					<input type='number' placeholder='Y' id='y-pos' class='form-control' value = 10>
					</div>

                    <div class='col-sm-6'>
                   		<div class='btn-group'>
                    		<input value='Preview' class='btn btn-primary' type='button' onClick='previewStampPos(&#39;preview&#39;, $ids_curr, $id_kon);'> 
                    		<input id='appr-btn' value='Approve' class='btn btn-light-grey' type='button' onClick='approveAll($idstamp, $id_kon);' disabled> 
                    	</div>
                 	</div>";
	}else
	{
		$approveMenu = "";
	}

	$id_subgambar_current= $drawing->GetDrawingSubFromIdStamp($ids_curr);	//get drawing sub id
	$id_subgambar= $drawing->GetDrawingSubFromIdStamp($ids);

	$comment_currents= $comment->Get_allCommentfromIdsubdrawing($id_subgambar_current, $id_kon);	//get comment
	$comment_previous= $comment->Get_allCommentfromIdsubdrawing($id_subgambar, $id_kon);

	$tableHeader =  "<table class='table table-striped table-bordered table-hover' id='sample_6'>
										<thead>
											<tr>
												<th width='100'>No Comment</th>
												<th >Comment </th>
												<th width='100'>Create by</th>
												<th width='50'>Date</th>
												<th width='50'>Position</th>
												<th width='100'>Action</th>											
											</tr>
										</thead>
										<tbody>";
		$no = 1;
		$pointDescr = array(
			'Initial',
			'Rejected',
			'Waiting',
			'Moderated'
		);

		$strTypecomment= array('Dealt with', 'Accepted', 'Resubmited', 'Note', 'Recomendation');
		$no=0 ;
		$strCurrentinitial = $tableHeader;
		$idCommentArray = array();
		$reject = 0;
		foreach($comment_currents as $get_comment)
		{
			$no++;
			$d = $get_comment['create_by'];
			$tang = date("Y-m-d", strtotime($get_comment['tanggal']));
			if ($get_comment['importan'] == 0)
			{
				$strImportan = '';
			}
		 	else
			{
				$strImportan = 'checked';
			}

			if($get_comment['point'] == 1)
			{
				$reject = 1;
			}
			
			array_push($idCommentArray, $get_comment['id_comment']);
			
			$commentType = $strTypecomment[$get_comment['commentcategory']];

			$strCurrentinitial= $strCurrentinitial .  "<tr class='odd gradeX'>
										<td title='$commentType'> <a target=_blank href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] '>" . $get_comment['nomer_comment'] . " <div class='bintang'><input type='checkbox'  readonly $strImportan/><label for='st1'> </label></div></a></td>
										<td width='50%'><a target=_blank href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] '>" . $get_comment['comment'] . " </a></td>
										
										<td>" . $alluserArray[$d] . "</td>
										<td>" . $tang . "</td>
										<td><strong>" . $pointDescr[$get_comment['point']] . "</strong></td>
										<td><a href='#'  onclick='rejectOnSMPage($get_comment[id], $id_kon, $id_subgambar_current);'> Reject</a></td>
																				
										</tr>";	
		}
		$modComment = json_encode($idCommentArray);

		$strtablecurrentcomment= $strCurrentinitial . "</tbody>
													</table>
													<script> generatedTable(6);</script>
													<input id='mod-comment' type='hidden' value=$modComment>
													<input id='mod-reject' type='hidden' value=$reject>
													<hr>";
	

	$jmlcurrentcomment= $no ;

	$strCurrentinitial = str_replace("sample_6","sample_7",$tableHeader);

	$no=0 ;
			foreach($comment_previous as $get_comment)
				{
						$no++;
						$d = $get_comment['create_by'];
						$tang = date("Y-m-d", strtotime($get_comment['tanggal']));
						if ($get_comment['importan'] == 0)
							{
							$strImportan = '';
							}
						  else
							{
							$strImportan = 'checked';
							}

						$cmnType = $strTypecomment[$get_comment['commentcategory']];
						$strCurrentinitial= $strCurrentinitial .  "<tr class='odd gradeX'>
													<td title='$cmnType'> <a target=_blank href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] '>" . $get_comment['nomer_comment'] . " <div class='bintang'><input type='checkbox'  readonly $strImportan/><label for='st1'> </label></div></a></td>
													<td width='50%'><a target=_blank href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] '>" . $get_comment['comment'] . " </a></td>
													
													<td>" . $alluserArray[$d] . "</td>
													<td>" . $tang . "</td>
													<td><strong>" . $pointDescr[$get_comment['point']] . "</strong></td>
													<td></td>
																						
													</tr>";
						
				}

						$strtablecomment= $strCurrentinitial . "</tbody>
														</table><script> generatedTable(7);</script><hr>";
	
	$jmlcomment= $no ;




	
	?>

	<!DOCTYPE html>
	<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.3 Author: ClipTheme -->
	<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
	<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
	<!--[if !IE]><!-->
	<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>Bahtera Zee | Project Manajement System | Biro kLasifikasi Indonesia</title>
		
		<script src="assets/js/pace.min.js"></script>
		<link href="assets/css/pace_theme.css" rel="stylesheet" />
		
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<?php 
			echo set_java_script_plugin_load ("main"); //MAIN JAVASCRIPTS 
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			?>
			<script src="js/ogs.js" type="text/javascript"></script>
			<script src='js/modern.js'></script>
			<link rel="shortcut icon" href="favicon.png" />
			<style>
   .bintang {
   position: relative;
   display: inline-block;
   border: none;
   }
   .bintang input {
   border: 0;
   width: 1px;
   height: 1px;
   overflow: hidden;
   clip: rect(1px 1px 1px 1px);
   clip: rect(1px, 1px, 1px, 1px);
   opacity: 0;
   }
   .bintang label {
   position: relative;
   float: right;
   color: #C8C8C8;
   }
   .bintang label:before {
   margin: 5px;
   content: "\f005";
   font-family: FontAwesome;
   display: inline-block;
   font-size: 1.5em;
   color: #ccc;
   -webkit-user-select: none;
   -moz-user-select: none;
   user-select: none;
   }
   .bintang input:checked ~ label:before {
   color: #FFC107;
   }
</style>
		</head>
		<!-- end: HEAD -->
		<!-- start: BODY -->
		<body>
			<!-- start: MAIN CONTAINER -->
			<div class="main-container">
				<!-- start: PAGE -->
				<div class="main-content">
					<div class="container">
						<!-- start: PAGE HEADER -->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
									<h1>Project<small> <?php echo $getNamaproject ; ?></small></h1>
								</div>
							</div>
						</div>
						<!-- end: PAGE HEADER -->
						<!-- start: PAGE CONTENT -->
						<div class="row">
							<div class="col-sm-12"></div>
						</div>
						<div class="row">
							<div class="col-md-4">	
								<!-- start: DYNAMIC TABLE PANEL -->
								<div class="panel panel-default">
									<?php echo writePanel("List comment"); ?>
									<div class="panel-body" style="overflow-x:scroll; margin-top:3px; ">
										<h3>List Comment</h3>
										<div id="currentcomment" class="currentcomment">
											<?php echo $strtablecurrentcomment ?>
										</div>
									</div>
									<div class="panel-body" style="overflow-x:scroll; margin-top:3px; ">
										<h3>List Previous Comment</h3>
										<hr>
										</hr>

										<div id="previouscomment" class="previouscomment">
											<?php echo $strtablecomment ?>
										</div>
									</div>
									<!-- end: DYNAMIC TABLE PANEL -->
								</div>
							</div>

							<div class="col-md-8">	
								<!-- start: DYNAMIC TABLE PANEL -->
								<div class="panel panel-default">
									<?php echo writePanel("drawing view"); ?>
									<div class="panel-body">
										<div class="out-div"></div>
						               <div class="tabbable">
						                  <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
						                     <li class="active" id="taboverview" >
						                        <a data-toggle="tab" href="#inputsurve" >
						                        Current Drawing
						                        </a>
						                     </li>
						                     <li>
						                        <a data-toggle="tab" href="#survedraw" >
						                        Previous Drawing
						                        </a>
						                     </li>
						                  </ul>
						                  <div class="tab-content">
						                     <div id="inputsurve" class="tab-pane in active">
						                        <div class="row">
						                           <div class="col-md-6">
																<table border="0">
															  <tr>
															    <th style="width: 100px;"><strong>Title</strong></th>
															    <th>: <?php echo $titleGambar_current ?></th>
															  </tr>
															  <tr>
															    <td style="width: 100px;"><strong>No Drawing</strong></td>
															    <td>: <?php echo $nogambar_current  ?></td>
															  </tr>
															  <tr>
															    <td style="width: 100px;"><strong>Revision</strong></td>
															    <td>: <?php echo $rev_current ?></td>
															  </tr>
															  <tr>
															    <td style="width: 100px;"><strong>Comment</strong></td>
															    <td>: <?php echo $jmlcurrentcomment ; ?></td>
															  </tr>
															  <tr>
															    <td style="width: 100px;" ><strong>Enginer</strong></td>
															    <td>: <?php echo $enginer_current ; ?></td>
															  </tr>
															  <tr>
															    <td style="width: 100px;" ><strong>Status Approval</strong></td>
															    <td>: <?php echo $dokumenApprovaltype_curr ; ?></td>
															  </tr>
															  <tr>
															    <td style="width: 100px;" ><strong>Moderate all</strong></td>
															    <td>: <input type="checkbox" onclick="toggleApproval(this);"></td>
															  </tr>

															</table>

															<p>
															</p>
															<hr>
															</hr>

						                           </div>
							                           <div class="col-md-6">



				<div class="form-group">
					<?php echo $approveMenu; ?>

                </div>



															<p>
															</p>
															

						                           </div>											   
												   
												   
							                           <div class="col-md-12">
	
						                                    <div id="listsyrveyreport" class="listsyrveyreport">
						                                    	<?php 
						                                    	
						                                    	echo "<iframe id='current-drawing' src=enginerrview.php?module=stamp&kon=$id_kon&gam=$ids_curr' width='100%' height='700px'></iframe>" ;
						                                    	?>
						                                    	 
						                                    </div>
						                           </div>											   
												   
												   
												   
												   
						                        </div>
						                     </div>
						                     <div id="survedraw" class="tab-pane">
						                        <div class="row">
						                           <div class="col-md-12">
															<table border="0">
															  <tr>
															    <th style="width: 100px;"><strong>Title</strong></th>
															    <th>: <?php echo $titleGambar ?></th>
															  </tr>
															  <tr>
															    <td style="width: 100px;"><strong>No Drawing</strong></td>
															    <td>: <?php echo $nogambar  ?></td>
															  </tr>
															  <tr>
															    <td style="width: 100px;"><strong>Revision</strong></td>
															    <td>: <?php echo $rev ?></td>
															  </tr>
															  <tr>
															    <td style="width: 100px;"><strong>Comment</strong></td>
															    <td>: <?php echo $jmlcomment ; ?></td>
															  </tr>
															  <tr>
															    <td style="width: 100px;" ><strong>Enginer</strong></td>
															    <td>: <?php echo $enginer ; ?></td>
															  </tr>	
															  <tr>
															    <td style="width: 100px;" ><strong>Status Approval</strong></td>
															    <td>: <?php echo $dokumenApprovaltype ; ?></td>
															  </tr>	

															</table>
															<p>
															</p>
															<hr>
															</hr>

						                                    <div id="surveygambar" class="surveygambar">
						                                    	<?php 
						                                    	
						                                    	echo "<iframe src=enginerrview.php?module=stamp&kon=$id_kon&gam=$ids' width='100%' height='700px'></iframe>" ;
						                                    	?>
						                                    </div>
						                           </div>
						                        </div>
						                     </div>
						                  </div>
						               </div>
									</div>
									<!-- end: DYNAMIC TABLE PANEL -->
								</div>
							</div>
							<!-- end: PAGE CONTENT-->
						</div>

							<!-- start: BOOTSTRAP EXTENDED MODALS -->
							<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
										&times;
									</button>
									<h4 class="modal-title">Create New FAQ</h4>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-12">
											<form role="form" class="form-horizontal">
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Subject
													</label>
													<div class="col-sm-9">
														<input type="text" placeholder="Subject" id="subject" class="form-control">
													</div>
												</div>												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Description
													</label>
													<div class="col-sm-9">
														<textarea placeholder="Description" id="descr" class="form-control" rows=9></textarea>
													</div>
												</div>												


											</form>


										</div>
									</div>
									<div class="modal-footer">
										<button type="button" data-dismiss="modal" class="btn btn-light-grey">
											Close
										</button>
										<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="addfaq();">
											Save changes
										</button>
									</div>
								</div>
								<!-- end: PAGE -->
								<!-- end: PAGE CONTENT-->
							</div>
						<!-- end: PAGE -->
					</div>
					<!-- start: FOOTER -->
					<div class="footer clearfix">
						<div class="footer-inner">
							2014 &copy; New RMS by Biro Klasifikasi Indonesia (Persero).
						</div>
						<div class="footer-items">
							<span class="go-top"><i class="clip-chevron-up"></i></span>
						</div>
					</div>
					<!-- end: FOOTER -->

					<!-- bat this is where i override the css  -->
					<style type="text/css">
						.main-content {
							margin-left: 0px;

						}
						.main-container {
							margin-top: 0px;
						}
					</style>	
				</body>
				<script>
					jQuery(document).ready(function() {
						Main.init();
						TableData.init();
									//function to initiate daterangepicker
									$('.date-picker').datepicker({
										autoclose: true
									});
								});


					jQuery(document).ready(function() {
						$('.drop-down-wrapper').perfectScrollbar({
							wheelSpeed: 50,
							minScrollbarLength: 20,
							suppressScrollX: true
						});

					});

					function toggleApproval(check)
					{
						var button = $("#appr-btn");
						if(check.checked)
						{
							console.log("enabled");
							button.removeAttr("disabled");	
						}else
						{
							console.log("disabled");
							button.attr("disabled", true);
						}
						
						button.toggleClass("btn-light-grey btn-bricky");
					}
				</script>	
				<!-- end: BODY -->
</html>
