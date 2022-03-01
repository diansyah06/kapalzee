<?php
include("../sis32/db_connect.php"); 
include "../functions.php";
include "../class/init2.php";

$has_code=$_GET['code'];
$password1 = $_POST['p']; 

//get hash code

if (isset($password1)){

//cek keberadaan dan time window
if ($Users->find_hash_code($has_code)==true){

//get id user
$usr_id=$Users->get_id_user_hash($has_code);

	  if ($stmt = $mysqli->prepare("SELECT id_user, nick, sandi, garam ,nama ,previl FROM og_user WHERE id_user = ? LIMIT 1")) { 
      $stmt->bind_param('i', $usr_id); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($user_id, $username, $db_password, $salt,$nama ,$previll); // get variables from result.
      $stmt->fetch();
      $password1 = hash('sha512', $password1.$salt); // hash the password with the unique salt.

	}

		if ((isset($usr_id) )and ($password1!="")){
				
				if ($insert_stmt = $mysqli->prepare("UPDATE og_user SET sandi= ? , `locked` = '0' where id_user= ? limit 1")) {    
					   $insert_stmt->bind_param('si', $password1, $usr_id  ); 
					
					   // Execute the prepared query.
					   $insert_stmt->execute();
					   
					      //echo "sapii1" . $has_code;
					   //delete token
					   
					   $Users->delete_token($has_code);
					   //echo "sapii1" . $has_code;
					   $Users->delete_token_expired();
					   echo "sapi";
					   $Users->unlockUser($usr_id);
					   
					   
						echo "<script type='text/javascript'>
						alert('Password Change Success');
						   window.location = '../index.php';</script>" ;

				}

		}else {
		
		
		echo "<script>alert('Link not Valid');  window.location = '../index.php'; </script>";
		}
		
		 
		
	}else {
	
	
	echo "<script>alert('Sorry link expired');  window.location = '../index.php'; </script>";
	
	
	}





}




?>
<script type="text/javascript" src="../js/sha512.js"></script>
<script type="text/javascript" src="../js/forms.js"></script>
<form name="form1" method="post" action="">
<table width="497" border="0" id="form_table">
  <tr>
    <th width="40%">New password  &#8250;</th>
    <td width="60%">
    <input name="password" type="password" id="password" required></td>
  </tr>
  <tr>
    <th> </th>
    <td>
    <input type="button" name="button" onClick="formhasha(this.form, this.form.password,this.form.password1);" value="Submit"></td>
  </tr>
</table>
<input type="hidden" name="pass1" value="English">
<input type="hidden" name="pass2" value="English">
<input type="hidden" id='password1' name="password1" value="English">
</form>