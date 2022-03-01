<?php

include("../sis32/db_connect.php"); include "../functions.php";

//get var from post
sec_session_start();
include("../class/init2.php");
date_default_timezone_set('Asia/Jakarta');
$user_id = $_SESSION['user_id'];
$currentUser= $user_id ;
$nama_user = $_SESSION['usernama'] ;
$dsn = 'mysql:host=localhost;dbname=rms';
/* $PDO = new PDO($dsn, 'root', ''); */

$PDO =$db;

$mid = isset($_POST['mid']) ? $_POST['mid'] : 0;
$body = $_POST['body'];

if (!empty($mid)) { 
    /** get the recips first **/
    $sql = "SELECT distinct(uid) as uid FROM message2_recips m where mid=?";
    $stmt = $PDO->prepare($sql);
    $args = array($mid);
    if (!$stmt->execute($args)) {
        die('error');
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /** get seq # **/
    $sql = "select max(seq)+1 as seq from message2 where mid=?";
    $args = array($mid);
    $stmt = $PDO->prepare($sql);
    $stmt->execute($args);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $seq = $row['seq'];
}
else {
    $seq = 1;
    $uids = explode(',', $_POST['uids']);
    $uids[] = $currentUser;
    $uids = array_unique($uids);
    $rows = array();
	
			require("../newsmtp/smtp.php");
			require("../newsmtp/sasl.php");
			$smtp=new smtp_class;
    foreach ($uids as $uid) {
        $rows[] = array('uid'=>$uid);
		//kirim notification
		

		
		if ($uid != $currentUser ){
		

			
			$user_email=$Users->Get_email_id($uid);
			
				$to= $user_email  ;
				
				$from="RMS@klasifikasiindonesia.com";
				
				
				$subject = "user id " . $nama_user. " Sent you message on RMS System";
				
				$body1="Hi

You have new message from " . $nama_user . " and the message is :

"  ;
				
				$message = $body1 . $body.  "

---for detail info you can also view on RMS---. 
Sent From RMS BKI [ http://10.0.1.202/rms/ ] 
				";
				include('../newsmtp/smtpwork.php');
		
		
		
		}
		
    }
$user_emails=$Users->Get_email_id($uid);
	
  $Activity->Insert_activity(6, $user_id , " to user " .$to,'./panel.php?module=message&sub=inbox');
}

if (count($rows)) {
    $sql = "insert into message2 (mid, seq, created_on_ip, created_by, body) values (?, ?, ?, ?, ?)";
    $args = array($mid, $seq, '1.2.2.1', $currentUser, $body);
    $stmt = $PDO->prepare($sql);
    $stmt->execute($args);

    if (empty($mid)) {
        $mid = $PDO->lastInsertId();
		$idetifier=true; //mark if send from pop up
    }

    $insertSql = "insert into message2_recips values ";
    $holders = array();
    $params = array();
    foreach ($rows as $row) {
        $holders[] = "(?, ?, ?, ?)";
        $params[] = $mid;
        $params[] = $seq;
        $params[] = $row['uid'];
        $params[] = $row['uid'] == $currentUser ? 'A' : 'N';
    }
    $insertSql .= implode(',', $holders);
    $stmt = $PDO->prepare($insertSql);
    $stmt->execute($params);
	
if (!$idetifier){
echo "<script>window.location = '../panel.php?module=viewinbox&id=$mid'; </script>";
  die(header('Location: ../panel.php?module=viewinbox&id=' . $mid));}
else {

echo "<body onload='window.close();'></body>";
}


}
else {
    die('no recips found');
}