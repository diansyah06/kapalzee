<?php
$pagenum_id=19;
$Users->cekSecuritypeage($user_id,$pagenum_id);
echo set_java_script_plugin_load ("galery");
echo set_java_script_plugin_load ("form");

$idReport=$_GET['id'];
$idProject=$_GET['idproj'];

//get info Event
$listEvents=$comment->get_db_reportbyID($idProject,$idReport);

 
foreach ($listEvents as $listEvent){
	$narasi= $listEvent['narasi'] ;
	$commentStr=$listEvent['comment'] ;
	$fileLink=$listEvent['file'];
	$createby=$listEvent['createby'];
	$publishby=$listEvent['publishby'];
	$publishdate= date("d-M-Y",strtotime($listEvent['publishdate'])) ;
	$noreport=$listEvent['noreport'];
	$tanggalSurvey=date("d-M-Y",strtotime($listEvent['tanggal'])) ;
	
}

$statu_s=array("Open","close");
$pieces = explode(",", $commentStr);
//print_r($pieces);
$lisdocuments= $Activity->getdocAsociated($idEvent);

							$strLogCommnet="<div id='logCommnet' class='latetask' style='overflow-y:scroll; height:252px; margin-top:3px; '>
									<table class='table table-condensed table-hover' id='sample-table-3'>
										<thead>
											<tr><th>ID</th>
												<th>Comment</th>
												<th>Status</th></tr>
										</thead>
										<tbody>";
foreach($pieces as $piece){
//echo $piece;
$listComent = $comment->get_comment_byname($piece,$idProject) ;
//print_r($listComent); 
	foreach($listComent as $listComen){
	
		$status= $statu_s[$listComen['status']];
		$strLogCommnet=$strLogCommnet . "<tr><td>$listComen[nomer_comment]</td><td>$listComen[comment]</td><td>$status</td> </tr>" ;
	}

//echo $strComment;
}
$strLogCommnet=$strLogCommnet . "</tbody></table></div>"; 

if($fileLink == 'none')
{
	$filePanel = "<p>No data</p>";
}else{
	$filePanel = "<embed width='100%' height='900px' name='plugin' src='$fileLink' type='application/pdf'>";
}							
							




?>

							<div class="page-header">
								<h1>Survey Report <small><?php echo $titleEvent ; ?></small></h1>
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
									Survey Summary 
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

									<blockquote>
										<p>
											<?php echo $noreport ;?>
										</p>
									</blockquote><p>
									<div id="inline-column1" >
									<?php echo $narasi;?>
									
									<div id="<?php echo $idEvent ; ?>" <?php if ($postBy== $user_id){ echo "contenteditable='true'" ; }?>>
										
											<?php echo $description ;?>
										
									</div>	
									</div></p>	
									<blockquote>	<small><cite title="Source Title"><?php echo $alluserArray[$createby] ; ?></cite></small>
									</blockquote>
									<div class="clearfix">
										<blockquote class="pull-right">

											<small>Survey on <cite title="Source Title"> <?php echo $tanggalSurvey . " Publish " . $publishdate;?></cite></small>
										</blockquote>
									</div>

								</div>
							</div>
							<!-- end: BLOCKQUOTES PANEL -->
							<!-- start: WELLS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-reorder"></i>
									Document Attachement
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
									<?php echo $filePanel ;?>
								</div>
							</div>
							<!-- end: WELLS PANEL -->
							<!-- start: DESCRIPTIONS PANEL -->
							<!-- end: DESCRIPTIONS PANEL -->
						</div>
						<div class="col-md-4">
							<!-- start: UNORDERED LISTS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-reorder"></i>
									Comment List
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
									<?php
											echo $strLogCommnet;
										?>		
								</div>
							</div>
							<!-- end: UNORDERED LISTS PANEL -->
							<!-- start: ORDERED LISTS PANEL -->
							
							<!-- end: ORDERED LISTS PANEL -->
							<!-- start: UNSTYLED LISTS PANEL -->
							<!-- end: UNSTYLED LISTS PANEL -->
							<!-- start: INLINE LIST PANEL -->
							
							<!-- end: INLINE LIST PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
					
					<div class="row">
					<div class="col-sm-12">
					<label>
					<h4>Documentation <h4>
					</label>
					</div>
					<div class="refreshgalery" id="refreshgalery">
					
					<?php
					
					$PictureLists=$Activity->getdocGaleryAsociated($idEvent,2);
					
					if(!empty($PictureLists))
					{
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
										<a href='#'>
											<i class='clip-pencil-3 '></i>
										</a>
										<a >
											<i class='clip-close-2'></i>
										</a>
									</div>
								</div>
							</div>" ;

						}
					}else
					{
						echo "<div class='col-md-3 col-sm-4 gallery-img'>No data</div>";
					}
					
					
					

					
					
					
					?>
					
					</div>
					</div>
					
				</div>
			</div>
			<!-- end: PAGE -->
			
		
		<script>
			jQuery(document).ready(function() {
				Main.init();
				PagesGallery.init();
				
				 CKEDITOR.disableAutoInline = true;
				 
				 

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
										modul : "trainingInlineedit"
										
									},
									dataType: "html"
								});

							}
						}
					} );

				});
				
				
				
				
				
				
				
				
				
				
			});
		</script>
	</body>
	<!-- end: BODY -->
