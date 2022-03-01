<?php

	function set_java_script_plugin_load($page){

		switch ($page) {
			case "main":
				$css = "	<link rel='stylesheet' href='assets/plugins/bootstrap/css/bootstrap.min.css'>
							<link rel='stylesheet' href='assets/plugins/font-awesome/css/font-awesome.min.css'>
							<link rel='stylesheet' href='assets/fonts/style.css'>
							<link rel='stylesheet' href='assets/css/main.css'>
							<link rel='stylesheet' href='assets/css/main-responsive.css'>
							<link rel='stylesheet' href='assets/plugins/iCheck/skins/all.css'>
							<link rel='stylesheet' href='assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css'>
							<link rel='stylesheet' href='assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css'>
							<link rel='stylesheet' href='assets/css/theme_light.css' type='text/css' id='skin_color'>
							<link rel='stylesheet' href='assets/css/print.css' type='text/css' media='print'/>
									<!--[if IE 7]>
							<link rel='stylesheet' href='assets/plugins/font-awesome/css/font-awesome-ie7.min.css'>
							<![endif]-->
							<!-- end: MAIN CSS -->
							<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->" ;
						
				$java = "	<!-- start: MAIN JAVASCRIPTS -->
							<!--[if lt IE 9]>
							<script src='assets/plugins/respond.min.js'></script>
							<script src='assets/plugins/excanvas.min.js'></script>
							<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
							<![endif]-->
							<!--[if gte IE 9]><!-->
							<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
							<!--<![endif]-->
							<script src='assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js'></script>
							<script src='assets/plugins/bootstrap/js/bootstrap.min.js'></script>
							<script src='assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'></script>
							<script src='assets/plugins/blockUI/jquery.blockUI.js'></script>
							<script src='assets/plugins/iCheck/jquery.icheck.min.js'></script>
							<script src='assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js'></script>
							<script src='assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js'></script>
							<script src='assets/plugins/less/less-1.5.0.min.js'></script>
							<script src='assets/plugins/jquery-cookie/jquery.cookie.js'></script>
							<script src='assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js'></script>
							<script src='assets/js/main.js'></script>
							<!-- end: MAIN JAVASCRIPTS -->";
				break;
				
			case "calender" :
				$css  = 	"<link rel='stylesheet' href='assets/plugins/fullcalendar/fullcalendar/fullcalendar.css'>" ;
				$java = 	"<script src='assets/plugins/fullcalendar/fullcalendar/fullcalendar.js'></script>" ;
				break ;
			
			case "flot" :
				$java = "	<script src='assets/plugins/flot/jquery.flot.js'></script>
							<script src='assets/plugins/flot/jquery.flot.pie.js'></script>
							<script src='assets/plugins/flot/jquery.flot.resize.min.js'></script>";
				break ;
				
			case "table" :
				$css =  "	<link rel='stylesheet' type='text/css' href='assets/plugins/select2/select2.css' />
							<link rel='stylesheet' href='assets/plugins/DataTables/media/css/DT_bootstrap.css' />";
							
				$java = "	<script type='text/javascript' src='assets/plugins/select2/select2.min.js'></script>
							<script type='text/javascript' src='assets/plugins/DataTables/media/js/jquery.dataTables.min.js'></script>
							<script type='text/javascript' src='assets/plugins/DataTables/media/js/DT_bootstrap.js'></script>
							<script src='assets/js/table-data.js'></script>";
				break ;
				
			case "sparkline" :
				$java = " 	<script src='assets/plugins/jquery.sparkline/jquery.sparkline.js'></script>
							<script src='assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js'></script>
							<script src='assets/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js'></script>" ;
				break;
					
			case "button" :
				$css = " 	<link rel='stylesheet' href='assets/plugins/ladda-bootstrap/dist/ladda-themeless.min.css'>
							<link rel='stylesheet' href='assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css'>
							<link rel='stylesheet' href='assets/plugins/bootstrap-social-buttons/social-buttons-3.css'>" ;
				$java = "	<script src='assets/plugins/ladda-bootstrap/dist/spin.min.js'></script>
							<script src='assets/plugins/ladda-bootstrap/dist/ladda.min.js'></script>
							<script src='assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js'></script>
							<script src='assets/js/ui-buttons.js'></script>";
				break;			
			case "modal" :
				$css= " 	<link href='assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css' rel='stylesheet' type='text/css'/>
							<link href='assets/plugins/bootstrap-modal/css/bootstrap-modal.css' rel='stylesheet' type='text/css'/>" ;
							
				$java = "	<script src='assets/plugins/bootstrap-modal/js/bootstrap-modal.js'></script>
							<script src='assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js'></script>
							<script src='assets/js/ui-modals.js'></script>";
				break;			
			case "form" :
				$css= "		<link rel='stylesheet' href='assets/plugins/select2/select2.css'>
							<link rel='stylesheet' href='assets/plugins/datepicker/css/datepicker.css'>
							<link rel='stylesheet' href='assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css'>
							<link rel='stylesheet' href='assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css'>
							<link rel='stylesheet' href='assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css'>
		
							<link rel='stylesheet' href='assets/plugins/jQuery-Tags-Input/jquery.tagsinput.css'>
							<link rel='stylesheet' href='assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css'>
							<link rel='stylesheet' href='assets/plugins/summernote/build/summernote.css'>";
							
				$java= "	<script src='assets/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js'></script>
							<script src='assets/js/form-elements.js'></script>
							<script src='assets/plugins/autosize/jquery.autosize.min.js'></script>
							<script src='assets/plugins/select2/select2.min.js'></script>
							<script src='assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js'></script>
							<script src='assets/plugins/jquery-maskmoney/jquery.maskMoney.js'></script>
							<script src='assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'></script>
							<script src='assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js'></script>
							<script src='assets/plugins/bootstrap-daterangepicker/moment.min.js'></script>
							<script src='assets/plugins/bootstrap-daterangepicker/daterangepicker.js'></script>
							<script src='assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js'></script>
							<script src='assets/plugins/bootstrap-colorpicker/js/commits.js'></script>
							<script src='assets/plugins/jQuery-Tags-Input/jquery.tagsinput.js'></script>
							<script src='assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js'></script>
							<script src='assets/plugins/summernote/build/summernote.min.js'></script>
							<script src='https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js'</script>
							<script src='assets/plugins/ckeditor/adapters/jquery.js'></script>
							<script src='assets/plugins/ckeditor/adapters/jquery.js'></script>";
							
				break;			
			case "getProjectdkk" : 
				$css="<style>
								#result {
									height:20px;
									font-size:16px;
									font-family:Arial, Helvetica, sans-serif;
									color:#333;
									padding:5px;
									margin-bottom:10px;
									background-color:#FFFF99;
								}
								#country{
									padding:3px;
									border:1px #CCC solid;
									font-size:17px;
								}
								.suggestionsBox {
									position:relative;
									left: 0px;
									

									width: 400px;
									padding:0px;
									background-color: #999999;

								}
								.suggestionList {
									margin: 0px;
									padding: 0px;
								}
								.suggestionList ul li {
									list-style:none;
									margin: 0px;
									padding: 6px;
									border-bottom:1px dotted #666;
									cursor: pointer;
								}
								.suggestionList ul li:hover {
									background-color: #FC3;
									color:#000;
								}


								.load{
								background-image:url(img/loader.gif);
								background-position:right;
								background-repeat:no-repeat;
								}

								#suggest {
									position:relative;
								}
								
								tfoot input {
							        width: 100%;
							        padding: 3px;
							        box-sizing: border-box;
							    }

								</style>";
						break;
					case "galery" :
					
						$css= "<link rel='stylesheet' href='assets/plugins/colorbox/example2/colorbox.css'>";
						$java= "<script src='assets/plugins/colorbox/jquery.colorbox-min.js'></script>
								<script src='assets/js/pages-gallery.js'></script>";
										
						break;
					case "profile" :
						$css="<link rel='stylesheet' href='assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css'>
							<link rel='stylesheet' href='assets/plugins/bootstrap-social-buttons/social-buttons-3.css'>";
						$java="<script src='assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js'></script>
						<script src='assets/plugins/jquery.pulsate/jquery.pulsate.min.js'></script>";
						break;
					case "summer" :
						$css="<link rel='stylesheet' href='assets/plugins/summernote/build/summernote.css'>";
						$java="
							<script src='https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js'></script>
							<script src='assets/plugins/ckeditor/adapters/jquery.js'></script>
							<script src='assets/plugins/summernote/build/summernote.min.js'></script>";
						break;
					case "idle" :
						$java="<script src='js/idle.js'></script>";
						break;
					case "export":
					$java="
							
							<script src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
							<script src='https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js'></script>
							<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js'></script>
							<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
							<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
							<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
							<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js'></script>
							<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js'></script>
							<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js'></script>" ;
						$css="<link rel='stylesheet' href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css'>
							<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css'>";
							break;	

					case "exports":
						$java="

							<script src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
							<script src='https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js'></script>
							<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
							<script src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js'></script>
														
								" ;
						$css="<link rel='stylesheet' href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css'>
							<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css'>";
					break;	


		}		
			
	return $css . $java  ;


}

