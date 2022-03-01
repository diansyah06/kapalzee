<?php
include '../sis32/db_connect.php';
include '../functions.php';
sec_session_start();
$salting = $_SESSION['salt'];
$id_R = $_GET['id'];
if (ceksuper($mysqli) == true) {
	if ($salting == 9 ){
		//hapus database list rule
		if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_otherrules  where id =?  LIMIT 1")) {   
		 $delet_stmt->bind_param('i', $id_R  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();
	    }
		
		
		
		header('Location: ../panel.php?module=cliterature');


	}
		header('Location: ../panel.php?module=cliterature');
}
	header('Location: ../panel.php?module=cliterature');







?>