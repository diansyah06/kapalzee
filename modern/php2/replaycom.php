<?php
$pagenum_id=253;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			$listUsers=$Users->get_users();

			$proj_id=intval($_GET['id']);
			$id_kon=$proj_id;
			$comen_id=intval($_GET['com']);

			$getNamaproject=$obj->getprojectNameid($proj_id);

			$get_nama_coment = $comment->get_db_comment_id($comen_id);

			foreach ($get_nama_coment as $get_nama_comen) {
				$nomor_koment= $get_nama_comen['nomer_comment'];
				$point =$get_nama_comen['point'];
				$importanThink=$get_nama_comen['importan'];
				$strTypecomment=$get_nama_comen['commentcategory'];
				
			}

			if ($point!=3){
				echo "<script>  alert ('Need Moderation First') ; window.location = 'panel.php?module=projectMod&idproj=$proj_id'  </script>";

			}
			$zz=$Users->get_users();
			foreach ($zz as $z ) {
				$x= $z['id_user'];
				$userx[$x]=$z['nama'] ;
			} 
			$statu_s=array("Open","close","Info");
			$get_gambs = $comment->get_gambar_idcom($comen_id,$id_kon);

			$get_replays=$comment->get_replay_idcom($comen_id,$id_kon);

			$get_coms=$comment->get_comment_id($comen_id,$id_kon);

			$get_com_his=$comment->get_comment_his($comen_id,$id_kon);

			$get_logs= $comment->get_comment_log($comen_id,$id_kon);
			$commentClass=$comment;

			foreach ($get_coms as $get_com) {
				$comment="<p><b>" . $get_com['comment'] . "</b><p> </p> ". $userx[$get_com['create_by'] ] . " <span class='success'> on " . $get_com['tanggal'] . "</span>";
				$status=  $get_com['status'];
				$tipekoment=$get_com['tipe'];
			}

			if ($tipekoment == 15) {
				$narasis = $commentClass->get_SurveyNarasi($id_kon,$get_com['create_by'],$nomor_koment);
				foreach ($narasis as $narasi) {
					$naras=$narasi['narasi'];
				}
				$narasi="
				<div class='alert alert-block alert-warning fade in'>
				<button data-dismiss='alert' class='close' type='button'>
				&times;
				</button>
				<h4 class='alert-heading'><i class='fa fa-info-circle'></i> Narasi!</h4>
				<p>
				$naras
				</p>
				<p>

				</p>
				</div>";

			}