function labelStyle($Status,$dateplan){

	$dateTimenow=date('Y-m-d');

	$dueDate=date('Y-m-d', strtotime($dateplan));

	$selisih= daysdiff($dateTimenow,$dueDate);

if ($Status ==3){
//unrealization jika status = 3
return "<span class='label label-sm label-danger'>Unrealization :-(</span>";

}elseif($Status ==1){

return "<span class='label label-sm label-success'>Realization</span>";

}elseif($Status == 0){
	if ($selisih > 0){
return "<span class='label label-sm label-warning'>Waiting Realization</span>";
	}else{
//expired unrealization jika date < datenow
	return "<span class='label label-sm label-inverse'>Out of Date</span>";

	}
}

}

function Extractusername($alluserArray,$iduseraaray){

if ($iduseraaray != ",0" ){
	$iduseraaray=substr($iduseraaray, 1); // hilangkan , dalam huruf pertama

	$pieces=explode(",",$iduseraaray);

	foreach ($pieces as $piece){

	$namapeserta= $namapeserta . " " . $alluserArray[$piece];

	}

	}else {

	$namapeserta= "All RND Staff";
}

return $namapeserta;
}

function pageView($module){

switch ($module) {
    case "home":
        $page="php/dashboard.php" ;
        break;
    case "rulepub":
        $page="php/rulePublic.php" ;
        break;
    case "event":
        $page="php/training.php" ;
        break;
	case "dEvent":
        $page="php/Event.php" ;
        break;	
	case "cost" :
		$page="php/cost.php";
		break;
	case "task" :
		$page="php/task.php";
		break;
	case "galery" :
		$page="php/galery.php";
		break;
	case "document"	:
		$page="php/document.php";
		break;
	case "project" :
		$page="php/project.php";
		break;
	case "projectMod" :
		$page="php/projectMod.php";
		break;
	case "projectDetail" :
		$page="php/detailproJ.php";
		break;	
	case "viewhistory" :
		$page="php/viewHistory.php";
		break;
	case "message":
		$page="php/messages.php";
		break;
	case "profile":	
		$page="php/profile.php";
		break;
	case "dcc":
		$page="php/dcc.php";
		break;
	case "timeline":
		$page="php/timeline.php";
		break;
	case "ExpertDatabase":
		$page="php/DS_inSertExpert.php";
		break;	
	case "DamageS":
		$page="php/DS_tabledamage.php";
		break;
	
	case "dw_kontrak":	
		$page="php/dc_kontrak.php";
		break;
	case "dw_condraw":		
		$page="php/dc_kontrakgambar.php";
		break;
	case "dw_user":		
		$page="php/dc_user.php";
		break;	
	case "meeting":		
		$page="php/meeting.php";
		break;
	case "planperiode":
		$page="php/planperiode.php";
		break;
	case "plan":	
		$page="php/plan.php";
		break;
	case "Research_bank":	
		$page="php/bank.php";
		break;	
	case "Seleksi":	
		$page="php/seleksi.php";
		break;	
	case "selesksipro":	
		$page="php/seleksipro.php";
		break;	
	case "dashboard":	
		$page="php/dashbordview.php";
		break;	
	case "listrevision":	
		$page="php2/list_revisi_drawing.php";
		break;	
	case "upload":	
		$page="php2/uploadbluck.php";
		break;
	case "replaycom":
		$page="php2/replaycom.php";
		break;		
	case "dcost":
		$page="php2/detailcost.php";
		break;
	case "client":	
		$page="php2/client.php";
		break;	
	case "clientproject":	
		$page="php2/clientp.php";
		break;	
	case "faq":	
		$page="php2/faq.php";
		break;
	case "surveyreport":
		$page="php2/SurveyReport.php";
		break;	
	case "liststamp":
		$page="php2/liststamp.php";
		break;
	case "ManajemenUser":
		$page="php/iseeManajemenUser.php";
		break;
	case "projman":
		$page = "php/projectman.php";
		break;
	case "drawingView":
		$page = "php2/drawingviedetail.php";
		break;
	case "taskschedule":
		$page = "php/taskSchedule.php";
		break;		

	


	
	default:  
       $page="php/404.php" ;
       break;	
}




return $page ;

}





