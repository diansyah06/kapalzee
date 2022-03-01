<?php
$pagenum_id=9;
$Users->cekSecuritypeage($user_id,$pagenum_id);
echo set_java_script_plugin_load ("galery");
echo set_java_script_plugin_load ("form");

$idEvent=$_GET['id'];

//get info Event
$listEvents=$kpi->getTrainingbyID($idEvent);

foreach ($listEvents as $listEvent){
	$description= $listEvent['description'] ;
	$titleEvent=$listEvent['training'] ;
	$peoplelist=$listEvent['peserta'];
	$peoplelist=substr($peoplelist, 1); // hilangkan , dalam huruf pertama
	$updateby=$listEvent['updateby'];
	$postBy=$listEvent['post'];
	$dateStart=date("d M Y",strtotime($listEvent['realisasiStart'])) ;
	$dateEnd=date("d M Y",strtotime($listEvent['realisasiEnd'])) ;
}

$lisdocuments= $Activity->getdocAsociated($idEvent);

foreach($lisdocuments as $lisdocument){

if (strlen($lisdocument['nama'])>40){
$namaFile=substr($lisdocument['nama'],0,40).".." ;
}else{
$namaFile=$lisdocument['nama'];
}
$lisdoc=$lisdoc .  "<li><a href='$lisdocument[path]'  target='_blank'>" . $namaFile . "</a></li>";

$lastLinkFile=$lisdocument[path];

}




?>

							<div class="page-header">
								<h1>Event <small><?php echo $titleEvent ; ?></small></h1>
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
									Description 
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
											<?php echo $titleEvent ;?>
										</p>
									</blockquote><p>
									<div id="inline-column1" >
									<div id="<?php echo $idEvent ; ?>" <?php if ($postBy== $user_id){ echo "contenteditable='true'" ; }?>>
										
											<?php echo $description ;?>
										
									</div>	
									</div></p>	
									<blockquote>	<small><cite title="Source Title"><?php echo $alluserArray[$updateby] ; ?></cite></small>
									</blockquote>
									<div class="clearfix">
										<blockquote class="pull-right">

											<small>Event on <cite title="Source Title"> <?php echo $dateStart . " until " . $dateEnd;?></cite></small>
										</blockquote>
									</div>

								</div>
							</div>
							<!-- end: BLOCKQUOTES PANEL -->
							<!-- start: WELLS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-reorder"></i>
									Document View
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
									<embed width='100%' height='900px' name='plugin' src='<?php echo $lastLinkFile ;?>' type='application/pdf'>
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
									People
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
									<ol>
									
										<?php
										
										$pieces=explode(",",$peoplelist);
										
										foreach ($pieces as $piece){
										
										echo "<li><a href='./panel.php?module=profile&id=$piece' >" . $alluserArray[$piece] . "</a> </li>";
										}
										
										?>

									</ol>
								</div>
							</div>
							<!-- end: UNORDERED LISTS PANEL -->
							<!-- start: ORDERED LISTS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="icon-reorder"></i>
									Document
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
									<ul>
										<?php
											echo $lisdoc;
										?>		
									</ul>
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
					
					<div class="row">
					<div class="col-sm-12">
					<label>
					<h4>Documentation <h4>
					</label>
					</div>
					<div class="refreshgalery" id="refreshgalery">
					
					<?php
					
					$PictureLists=$Activity->getdocGaleryAsociated($idEvent,2);
					
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
