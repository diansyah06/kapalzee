i<?php
	error_reporting(0);
	include("sis32/db_connect.php");
	include 'functions.php';
	$output = sec_session_startcapcay(); 

  	$inner = "";
  	$message = "";

  	if($_GET['note']=='succeed')
  	{
  		echo "<script>alert('Registration succeed! Please check your email for activation link');</script>";
  	}elseif($_GET['note']=='fail')
  	{
  		echo "<script>alert('Registration failed! Please try again');</script>";
  	}elseif($_GET['note']=='exists')
  	{
  		echo "<script>alert('NUP already exists! Login using your username and password')</script>";
  	}elseif($_GET['note']=='notallowed')
  	{
  		echo "<script>alert('This NUP is not allowed to create an account')</script>";
  	}

	if(isset($_GET['error'])) { 
		if ($_GET['error']== 1) {
			$message = 'user or password wrong';
		} elseif($_GET['error']== 2)
		{
			$message = 'User Lock 10 times wrong passwords !';
		}elseif($_GET['error']==3)
		{
			$message = 'Captcha mismatch';
		}elseif($_GET['error']==4)
		{
			$message = 'Account has not been activated';
		}

		$inner = "<div class='errorHandler alert alert-danger'>
						<i class='fa fa-remove-sign'></i> $message
					</div>";
	}else
	{
		if(login_check ($mysqli) == true) {
  			header('Location: ./modern/panel.php?module=home');
  		}
	}
?>

<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.4 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>Bahtera Zee</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="modern/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="modern/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="modern/assets/fonts/style.css">
		<link rel="stylesheet" href="modern/assets/css/main.css">
		<link rel="stylesheet" href="modern/assets/css/main-responsive.css">
		<link rel="stylesheet" href="modern/assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="modern/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
		<link rel="stylesheet" href="modern/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="modern/assets/css/theme_light.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="modern/assets/css/print.css" type="text/css" media="print"/>
		<!--[if IE 7]>
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login example2">
		<div class="main-login col-sm-4 col-sm-offset-4">
			<div class="logo">

				<img src="./modern/assets/images/logo.png" alt="Logo" width="70%" />
			</div>
			<!-- start: LOGIN BOX -->
			<div class="box-login">
				<h3>Sign in to your account</h3>
				<p>
					Please enter your name/email and password to log in.
				</p>
				<?php echo $inner;?>
				<form class="form-login" action="process_login.php" method="post" name="login_form">
					<div class="errorHandler alert alert-danger no-display">
						<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
					</div>
					<fieldset>
						<input type="hidden" name="token" value='<?php echo $output["token"]; ?>'>
						<input type="hidden" name="modul" value='login'>
						<div class="form-group">
							<span class="input-icon">
								<input type="text" class="form-control" name="email" placeholder="Username/Email">
								<i class="fa fa-user"></i> </span>
						</div>
						<div class="form-group form-actions">
							<span class="input-icon">
								<input type="password" class="form-control password" name="password" placeholder="Password">
								<i class="fa fa-lock"></i>
								<a class="forgot" href="#">
									I forgot my password
								</a> </span>
						</div>
						<div class="form-group form-actions">
							<div class="col-sm-6 captcha-container" id="captcha-container">
								
							</div>
							<div class="col-sm-6">
								<br>
								<a href="#" class="btn btn-green btn-xs" onclick="refreshCaptcha();">
									Refresh <i class="fa fa-refresh"></i>
								</a>
							</div>
						</div>
						<div class="form-group">
							<span class="input-icon">
								<input type="text" class="form-control" name="captcha" placeholder="Enter captcha code here" autocomplete="off">
								<i class="clip-puzzle-2"></i> </span>
						</div>
						<div class="form-actions">
							<label for="remember" class="checkbox-inline">
								<input type="checkbox" class="grey remember" id="remember" name="remember">
								Keep me signed in
							</label>
							<button type="submit" class="btn btn-bricky pull-right" onclick="formhash(this.form, this.form.password);">
								Login <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
						<div class="new-account">
							Don't have an account yet?
							<a href="#" class="register">
								Create an account
							</a>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- end: LOGIN BOX -->
			<!-- start: FORGOT BOX -->
			<div class="box-forgot">
				<h3>Forget Password?</h3>
				<p>
					Enter your e-mail address below to reset your password.
				</p>
				<form class="form-forgot">
					<div class="errorHandler alert alert-danger no-display">
						<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
					</div>
					<fieldset>
						<div class="form-group">
							<span class="input-icon">
								<input type="email" class="form-control" name="email" placeholder="Email">
								<i class="fa fa-envelope"></i> </span>
						</div>
						<div class="form-actions">
							<a class="btn btn-light-grey go-back">
								<i class="fa fa-circle-arrow-left"></i> Back
							</a>
							<button type="submit" class="btn btn-bricky pull-right">
								Submit <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- end: FORGOT BOX -->
			<!-- start: REGISTER BOX -->
			<div class="box-register">
				<h3>Sign Up</h3>
				<p>
					Enter your personal details below:
				</p>
				<form class="form-register" action="process_login.php" method="post">
					<div class="errorHandler alert alert-danger no-display">
						<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
					</div>
					<fieldset>
						<input type="hidden" name="modul" value='register'>
						<div class="form-group">
							<input type="text" class="form-control" name="nup" placeholder="NUP">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="phone" placeholder="Phone number">
						</div>
						<p>
							Enter your account details below:
						</p>
						<div class="form-group">
							<span class="input-icon">
								<input type="text" class="form-control" name="username" placeholder="User Name">
								<i class="fa fa-user"></i> </span>
						</div>
						<div class="form-group">
							<span class="input-icon">
								<input type="password" class="form-control" id="password_first" name="password_first" placeholder="Password">
								<i class="fa fa-lock"></i> </span>
						</div>
						<div class="form-group">
							<span class="input-icon">
								<input type="password" class="form-control" name="password" placeholder="Password Again">
								<i class="fa fa-lock"></i> </span>
						</div>
						<div class="form-actions">
							<a class="btn btn-light-grey go-back">
								<i class="fa fa-circle-arrow-left"></i> Back
							</a>
							<button type="submit" class="btn btn-bricky pull-right" onclick="formhash(this.form, this.form.password);">
								Submit <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- end: REGISTER BOX -->
			<!-- start: COPYRIGHT -->
			<div class="copyright">
				2019 &copy; by BKI.
			</div>
			<!-- end: COPYRIGHT -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="assets/plugins/respond.min.js"></script>
		<script src="assets/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="assets/plugins/jQuery-lib/1.10.2/jquery.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="modern/assets/plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
		<!--<![endif]-->
		<script src="modern/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="modern/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="modern/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
		<script src="modern/assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="modern/assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="modern/assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="modern/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="modern/assets/plugins/less/less-1.5.0.min.js"></script>
		<script src="modern/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="modern/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
		<script src="modern/assets/js/main.js"></script>
		<script type="text/javascript" src="js/sha512.js"></script>
		<script type="text/javascript" src="js/forms.js"></script>
		<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="js/jquery.preloader.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="modern/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="modern/assets/js/login.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				//Main.init();
				Login.init();
				$('#captcha-container').prepend('<img id="img-captcha" src="captcha.jpg?"'+new Date().getTime()+'></img>');
        	});
		</script>
	</body>
	<!-- end: BODY -->
</html>