//#######################  customusie navigation

	function writePanel($title){
	
				$html = "	<div class='panel-heading'>
									<i class='fa fa-external-link-square'></i>
									$title
									<div class='panel-tools'>
										<a class='btn btn-xs btn-link panel-collapse collapses' href='#'>
										</a>
										<a class='btn btn-xs btn-link panel-config' href='#panel-config' data-toggle='modal'>
											<i class='fa fa-wrench'></i>
										</a>
										<a class='btn btn-xs btn-link panel-refresh' href='#'>
											<i class='fa fa-refresh'></i>
										</a>
										<a class='btn btn-xs btn-link panel-expand' href='#'>
											<i class='fa fa-resize-full'></i>
										</a>
										<a class='btn btn-xs btn-link panel-close' href='#'>
											<i class='fa fa-times'></i>
										</a>
									</div>
								</div>";
				
	
	return $html ;
	
	}
	
	function writeNavigation($page){
	$top="<ul class='main-navigation-menu'>";
	$down= "</ul>";
	
	//tittle@link@class@page
	
	$array_level1=array("Dashboard@'panel.php?module=home'@clip-home-3@home"
	,"Project@'javascript:void(0)'@clip-microscope"=>array("Project@'panel.php?module=project'@ @project"
															,"upload@'panel.php?module=upload'@ @upload"
															,"client@'panel.php?module=client'@ @client"
															,"faq@'panel.php?module=faq'@ @faq"
															,"synch"=>array("synch Server@'synk.php'@ @synkserver"
																	,"synch Client Server@'https://armada.bki.co.id/Zee-client/synk.php'@ @synkClientserver",
																	"Send Mail@'mailing.php'@ @mailing"
															)
				)
								
	, "Social@'javascript:void(0)'@clip-user-2"=>array("Profile@'panel.php?module=profile'@ @profile"
				, "Task@'panel.php?module=task'@ @task"
				, "Message@'panel.php?module=message'@ @message"
				) 
	,	
	 "Administration@'javascript:void(0)'@clip-key"=>array("user@'panel.php?module=ManajemenUser'@ @user"
				)
	, "Manajemen@'javascript:void(0)'@clip-paperplane"=>array("Project List@'panel.php?module=projman'@ @project"
				) 
	, "Logout@'../logout.php'@clip-attachment-2"
				
 );
	
	
	foreach($array_level1 as $array_level){

		if (is_array($array_level)) {
			
			//prev($array_level1);
			//print_r(key($array_level));
			
				$pieces = explode("@", key($array_level1));
	
				$title=$pieces[0];
				$link =$pieces[1];
				$class = $pieces[2];
				$pages  =$pieces[3];
				
				
				if (higlightIFrootSelect2($array_level,$page)){$StatusOpenf ="class='active open'" ;}
				$isi = $isi . "
						<li $StatusOpenf >
							<a href=$link><i class='$class'  ></i>
								<span class='title'> $title </span><i class='icon-arrow'></i>
								<span class='selected'></span>
							</a>
							<ul class='sub-menu'>";
				$StatusOpenf ="" ; //netralisisr

			foreach($array_level as $array_leve){

			if (is_array($array_leve)) {
				//print_r(key($array_level));
				//echo key($array_level);
				$pieces = explode("@", key($array_level));
	
				$title=$pieces[0];
				
				$link =$pieces[1];
				$class = $pieces[2];
				$pages  =$pieces[3];
				//if ($page == $pages){$StatusOpen ="class='active open'" ;}
				if (higlightIFrootSelect($array_leve,$page)){$StatusOpe ="class='active open'" ;}
				//echo  $title ;
				$isi=$isi . "<li $StatusOpe >
									<a href='javascript:;'>
										$title <i class='icon-arrow'></i>
									</a>
									<ul class='sub-menu'>";
				$StatusOpe ="" ; //netralisisr
				foreach($array_leve as $array_lev){
					//echo $array_lev ;
					$isi = $isi . levelBawahNavside($array_lev,$page);
				}
				$isi=$isi . "</ul>" ;
				next($array_level);
			}else {
			
			$isi = $isi . level11Navside($array_leve,$page);
			
				//echo $array_leve ;
			next($array_level);
			}
			//$isi=$isi . "</ul>" ;
			}
			
		$isi = $isi . "</ul></li>";	
		next($array_level1);
		//next($array_level1);
		
		}else {
		
		$isi = $isi . level1Navside($array_level,$page);
		
		//echo $array_level ;
		next($array_level1);
		}



	}
	
	return $top . $isi .$down ;
	
	}
	
	function level1Navside($tlinklass,$page){
	$pieces = explode("@", $tlinklass);
	
	$title=$pieces[0];
	$link =$pieces[1];
	$class = $pieces[2];
	$pages  =$pieces[3];
	if ($page == $pages){$StatusOpen ="class='active open'" ;}
	
	 $nilai = "
	 						<li $StatusOpen >
							<a href=$link><i class='$class'></i>
								<span class='title'> $title </span><span class='selected'></span>
							</a>
						</li>";
	
	return $nilai ;
	}
	
	function level11Navside($tlinklass,$page){
	$pieces = explode("@", $tlinklass);
	
	$title=$pieces[0];
	$link =$pieces[1];
	$class = $pieces[2];
	$pages  =$pieces[3];
	if ($page == $pages){$StatusOpen ="class='active open'" ;}
	
	 $nilai = "
	 						<li $StatusOpen >
							<a href=$link><i class='$class'></i>
								<span class='title'> $title </span>
							</a>
						</li>";
	
	return $nilai ;
	}
	
	function levelBawahNavside($tlinklass,$page){
	$pieces = explode("@", $tlinklass);
	
	$title=$pieces[0];
	$link =$pieces[1];
	$class = $pieces[2];
	$pages  =$pieces[3];
	if ($page == $pages){$StatusOpen ="class='active open'" ;}
	
	 $nilai = "
	 						<li $StatusOpen >
											<a href=$link>
												$title
											</a>
										</li>";
	
	return $nilai ;
	}
	
	function higlightIFrootSelect($stringArray,$page){
	
	
	foreach($stringArray as $stringArra){
	
	$pieces = explode("@", $stringArra);
	
	$title=$pieces[0];
	$link =$pieces[1];
	$class = $pieces[2];
	$pages  =$pieces[3];
	
	if ($page==$pages){
		return true ;
		break;
	}
	
	}
	
	return false;
	
	}
	
	function higlightIFrootSelect2($stringArray,$page){
	
	
	foreach($stringArray as $stringArra){
	

		$pieces = explode("@",(string) $stringArra);	


	
	$title=$pieces[0];
	$link =$pieces[1];
	$class = $pieces[2];
	$pages  =$pieces[3];
	
	if ($page==$pages){
	//echo $page ;
		return true ;
		
		break;
	}
	
			if (is_array($stringArra)) {
			
			foreach($stringArra as $stringArr){
			
			$pieces = explode("@", $stringArr);
	
			$title=$pieces[0];
			$link =$pieces[1];
			$class = $pieces[2];
			$pagesd  =$pieces[3];
			
			if ($page==$pagesd){
			
			return true ;
		
			break;
			}
			
			
			
			}
			
			
			
			}
	
	
	
	}
	
	return false;
	
	}
	
