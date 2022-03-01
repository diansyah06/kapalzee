<?php
$pagenum_id=23;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			$listUsers=$Users->get_users();

    $cost_id=intval($_GET['id']);
	$proj_id=intval($_GET['idpro']);

	$getNamaproject=$obj->getprojectNameid($proj_id);
	$gcost=$kontrak->getCostprojectbyidid($cost_id) ;
	$listjenis=array("","Cost","Income");
	 	 	 	 	 	 	 	 	
	foreach ($gcost as $gcos){
		$subject=$gcos['nam'];
		$valuta=number_format($gcos['cost']);
		$currency=$gcos['currency'];
		$currency=$currencyarray[$currency];
		$type=$gcos['tipeKegiatan'];
		$type=$listjenis[$type];
		$description=html_entity_decode($gcos['decription']);
		$tanggal=$gcos['realisation'];
		$idr=number_format($gcos['idr']);
		$kurssaatitu=number_format($gcos['kurs']);
		$total=number_format($gcos['total']);

	}
	
	
	
	 

?>


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
								<?php echo writePanel("Detail "); ?>
								<div class="panel-body">

										<p>
										</p>
								<div id="project" class="project" >	
									

									<?php 
									echo "

									<h3><strong>$subject </strong></h3><p>
									<strong>Date :  $tanggal</strong><p>
									<strong>Type :  $type</strong><p>
									<strong> Trx :  IDR $idr + $currency $valuta = IDR $total (kurs: $kurssaatitu )</strong><p>
									<hr>".
									$description;

									
									
									
									
									
									
									
									?>
									<hr>
									<object data="<?php echo  $alamat ; ?>" type="application/pdf" width="900" height="700" style=" margin-left:200px; margin-right:auto; border:dashed;" >
									</object>

								
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



				
				
				
			});
			
			
		</script>	