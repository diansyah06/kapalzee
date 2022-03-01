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
	
//unread message
$unread =$pesan->GetUnreadMessage($user_id);

//load message
$unreadMessages=$pesan->GetMessagebyIdUnread($user_id);

//getJUmlahTask
$getJumlaTask=$Activity->getJmlTaskbyidUserUrgent($user_id);

//listNotification
$listnotefications=$obj->getNotifiObj($user_id);

//getjml notification-2

$getJumlahNotify=$obj->getNotifiObjJml($user_id);

//page 

$pageModul=htmlspecialchars(strip_tags($_GET['module']), ENT_QUOTES, 'UTF-8'); 

//page control
$page = pageView($pageModul);

//getalluser
$listUsers=$Users->get_users();

//get task
$listUrgents=$Activity->getTaskbyidUserUrgent($user_id);

$alluserArray=array(); // store alluseronarray
foreach($listUsers as $listUser){
$idusernya=$listUser['id_user'];
$alluserArray[$idusernya]=$listUser['nama'];
}

//array kegiatan
$namakegiatan=array("uncategory","Training","Schooling","Sidang","Meeting","Committee","Attendance","Presentation","Project or Research","launcing","Other");
		
//curency
$currencyarray=array("error","IDR","USD","SGD","GDB","EUR");