//End 	customusie navigation

	function cekLoginStatus($mysqli){
	if(login_check ($mysqli) == false) {
	  echo "<link href='../pengaturan/adminstyle.css' rel='stylesheet' type='text/css'>
	 <center>Untuk mengakses modul, Anda harus login <br>";
	  echo "<a href=index.php><b>LOGIN</b></a></center>";
	die;}
	
	
	}
	
	
	function StyleTask($duedate,$idTask,$nameJob,$tipekegiatan,$idkegiatanLepas){
	$dateTimenow=date('Y-m-d');

	$dueDate=date('Y-m-d', strtotime($duedate));
	

	
	$selisih= daysdiff($dateTimenow,$dueDate);
	
	if ($selisih>= 30){
		$kalimat= "next month";
		$kelas="label-info";
	}elseif($selisih>= 20){
		$kalimat= "this month";
		$kelas="label-info";
	}elseif($selisih>= 7){
		$kalimat= "next week";
		$kelas="label-success";
	}elseif($selisih>= 3){
		$kalimat= "this week";
		$kelas="label-warning";
	}elseif($selisih>= 1){
		$kalimat= "tomorrow";
		$kelas="label-danger";
	}elseif($selisih == 0){
		$kalimat= "today";
		$kelas="label-danger";
	}elseif($selisih< 0){
		$kalimat= "expired";
		$kelas="label-danger";
	}
	
	

	if($tipekegiatan==3){
	
	
	
	$actionLink="href='javascript:void(0)' onclick='location.href = &#39; panel.php?module=projectDetail&id=$idkegiatanLepas &#39; ;'";
	
	}else {
	
	$actionLink="href='javascript:void(0)' onclick='OnclicDoneTask($idTask);'";

	}
	
	
	$nilaibalik= "<li>
											<a class='todo-actions' $actionLink >
												<i class='fa fa-square-o'></i>
												<span class='desc' style='opacity: 1; text-decoration: none;'>$nameJob &nbsp; &nbsp; </span>
												<span class='label $kelas '> $kalimat</span>
											</a>
										</li>";
	
	
	
	//return $nilaibalik ;
	return $nilaibalik ;
	}
	
