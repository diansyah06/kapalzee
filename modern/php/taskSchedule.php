<?php
$pagenum_id=26;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("maskinputmoney");		

   			$projectID =	$_GET['idproj'];	

			$allTasks = $obj->GetTaskonProjectAll($projectID);

			


foreach ($allTasks as $allTask) {

	
	if ($alluserArray[$allTask['assigned_to_contact_id']] ==  $namaOrang ) {
		$namaOrang = $alluserArray[$allTask['assigned_to_contact_id']]; 
		$strNamOrng= "" ; 
	}else{
		$namaOrang = $alluserArray[$allTask['assigned_to_contact_id']]; 
		$strNamOrng= $namaOrang; 
	}


	$deskrip = "";
	$from = date("c",strtotime($allTask['start_date']));
	$to = date("c",strtotime($allTask['due_date']));
	$labela = $allTask['name'];

	if ($allTask['percent_completed'] == 100) {
		$customClass = "ganttGreen";
	}else{
		$customClass="ganttRed";
	}
	$dataObj = htmlspecialchars_decode(strip_tags($allTask['text']))  ; 

	$dataObj = preg_replace("/[\n\r]/","",$dataObj);


	$strTaskAll=  $strTaskAll . "

				{
					name: '$strNamOrng',
					desc: '$labela',
					values: [{
						from: '/Date($from)/',
						to: '/Date($to)/',
						label: '$labela', 
						customClass: '$customClass',
						dataObj: \"$dataObj\"

					}]
				},

	" ;





}


	
substr_replace($strTaskAll ,"", -1);
			
?>
	
<link href="../js/gantt-jquery/css/style.css" type="text/css" rel="stylesheet">

					
<script src='js/modern.js'></script>
<script src="js/plan.js"></script>
					<div class="page-header">
								<h1>Project <small>Schedule</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
			<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					
					<div class="row">
						
							
							<div class="col-md-10">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Table Schedule"); ?>
								<div class="panel-body">
								
										
									<div class="gantt"></div>



											
									</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>				
							
							

							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			
			<!-- start: BOOTSTRAP EXTENDED MODALS -->
		
			<!-- end: PAGE -->
	<script>
			jQuery(document).ready(function() {

				Main.init();

        });

		</script>	

    <script src="../js/gantt-jquery/js/jquery.fn.gantt.js"></script>



	   <script>

		$(function() {

			"use strict";

			$(".gantt").gantt({
				source: [ <?php echo $strTaskAll ; ?> ],
				navigate: "scroll",
				scale: "weeks",
				maxScale: "months",
				minScale: "days",
				itemsPerPage: 100,
				onItemClick: function(data) {
					//alert("Item clicked - show some details");
					//console.log(data);
					alert(data);
				},
				onAddClick: function(dt, rowId) {
					//alert("Empty space clicked - add an item!");
				},
				onRender: function() {
					if (window.console && typeof console.log === "function") {
						console.log("chart rendered");
					}
				}
			});

			$(".gantt").popover({
                selector: ".bar",
                title: function _getItemText() {
                    return this.textContent;
                },
                container: '.gantt',
                content: "Here's some useful information.",
                trigger: "hover",
                placement: "auto right"
			});



		});

    </script>								