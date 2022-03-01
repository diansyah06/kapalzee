<?php
include "../functions.php";

include "../sis32/db_connect.php";
sec_session_start();
include "../class/init3.php";
include "../modern.php" ;

if(login_check ($mysqli) == false) {
  echo "<link href='../pengaturan/adminstyle.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
die;}


$objectid=$_GET['id'];

			$noteds=$obj->GetmessageByid($objectid);
			$listSubscribers=$obj->getSubcriber($objectid);
			$listcommens=$obj->getcommentbyobj($objectid);

			foreach($noteds as $noted){
			$Typography= "Note " ;

			$caption =  $noted['name'] ;
			$textmessage =$noted['text'];
			$unicid =  $objectid ;
			$updateon =  $noted['updated_on'] ;
			$updateBy =  $noted['updated_by_id'] ;
			$createby =  $noted['nama'] ;
			$taskmessage =  $noted['task'] ;
			$createon =  date("d/m/Y H:i",strtotime($noted['created_on'])) ;
			}
			if($textmessage==""){$textmessage=$taskmessage; }


?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" /><title><?php echo $caption ;?></title>
</head>
<body>


<style>
body {
	font-family: sans-serif;
}
.header {
	border-bottom: 1px solid black;
	padding: 10px;
}
h1 {
	font-size: 150%;
	margin: 15px 0;
	
}
h2 {
	font-size: 120%;
	margin: 15px 0;
}
.body {
	margin-left: 20px;
	padding: 10px;
}
.comments {
	border-top: 1px solid black;
}
.comment {
	margin-left: 20px;
}
.comment-header {
	border-bottom: 1px solid black;
}
.comment-body {
	margin-left: 20px;
}
</style>

<div class="print-view-message">

<div class="header">
<h1><?php echo $caption . "</h1>
<b>From:</b> $createby <br />
<b>Date:</b> $createon<br />" ?>
<b><br />
</div> 



<div class="body">
<?php echo $textmessage ; ?>
</div>

<div class="comments">
<?php 
if ($listcommens !=""){

echo "<h2>Comments</h2>";

}
$n=1;
foreach($listcommens as $listcommen){

echo "	<div class='comment'>
		<div class='comment-header'>
			<b>#$n:</b>Posted on ". date("d/m/Y H:i",strtotime($listcommen['created_on'])) .  " by <a class='internalLink' href='#'>$listcommen[nama]</a>		</div>
		<div class='comment-body'>
		$listcommen[text]</div>
	</div>";

$n++;

}

?>

</div>

</div>

<script>
window.print();
</script>
</body>
</html>