function styleTaskObj($duedate){
	$dateTimenow=date('Y-m-d');

	$dueDate=date('Y-m-d', strtotime($duedate));

	$selisih= daysdiff($dateTimenow,$dueDate);
	
		if ($selisih>= 30){
		$kalimat= $selisih . " days left";
		$kelas="label-info";
	}elseif($selisih>= 20){
		$kalimat= $selisih . " days left";
		$kelas="label-info";
	}elseif($selisih>= 7){
		$kalimat= $selisih . " days left";
		$kelas="label-success";
	}elseif($selisih>= 3){
		$kalimat= $selisih . " days left";
		$kelas="label-warning";
	}elseif($selisih>= 1){
		$kalimat= $selisih . " days left";
		$kelas="label-danger";
	}elseif($selisih == 0){
		$kalimat= $selisih . " days left";
		$kelas="label-danger";
	}elseif($selisih< 0){
		$kalimat= $selisih . " days late";
		$kelas="label-danger";
	}
	
	$stringbalik="<span class='label label-sm $kelas'>$kalimat</span>";
	
	return $stringbalik ;
	
}
	
	
	
	
function daysdiff($dt2, $dt1, $timeZone = 'Asia/Jakarta') {
  $tZone = new DateTimeZone($timeZone);
   
  $dt1 = new DateTime($dt1, $tZone);
  $dt2 = new DateTime($dt2, $tZone);  
   
  // use the DateTime datediff function IF we have a non-buggy version
  // there is a bug in many Windows implementations that diff() always
  // returns 6015  
 // if( $dt1->diff($dt1)->format("%a") != 6015 ) {
 //   return $dt1->diff($dt2)->format("%a");
 // }
   
  // else let's use our own method
 
  $y1 = $dt1->format('Y');  
  $y2 = $dt2->format('Y');
  $z1 = $dt1->format('z');
  $z2 = $dt2->format('z');
   
  $diff = intval($y1 * 365.2425 + $z1) - intval($y2 * 365.2425 + $z2);
 
  return $diff;
}

