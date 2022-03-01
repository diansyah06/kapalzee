<?php
include "../class/init3.php";

$nup = $_POST['nup'] ;

//get id & email

$user_datas=$Users->get_users_nup($nup);

foreach ($user_datas as $user_data) {

$id_user=$user_data['id_user'];
$nick = $user_data['nick'];
$email_user=$user_data['email'];
$now = time();

}
if (isset($id_user)) {

	//create random with  md5( nup + date + time )
	$random_hash= md5($nup . $now );

	//save database 

	$Users->Insert_lost_password($id_user,$now,$random_hash);
	
	
	$subject = "Password Reset for Bahtera Zee";
	$from="bahtera-zee@bki.co.id";
	
	

	//send email
				//require("../newsmtp/smtp.php");
				//require("../newsmtp/sasl.php");
				//$smtp=new smtp_class;
	
				$to= $email_user ;
				


$body="<p>A request was made to send you your username and password for RMS. Your details are as follows: </p>
<p>Username :  $nick </p>
<p>To reset Your passwords visit the homepage by clicking or copying this link to your browser (<a href='https://bahtera-zee.bki.co.id:8888/rules_sup/change%20password.php?code=$random_hash'> https://bahtera-zee.bki.co.id:8888/rules_sup/change%20password.php?code=$random_hash </a> ) and enter your new passwords, and this link will  valid only 2 hours. and we recomended you to used chrome or mozilla firefox</p>
<p>You didn't request your password? </p>
<p>Anyone can request this information, but only you will receive this email. This is done so that you can access your information from anywhere, using any computer. If you received this email but did not yourself request the information, then rest assured that the person making the request did not gain access to any of your information.</p>
<p>Regards, <br />
  Bahtera Zee Team</p>";







				
				
				
				
				$message = $body ;
				//include('../newsmtp/smtpwork.php');
				
				$obj->sendEmail($from,$id_user,$message,$subject);
	
	echo "<script> alert('Please Cek your email'); </script>";
}else {

	echo "<script> alert('Opps, Something wrong!!!'); </script>";

}

echo "<body onload='window.close();'></body>";

?>