$typebidangArray=array(" ","Structure","Stability", "Machinery","Offshore","Other" );
$typeStatus=array("Preparation","Discussion","Reject","Approve");






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


		?>
		<link rel="shortcut icon" href="favicon.png" />
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>
		<!-- start: HEADER -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container">
				<div class="navbar-header">
					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- start: LOGO -->
					<a class="navbar-brand" href="./panel.php?module=home">
					<img src="./assets/images/logo.png" alt="Logo" width="130px" /></i>
					</a>
					<!-- end: LOGO -->
				</div>
				<div class="navbar-tools">
					<!-- start: TOP NAVIGATION MENU -->
					<ul class="nav navbar-right">
						<!-- start: TO-DO DROPDOWN -->
						<li class="dropdown">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
								<i class="clip-list-5"></i>
								<div id="classNotif" class="classNotif">
								<?php
									if ($getJumlaTask!=0){
									
										echo "<span class='badge'> $getJumlaTask  </span>";
									}
								
									
								?>	
								</div>
							</a>
							<ul class="dropdown-menu todo">
								
								<li>
									<span class="dropdown-menu-title"> You have <?php echo $getJumlaTask ; ?> pending tasks</span>
								</li>
								<li>
									<div class="drop-down-wrapper">
										<ul>
										<div id="taskrefresh" class="taskrefresh">
											<?php
									
									foreach($listUrgents as $listUrgent ){
									


									echo StyleTask($listUrgent['due'],$listUrgent['id'],$listUrgent['pekerjaan'],$listUrgent['tipeKegiatan'],$listUrgent['idKegiatan']) ;
										
									}
									
									?>
										 </div>
										</ul>
									</div>
								</li>
								<li class="view-all">
									<a href="panel.php?module=task">
										See all tasks <i class="fa fa-arrow-circle-o-right"></i>
									</a>
								</li>
							
							</ul>
						</li>
						<!-- end: TO-DO DROPDOWN-->
						<!-- start: NOTIFICATION DROPDOWN -->
						<li class="dropdown">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
								<i class="clip-notification-2"></i>
								<div id="badgeNotif" class="badgeNotif">
							<?php
								if($getJumlahNotify != 0 ) {
								echo "<span class='badge'> $getJumlahNotify</span>";
								}
							?>
							</div>
							</a>
							<ul class="dropdown-menu notifications">
							<div> 
								<div id="refreshnoti" class="refreshnoti">
								<li>
									<span class="dropdown-menu-title"> You have <?php echo $getJumlahNotify ;?> notifications</span>
								</li>
								<li>
									<div class="drop-down-wrapper">
										<ul>
										
									<?php
									$randomLabel=array('label-success','label-primary','label-warning','label-danger') ;
									
										foreach ($listnotefications as $listnotefication){
											$timeago=TimeAgo($listnotefication['created_on']);
											$timeago=str_replace("ago","",$timeago);
											$noTogel=rand(0, 3);
											$stringLabelRandom=$randomLabel[$noTogel];
											$linkNotify="onclick='location.href = &#39;$listnotefication[link] &#39; ;'";
											echo "<li>
												<a href='javascript:void(0)' $linkNotify >
													<span class='label $stringLabelRandom'><i class='fa $listnotefication[class]'></i></span>
													<span class='message'>New $listnotefication[nama] has been $listnotefication[action]ed</span>
													<span class='time'>$timeago</span>
												</a>
											</li>" ;
											
											}
										?>	
										
										</ul>
									</div>
								</li>
							</div>
								<li class="view-all">
									<a href="#" onclick="markNotificationRead(1);">
										Mark read all notifications <i class="fa fa-arrow-circle-o-right"></i>
									</a>
									<div class='nilaibaliknotif'></div>
								</li>
							</div>	
							</ul>
						</li>
						<!-- end: NOTIFICATION DROPDOWN -->
						<!-- start: MESSAGE DROPDOWN -->
						<li class="dropdown">
							<a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
								<i class="clip-bubble-3"></i>
								<?php if ($unread!=0){ echo "
								<span class='badge'> $unread </span>";
								}
								?>
							</a>
							<ul class="dropdown-menu posts">
								<li>
									<span class="dropdown-menu-title"> You have <?php echo $unread ; ?> unread messages</span>
								</li>
								<li>
									<div class="drop-down-wrapper">
										<ul><?php
												foreach ($unreadMessages as $unreadMessage){
												$timeagonotif=TimeAgo($unreadMessage['created_on']);
												$timeagonotif=str_replace("ago","",$timeagonotif);
												
												echo "
												<li>
												<a href='javascript:void(0)' onclick='location.href = &#39;panel.php?module=message&#39; ;'>
													<div class='clearfix'>
														<div class='thread-image'>
															<img height='50px' width='50px' alt='' src='../$unreadMessage[path]'>
														</div>
														<div class='thread-content'>
															<span class='author'>$unreadMessage[nama]</span>
															<span class='preview'>$unreadMessage[body].</span>
															<span class='time'> $timeago</span>
														</div>
													</div>
												</a>
											</li> " ;
												

												
												}
										
										
										
										     ?>
											
											
										</ul>
									</div>
								</li>
								<li class="view-all">
									<a href="panel.php?module=message">
										See all messages <i class="fa fa-arrow-circle-o-right"></i>
									</a>
								</li>
							</ul>
						</li>
						<!-- end: MESSAGE DROPDOWN -->
						<!-- start: USER DROPDOWN -->
						<li class="dropdown current-user">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
								<img width="30" height="30" src="<?php echo $displayPicture ;?>" class="circle-img" alt="">
								<span class="username"><?php echo $nama_user ;?></span>
								<i class="clip-chevron-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="panel.php?module=profile">
										<i class="clip-user-2"></i>
										&nbsp;My Profile
									</a>
								</li>
								<li>
									<a href="panel.php?module=message">
										<i class="clip-bubble-4"></i>
										&nbsp;My Messages (<?php echo $unread ; ?> )
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="utility_lock_screen.php"><i class="clip-locked"></i>
										&nbsp;Lock Screen </a>
								</li>
								<li>
									<a href="../logout.php">
										<i class="clip-exit"></i>
										&nbsp;Log Out
									</a>
								</li>
							</ul>
						</li>
						<!-- end: USER DROPDOWN -->
					</ul>
					<!-- end: TOP NAVIGATION MENU -->
				</div>
			</div>
			<!-- end: TOP NAVIGATION CONTAINER -->
		</div>
		<!-- end: HEADER -->
		<!-- start: MAIN CONTAINER -->
		<div class="main-container">
			<div class="navbar-content">
				<!-- start: SIDEBAR -->
				<div class="main-navigation navbar-collapse collapse">
					<!-- start: MAIN MENU TOGGLER BUTTON -->
					<div class="navigation-toggler">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
					<!-- end: MAIN MENU TOGGLER BUTTON -->
					<?php echo writeNavigation($_GET['module']); ?>
					<!-- start: MAIN NAVIGATION MENU -->
				
					<!-- end: MAIN NAVIGATION MENU -->
				</div>
				<!-- end: SIDEBAR -->
			</div>
			<!-- start: PAGE -->
			<div class="main-content">
				<!-- start: PANEL CONFIGURATION MODAL FORM -->
				<div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">Panel Configuration</h4>
							</div>
							<div class="modal-body">
								Here will be a configuration form
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Close
								</button>
								<button type="button" class="btn btn-primary">
									Save changes
								</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- end: SPANEL CONFIGURATION MODAL FORM -->
				<div class="container">
					<!-- start: PAGE HEADER -->
					<div class="row">
						<div class="col-sm-12">
							<!-- start: STYLE SELECTOR BOX -->
							<div id="style_selector" class="hidden-xs">
								<div id="style_selector_container">
									<div class="style-main-title">
										Style Selector
									</div>
									<div class="box-title">
										Choose Your Layout Style
									</div>
									<div class="input-box">
										<div class="input">
											<select name="layout">
												<option value="default">Wide</option><option value="boxed">Boxed</option>
											</select>
										</div>
									</div>
									<div class="box-title">
										Choose Your Header Style
									</div>
									<div class="input-box">
										<div class="input">
											<select name="header">
												<option value="fixed">Fixed</option><option value="default">Default</option>
											</select>
										</div>
									</div>
									<div class="box-title">
										Choose Your Footer Style
									</div>
									<div class="input-box">
										<div class="input">
											<select name="footer">
												<option value="default">Default</option><option value="fixed">Fixed</option>
											</select>
										</div>
									</div>
									<div class="box-title">
										Backgrounds for Boxed Version
									</div>
									<div class="images boxed-patterns">
										<a id="bg_style_1" href="#"><img alt="" src="assets/images/bg.png"></a>
										<a id="bg_style_2" href="#"><img alt="" src="assets/images/bg_2.png"></a>
										<a id="bg_style_3" href="#"><img alt="" src="assets/images/bg_3.png"></a>
										<a id="bg_style_4" href="#"><img alt="" src="assets/images/bg_4.png"></a>
										<a id="bg_style_5" href="#"><img alt="" src="assets/images/bg_5.png"></a>
									</div>
									<div class="box-title">
										5 Predefined Color Schemes
									</div>
									<div class="images icons-color">
										<a id="light" href="#"><img class="active" alt="" src="assets/images/lightgrey.png"></a>
										<a id="dark" href="#"><img alt="" src="assets/images/darkgrey.png"></a>
										<a id="black_and_white" href="#"><img alt="" src="assets/images/blackandwhite.png"></a>
										<a id="navy" href="#"><img alt="" src="assets/images/navy.png"></a>
										<a id="green" href="#"><img alt="" src="assets/images/green.png"></a>
									</div>
									<div class="box-title">
										Style it with LESS
									</div>
									<div class="images">
										<div class="form-group">
											<label>
												Basic
											</label>
											<input type="text" value="#ffffff" class="color-base">
											<div class="dropdown">
												<a class="add-on dropdown-toggle" data-toggle="dropdown"><i style="background-color: #ffffff"></i></a>
												<ul class="dropdown-menu pull-right">
													<li>
														<div class="colorpalette"></div>
													</li>
												</ul>
											</div>
										</div>
										<div class="form-group">
											<label>
												Text
											</label>
											<input type="text" value="#555555" class="color-text">
											<div class="dropdown">
												<a class="add-on dropdown-toggle" data-toggle="dropdown"><i style="background-color: #555555"></i></a>
												<ul class="dropdown-menu pull-right">
													<li>
														<div class="colorpalette"></div>
													</li>
												</ul>
											</div>
										</div>
										<div class="form-group">
											<label>
												Elements
											</label>
											<input type="text" value="#007AFF" class="color-badge">
											<div class="dropdown">
												<a class="add-on dropdown-toggle" data-toggle="dropdown"><i style="background-color: #007AFF"></i></a>
												<ul class="dropdown-menu pull-right">
													<li>
														<div class="colorpalette"></div>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div style="height:25px;line-height:25px; text-align: center">
										<a class="clear_style" href="#">
											Clear Styles
										</a>
										<a class="save_style" href="#">
											Save Styles
										</a>
									</div>
								</div>
								<div class="style-toggle close"></div>
							</div>
							<!-- end: STYLE SELECTOR BOX -->
							<!-- start: PAGE TITLE & BREADCRUMB -->
							<ol class="breadcrumb">
								<li>
									<i class="clip-home-3"></i>
									<a href="#">
										Home
									</a>
								</li>
								<li class="active">
									<?php echo $pageModul ;?>
								</li>
								<li class="search-box">
									<form class="sidebar-search">
										<div class="form-group">
											<input type="text" placeholder="Start Searching...">
											<button class="submit">
												<i class="clip-search-3"></i>
											</button>
										</div>
									</form>
								</li>
							</ol>
							
							<?php
							
							include $page ;
							
							
							
							?>
							
							
					<!-- end: PAGE CONTENT-->
				</div>
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
		<!--modal -->
		<div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Event Management</h4>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-light-grey">
							Close
						</button>
						<button type="button" class="btn btn-danger remove-event no-display">
							<i class='fa fa-trash-o'></i> Delete Event
						</button>
						<button type='submit' class='btn btn-success save-event'>
							<i class='fa fa-check'></i> Save
						</button>
					</div>
				</div>
			</div>
		</div>

	</body>
		<script>
		
			jQuery(document).ready(function() {
$('.drop-down-wrapper').perfectScrollbar({
        wheelSpeed: 50,
        minScrollbarLength: 20,
        suppressScrollX: true
    });
	
	
//setTimeout(function(){refreshNotification();},10000)

var auto_refresh = setInterval(function (){ refreshNotification(); }, 10000);

 $('<audio id="chatAudio"><source src="assets/notify.ogg" type="audio/ogg"><source src="assets/notify.mp3" type="assets/audio/mpeg"><source src="assets/notify.wav" type="audio/wav"></audio>').appendTo('body');

	
});
</script>	
<script src='js/modern.js'></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-6324088-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-6324088-7');
</script>

	<!-- end: BODY -->
</html>