function cutStringcumbbread($stringinput){

$lengthstring=strlen($stringinput);
if ($lengthstring>11){
$stringinput=substr($stringinput, 0, 10); 
$stringinput=$stringinput . "..";
}

return $stringinput ;
}

function Maxcaracter($stringinput){
$stringinput=strip_tags($stringinput);

$lengthstring=strlen($stringinput);
if ($lengthstring>41){
$stringinput=substr($stringinput, 0, 45); 
$stringinput=$stringinput . "..";
}


return $stringinput ;
}


function cekFolderexist_obj($stringPath){
		   
		   if(!is_dir($stringPath)){
	
			mkdir($stringPath, 0700);
			}
}

function getRandomFilename(){

	$date = new DateTime();
	$stringtambahan=  $date->getTimestamp();

	$random= $stringtambahan . sha1(microtime());

	return $random ;
}

function RandomStyletimeline(){

$arraytimelinecollor=array("","teal","green","bricky","purple");
$nilai= rand(0, 4);
return $arraytimelinecollor[$nilai];

}

function MatchingButtonTimeline($color){

if ($color=="teal"){
	return "info";
}elseif($color=="green"){
	return "bricky";
}elseif($color=="bricky"){
	return "warning";
}elseif($color=="purple"){
	return "dark-grey";
}else{
	return "info";
}

}

