<?php include("../sis32/db_connect.php"); include "../functions.php";
//get var from post
//harus ada pengecekan user login maupun yang bersangkutan

sec_session_start();
$user_id = $_SESSION['user_id'];


$uploaddir = '../img/user/';
$random_digit1=rand(0000,9999);
$random_digit2=rand(0000,9999);
$namabaru = $random_digit1 . "_" . $random_digit2 .".jpg" ;
$path =$uploaddir .  $namabaru;
			

$file = $uploaddir . basename($_FILES['uploadfile']['name']); 

//resize
$filename = stripslashes($_FILES['uploadfile']['name']);
$extension = getExtension($filename);
$extension = strtolower($extension);



if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['uploadfile']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['uploadfile']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);

$newwidth=250;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);


imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,

 $width,$height);


$filename = $path ;

imagejpeg($tmp,$filename,100);


imagedestroy($src);
imagedestroy($tmp);

 
if (file_exists($filename)) {

//update database
	
	if ($insert_stmt = $mysqli->prepare("UPDATE rm_biodata SET  path = ?  where id_user= ? LIMIT 1")) {    
	$bodytag = str_replace("../", "", "$path");
	
			   $insert_stmt->bind_param('ss',$bodytag , $user_id); 
			   // Execute the prepared query.
			   $insert_stmt->execute();
	}
	
	


  echo "success:" . $namabaru ; 
} else {
	echo "error";
}











function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }



















?>




