<?php
include '../sis32/db_connect.php';
include '../functions.php';
sec_session_start();
$salting = $_SESSION['salt'];
if 	($salting  > 4 ) {
	// The hashed password from the form
	$nama = $_POST['nama'];
	$nip = $_POST['nip'];
	$divisi = $_POST['divisi'];
	$telp = $_POST['tlp'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['p']; 
	$previll = $_POST['previ'];
	$datetime = date("Y-m-d");
	

	
	//cek injeck previlage 
	if ($previll > 8){ $previll = 1;}
	
	// Create a random salt
	$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	// Create salted password (Careful not to over season)
	$password = hash('sha512', $password.$random_salt);
	 
	// Add your insert to database script here. 
	// Make sure you use prepared statements!
	
	if 	(($salting > 4 ) and ( $previll < $salting )) { //cek previle tak melebihi pembuatnya
		if ($insert_stmt = $mysqli->prepare("INSERT INTO og_user (nick, email, sandi, garam, nama, id_pegawai, divisi, tlp, dibuat,previl ) VALUES (?, ?, ?, ?, ? , ?, ?, ?,?,?)")) {    
		   $insert_stmt->bind_param('sssssisssi', $username, $email, $password, $random_salt, $nama, $nip, $divisi, $telp, $datetime,$previll   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   $id_akhir= $insert_stmt->insert_id; //last id
		   
		   //add database biodata
		   $path ="img/user/none.jpg";
		   $user_id=$id_akhir;
		   
			if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_biodata (id_user, path  ) VALUES (?,?)")) {    
			   $insert_stmt->bind_param('is', $user_id  , $path  ); 
			   // Execute the prepared query.
			   $insert_stmt->execute();
			   
			  } 
			   
		   
		   header('Location: ../panel.php?module=administratif');
		}
	header('Location: ../panel.php?module=administratif');
	}	
	header('Location: ../panel.php?module=administratif');
}
else {
 header('Location: ../panel.php?module=administratif');
}


?>