function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

function Getbadge($tanggal,$status){

$date =strtotime($tanggal);
$now =strtotime("now");
if ($status!=1){
if ($now > $date){

$stringback="<span class='label label-sm label-danger'>$tanggal</span>";

}else {

$stringback="<span class='label label-sm label-success'>$tanggal</span>";

}

}else{

$stringback="<span class='label label-sm label-success'>$tanggal</span>";
}

return $stringback ;

}

function TimeAgo($timestamp)
{
   //type cast, current time, difference in timestamps
   $timestamp = strtotime ($timestamp);
    $timestamp      = (int) $timestamp;
    $current_time   = time();
    $diff           = $current_time - $timestamp;
   
    //intervals in seconds
    $intervals      = array (
        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
    );
   
    //now we just find the difference
    if ($diff == 0)
    {
        return 'just now';
    }   

    if ($diff < 60)
    {
        return $diff == 1 ? $diff . ' sec ago' : $diff . ' seconds ago';
    }       

    if ($diff >= 60 && $diff < $intervals['hour'])
    {
        $diff = floor($diff/$intervals['minute']);
        return $diff == 1 ? $diff . ' mins ago' : $diff . ' min ago';
    }       

    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
    {
        $diff = floor($diff/$intervals['hour']);
        return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
    }   

    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
    {
        $diff = floor($diff/$intervals['day']);
        return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
    }   

    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
    {
        $diff = floor($diff/$intervals['week']);
        return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
    }   

    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
    {
        $diff = floor($diff/$intervals['month']);
        return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
    }   

    if ($diff >= $intervals['year'])
    {
        $diff = floor($diff/$intervals['year']);
        return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
    }
}

function FormatTanggal($date){

$tanggal=date("d M Y",strtotime($date));

return $tanggal;
}

function FormatTanggaljam($date){

$tanggal=date("H:i A d M y",strtotime($date));

return $tanggal;
}

function read_file_docx($filename){

		$striped_content = '';
		$content = '';

		if(!$filename || !file_exists($filename)) return false;

		$zip = zip_open($filename);

		if (!$zip || is_numeric($zip)) return false;

		while ($zip_entry = zip_read($zip)) {

			if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

			if (zip_entry_name($zip_entry) != "word/document.xml") continue;

			$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

			zip_entry_close($zip_entry);
		}// end while

		zip_close($zip);

		//echo $content;
		//echo "<hr>";
		//file_put_contents('1.xml', $content);		

		$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
		$content = str_replace('</w:r></w:p>', "\r\n", $content);
		$striped_content = strip_tags($content);

		return $striped_content;
	}
	
function readWord($filename) {
	ini_set('memory_limit', '1024M');
  if(file_exists($filename))
  {
      if(($fh = fopen($filename, 'r')) !== false ) 
      {
         $headers = fread($fh, 0xA00);

         // 1 = (ord(n)*1) ; Document has from 0 to 255 characters
         $n1 = ( ord($headers[0x21C]) - 1 );

         // 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
         $n2 = ( ( ord($headers[0x21D]) - 8 ) * 256 );

         // 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
         $n3 = ( ( ord($headers[0x21E]) * 256 ) * 256 );

         // 1 = (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
         $n4 = ( ( ( ord($headers[0x21F]) * 256 ) * 256 ) * 256 );

         // Total length of text in the document
         $textLength = ($n1 + $n2 + $n3 + $n4);

         $extracted_plaintext = fread($fh, $textLength);

         // if you want to see your paragraphs in a new line, do this
         // return nl2br($extracted_plaintext);
         return $extracted_plaintext;
      } else {
        return false;
      }
  } else {
    return false;
  }  
}

