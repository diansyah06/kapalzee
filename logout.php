<?php
include 'functions.php';
sec_session_start();
// Unset all session values
$_SESSION = array();
// get session parameters 
$params = session_get_cookie_params();
// Delete the actual cookie.
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
// Destroy session

//deleted cookies
			    $timeDellay=30*24*60*60;
				
				setcookie('user_id', '', time() -  $timeDellay);
                setcookie('username', '', time() -  $timeDellay);
				setcookie('salt', '', time() -  $timeDellay);
				setcookie('usernama', '', time() -  $timeDellay);
				setcookie('login_string','', time() -  $timeDellay);

session_destroy();
header('Location: ./');

?>
