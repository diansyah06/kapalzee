<?php
include '../sis32/db_connect.php';
include '../functions.php';
sec_session_start();
$salting = $_SESSION['salt'];
$id_user = $_GET['id'];
if (ceksuper($mysqli) == true) {
	if ($salting == 9 ){

		if ($delet_stmt = $mysqli->prepare("DELETE FROM  og_user  where id_user =?  LIMIT 1")) {   
		 $delet_stmt->bind_param('i', $id_user  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();
		   
	  
	    }
		
		if ($delet_stmt = $mysqli->prepare("DELETE FROM   rm_biodata  where id_user =?  LIMIT 1")) {   
		 $delet_stmt->bind_param('i', $id_user  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();

	    }
		
				if ($delet_stmt = $mysqli->prepare("DELETE FROM   rm_sub_biodata  where id_user =? ")) {   
		 $delet_stmt->bind_param('i', $id_user  ); 
	   // Execute the prepared query.
		 $delet_stmt->execute();

	    }
		header('Location: ../panel.php?module=administratif');


	}
		header('Location: ../panel.php?module=administratif');
}
	header('Location: ../panel.php?module=administratif');







?>