function CekImageDatabase($stringData){

		$patern="data:image/jpeg;base64";

		$pos = strpos($stringData, $patern);


		if ($pos === false) {
			return false ;
		} else {
			return true ;
		}
		
}

function escapeSLIM($rawSLIM) {
    return rawurlencode($rawSLIM);
}

function unescapeSLIM($encodedSLIM) {
    return rawurldecode($encodedSLIM);
}

function thousandsCurrencyFormat($num) {
  $x = round($num);
  $x_number_format = number_format($x);
  $x_array = explode(',', $x_number_format);
  $x_parts = array(' K', ' M', ' B', ' T');
  $x_count_parts = count($x_array) - 1;
  $x_display = $x;
  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
  $x_display .= $x_parts[$x_count_parts - 1];
  return $x_display;
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function getIp(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}	

function getUserAgent()
{
     $agent = null;

    if ( empty($agent) ) {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        if ( stripos($agent, 'Firefox') !== false ) {
            $agent = 'firefox';
        } elseif ( stripos($agent, 'MSIE') !== false ) {
            $agent = 'ie';
        } elseif ( stripos($agent, 'iPad') !== false ) {
            $agent = 'ipad';
        } elseif ( stripos($agent, 'Android') !== false ) {
            $agent = 'android';
        } elseif ( stripos($agent, 'Chrome') !== false ) {
            $agent = 'chrome';
        } elseif ( stripos($agent, 'Safari') !== false ) {
            $agent = 'safari';
        } elseif ( stripos($agent, 'AIR') !== false ) {
            $agent = 'air';
        } elseif ( stripos($agent, 'Fluid') !== false ) {
            $agent = 'fluid';
        }

    }

    return $agent;
}
function getOS() { 

   $user_agent=$_SERVER['HTTP_USER_AGENT'];

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

function C_dasboardRight($title,$content){
	$str="					<div class='row'>
								<div class='col-sm-12'>
									<div class='panel panel-default'>
										<div class='panel-heading'>
											<i class='clip-bars'></i>
											". $title . "
											<div class='panel-tools'>
												<a class='btn btn-xs btn-link panel-collapse collapses' href='#'>
												</a>
												<a class='btn btn-xs btn-link panel-refresh' href='#'>
													<i class='fa fa-refresh'></i>
												</a>
												<a class='btn btn-xs btn-link panel-close' href='#'>
													<i class='fa fa-times'></i>
												</a>
											</div>
										</div>
										<div class='panel-body'>

										" . $content . "

										</div>
									</div>
								</div>
							</div>";
	return $str ;						
}

function C_dashboardLeft($title,$class,$content){
	$strpanel=				"<div class='panel panel-default'>
								<div class='panel-heading'>
									<i class='$class'></i>
									$title
									<div class='panel-tools'>
										<a class='btn btn-xs btn-link panel-collapse collapses' href='#'>
										</a>
										
										<a class='btn btn-xs btn-link panel-refresh' href='#'>
											<i class='fa fa-refresh'></i>
										</a>
										<a class='btn btn-xs btn-link panel-expand' href='#'>
											<i class='fa fa-resize-full'></i>
										</a>
										<a class='btn btn-xs btn-link panel-close' href='#'>
											<i class='fa fa-times'></i>
										</a>
									</div>
								</div>
								<div class='panel-body'>
									". $content ."
								</div>
							</div>" ;
	return $strpanel ;						
}

function C_chartGoogle($chartdiv,$jsonContent,$FuntionName){
	$str="google.setOnLoadCallback($FuntionName);
	  
	  function $FuntionName() {
      var datakk = google.visualization.arrayToDataTable([
         ['Tipe', 'Count'],
			$jsonContent ]);
	  		var chart = new google.visualization.ColumnChart(document.getElementById('$chartdiv'));
			chart.draw(datakk);
	  }";
return $str ;	  
}


?>