$ArrstrTypecomment= array('Dealt with', 'Accepted', 'Resubmited', 'Note', 'Recomendation');

			?>
			<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
			<style>


				.bintang {
					position: relative;
					display: inline-block;
					border: none;
					font-size: 14px;
					margin: 50px auto;
					left: 50%;
					transform: translateX(-50%);
				}

				.bintang input {
					border: 0;
					width: 1px;
					height: 1px;
					overflow: hidden;
					position: absolute !important;
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
				<?php echo writePanel("Detail Comment : " . $nomor_koment); ?>
				<div class="panel-body">

					<p>
					</p>
					<div id="project" class="project" >	

						<div class="alert alert-block alert-info fade in">
							<button data-dismiss="alert" class="close" type="button">
								&times;
							</button>
							<h4 class="alert-heading"><i class="fa fa-info-circle"></i> Comment!</h4>
							<p>
								<?php echo $get_com['comment'] ;?>
							</p>
							<p>

							</p>
						</div>
						<?php echo $narasi ;?>
						<form role="form" id="uploadgambar"  name="uploadgambar" class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Reply
								</label>
								<div class="col-sm-9">
									<textarea name="textarea" id="coment" rows="15" cols="80" required></textarea>
								</div>
							</div>												
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									From
								</label>
								<div class="col-sm-6">
									<select name="pengirim" id="pengirim" class="form-control">
										<option value="1">surveyor</option>
										<option value="2">Owner</option>

									</select>
								</div>
							</div>						
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-5" >
									File, PDF
								</label>
								<div class="col-sm-9">
									<input type="file" name="upload"  class="form-control"/>
									<input type="hidden" name="modul" id="modul" value="commenting" readonly="readonly" />
									<input type="hidden" name="act" id="act" value="addreplay" readonly="readonly" />
									<input type="hidden" name="code" id="code" value="<?php echo $proj_id ;?>" readonly="readonly" />
									<input type="hidden" name="id_koment" id="id_koment"   value="<?php echo $comen_id?>" readonly="readonly" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-5" >
									
								</label>
								<div class="col-sm-9">
									<button type="submit" class="btn btn-success" >
										Reply
									</button>
								</div>
							</div>

						</form>

					</div>
				</div>
				<!-- end: DYNAMIC TABLE PANEL -->
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">	
			<!-- start: DYNAMIC TABLE PANEL -->
			<div class="panel panel-default">
				<?php echo writePanel("Timelines history"); ?>
				<div class="panel-body">

					<p>
					</p>
					<div id="project" class="project" >	

						<h2>
						Time Line History </h2>
						<div class="block">
							Comment : <p></p>
							<?php echo $comment ; ?>
							<hr />
							Comment type : <p></p><strong>
							<?php

							echo $ArrstrTypecomment[$strTypecomment]; 
							?>
						</strong>
							<hr></hr>
							<a  id="buttonhisto" class="button_style">show history</a>
							<p>
								<div id="hidden_content" >

									<?php 
									foreach ($get_com_his as $get_com_hi) {

										echo "<p><b>" . $get_com_hi['comment'] . "</b><p> </p> ". $userx[$get_com['create_by'] ] . " <span class='success'> on " . $get_com_hi['tanggal'] . "</span>";

									}
									?>

									<p>
									</p>
									<hr />


								</div>
								<hr />								
								Drawing List : <p></p>

								<?php 
								foreach ($get_gambs as $get_gamb) {

		//get revisis num 
									if($get_gamb['id_subGam'] != 0 ){

										$listrevs= $drawing->get_gamb_by_id($get_gamb['id_subGam'] , $proj_id); 


										foreach ($listrevs as $listrev ) {
											$revisi= ", Rev. " . $listrev['revisi'] ;
										}


									}




									echo "<b><a href='panel.php?module=liststamp&id=$get_gamb[id_kontrak]&draw=$get_gamb[id_gamb]' target=_blank >" . $get_gamb['no_gambar'] . "$revisi</a></b> ," ;
								}

								?>

								<hr />
							Status:  </p>

							<?php echo "<b>" . $statu_s[$status] . "</b>" ; 
							if ($statu_s[$status]=='Open'){ $kond='checked'; } else { $kond='unchecked';  } 

							?>

							<hr />

							<hr />
						Need to be Attention:  </p>

						<div class="bintang" id="bintang">

							<input  type="checkbox" id="st1" <?php if($importanThink==1){ echo "checked" ;}?> onclick=setImportanComment(<?php echo intval ($proj_id) . "," . $comen_id ;?>); />
							<label for="st1" title='when comment need to be attention in the next process'>Need to be Attention</label>

						</div>


						<hr />



						<?php 

						if ($status==2) {
	# code...
							echo "<center><h3> Just Info</h3></center>";
						}elseif($strTypecomment==1){
							echo "<center><h3> Accepted</h3></center>";
						}else{

							echo "
							<div class='onoffswitch'>
							<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='myonoffswitch'  onclick='fung_close_comment($comen_id,$id_kon );'$kond   >
							<label class='onoffswitch-label' for='myonoffswitch'>
							<div class='onoffswitch-inner'></div>
							<div class='onoffswitch-switch'></div>
							</label>
							</div>";

						}

						?>




						<div id="deskripsi" class="deskripsi" >
							<p >

								<?php				 




								echo "<table class='table table-striped table-bordered table-hover' id='sample_1'>
								<thead>
								<tr>
								<th>No</th>
								<th>Comment replay</th>
								<th width='100'>  Date </th>
								<th>By</th>
								<th>File</th>
								<th width='100'>Action</th>


								</tr>
								</thead>
								<tbody>";


								$no=1;
								$statu_s=array("Open","close","Info");
								foreach ($get_replays as $get_replay) {


									if($get_replay['file'] != 'none')
									{
										$link = "<a href=". $get_replay['file'] . " target='_blank'>File</a>";
									}else
									{
										$link = "none";
									}

									$tang= date("Y-m-d", strtotime($get_replay['tanggal'] ));


									echo 							"<tr >
									<td >$no</td>
									<td > " . $get_replay['replay']. "</td>
									<td >". $tang. " </a></td>
									<td>" . $get_replay['oleh'] . "</td>
									<td>" . $link . "</td>
									<td><a href=# onclick=fung_del_replay($get_replay[id_kont],$get_replay[id_comment],1,$get_replay[id]);>Delete </a></td>									
									</tr>";





									$no++ ;
								}
								echo "</tbody></table><hr>";
								?>	
							</div>
						</div>
						<!-- end: DYNAMIC TABLE PANEL -->
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">	
			<!-- start: DYNAMIC TABLE PANEL -->
			<div class="panel panel-default">
				<?php echo writePanel("Log Of commenting "); ?>
				<div class="panel-body">

					<p>
					</p>
					<div id="project" class="project" >	
						<?php 
						foreach ($get_logs as $get_log) {
							$tang=$get_log['tanggal'];


							$tang= date( 'g:i a \o\n l jS F Y', strtotime($tang));



							echo "<li><b>" . $get_log['nama'] . "</b> " . $get_log['aktifitas'] .  "   <span class='label label-success'> " . $tang . "</span></li>" ;
						}
						?>								


					</div>
				</div>
				<!-- end: DYNAMIC TABLE PANEL -->
			</div>
		</div>
	</div>					
	<!-- end: PAGE CONTENT-->



	<!-- start: BOOTSTRAP EXTENDED MODALS -->

	<!-- end: PAGE -->

	<script>
		jQuery(document).ready(function() {
			Main.init();
			TableData.init();
			histor();




		});

		$("form#uploadgambar").submit(function(event){
            
			//disable the default form submission
			event.preventDefault();
			//var sapii=document.getElementById('textfield').value;
		  
			//grab all form data  
			var formData = new FormData($(this)[0]);
			var commandStr = formData.get('act') +"#" + formData.get('code') +"#" + formData.get('id_koment') +"#" + formData.get('textarea') +"#" + formData.get('pengirim') +"#";

			formData.append('stringCommand', commandStr);
			/*for (var pair of formData.entries()) {
				console.log(pair[0]+ ', ' + pair[1]); 
			}*/

			$.ajax({
				url: 'process-ogs.php',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (html) {
					console.log(html);
					$('.deskripsi').html(html);
					$(".deskripsi").hide();
					$(".deskripsi").fadeIn(400);}
			});
			
				return false;
		  });


	</script>
	<style type="text/css">
		.onoffswitch {
			position: relative; width: 190px;
			-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;


			left: 40%;
		}

		.onoffswitch-checkbox {
			display: none;
		}

		.onoffswitch-label {
			display: block; overflow: hidden; cursor: pointer;
			border: 2px solid #999999; border-radius: 20px;
		}

		.onoffswitch-inner {
			width: 200%; margin-left: -100%;
			-moz-transition: margin 0.3s ease-in 0s; -webkit-transition: margin 0.3s ease-in 0s;
			-o-transition: margin 0.3s ease-in 0s; transition: margin 0.3s ease-in 0s;
		}

		.onoffswitch-inner:before, .onoffswitch-inner:after {
			float: left; width: 50%; height: 80px; padding: 0; line-height: 80px;
			font-size: 28px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
			-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
		}

		.onoffswitch-inner:before {
			content: "OPEN";
			padding-left: 28px;
			background-color: #2FCCFF; color: #FFFFFF;
		}

		.onoffswitch-inner:after {
			content: "CLOSE";
			padding-right: 28px;
			background-color: #FF3300; color: #FFFFFF;
			text-align: right;
		}

		.onoffswitch-switch {
			width: 18px; margin: 6px;
			background: #FFFFFF;
			border: 2px solid #999999; border-radius: 20px;
			position: absolute; top: 0; bottom: 0; right: 156px;
			-moz-transition: all 0.3s ease-in 0s; -webkit-transition: all 0.3s ease-in 0s;
			-o-transition: all 0.3s ease-in 0s; transition: all 0.3s ease-in 0s; 
		}

		.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
			margin-left: 0;
		}

		.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
			right: 0px; 
		}

	</style>
	<script type="text/jscript">
		$("#hidden_content").slideToggle("slow");
		function histor() {

			$("#buttonhisto").click(function(){
				$("#hidden_content").slideToggle("slow");
			});
		}
	</script>		