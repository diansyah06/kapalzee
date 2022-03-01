<?php
	$saltings = $Users->get_previl($_SESSION['user_id']);
	
	if ($saltings < 5) {
		echo "<script> window.location.href = './panel.php?modul=notfound';</script>";
		die();
	}
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("button");
			$listUsers=$Users->get_users();


?>

<script src="./js/ogs.js" type="text/javascript"> </script>
	<div class="page-header">
								<h1>Project<small> all about project</small></h1>
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
  <input name="radiobutton" type="radio" onclick="refreshProjectmanager(1);" value="0"  />
  Arsip</label>
  <label>
  <input name="radiobutton" type="radio" onclick="refreshProjectmanager(0);" value="1" checked="checked" />
   Project In Progress</label>
</form>

										<p>
										</p>
								<div id="project" class="project" >	
				
								
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					<div id="calback" class="calback" > </div>
					<!-- end: PAGE CONTENT-->
					
					
					
						<!-- start: BOOTSTRAP EXTENDED MODALS -->
		
			<!-- end: PAGE -->
					
						<script>
			jQuery(document).ready(function() {
				Main.init();
				TableData.init();
					
			});
			
			refreshProjectmanager(0);
		</script>	