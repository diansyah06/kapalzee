<?php
include '../sis32/db_connect.php';
include '../functions.php';
sec_session_start();

$salting = $_SESSION['salt'];
$user_id = $_POST['select'];

$password = $_POST['p']; 



if 	($salting  > 4 ) {


	//Load categori.........
	if ($load_kategori = $mysqli->prepare("SELECT id_user, nama FROM og_user where previl != 9 and  previl < ?   ")) {   
	   // Execute the prepared query.
	   		$load_kategori->bind_param('i', $salting ); 
		   $load_kategori->execute();
		   $load_kategori->bind_result($id_userr,$nama );  
		   $kategoris=array();
		   while($load_kategori->fetch()){ $kategoris[]= "<option value='$id_userr' >$nama</option> "; }	
	}
//End Load categori.........

		if (isset($_POST['password'])){
//cek password sesuai 
	  if ($stmt = $mysqli->prepare("SELECT id_user, nick, sandi, garam ,nama ,previl FROM og_user WHERE id_user = ? LIMIT 1")) { 
      $stmt->bind_param('i', $user_id); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($user_id, $username, $db_password, $salt,$nama ,$previll); // get variables from result.
      $stmt->fetch();
      $password = hash('sha512', $password.$salt); // hash the password with the unique salt.

	}
		
				 //update password
				if ($insert_stmt = $mysqli->prepare("UPDATE og_user SET sandi= ? where id_user= ? limit 1")) {    
					   $insert_stmt->bind_param('si', $password, $user_id  ); 
					   // Execute the prepared query.
					   $insert_stmt->execute();
						echo "<script type='text/javascript'>
						alert('Password Change Success');
						   </script>" ;
						   
					   echo "<body onload='window.close();'></body>";
				}
		


	}












}
else {   die;}





?>


<html>
<head>
<script type="text/javascript" src="../js/sha512.js"></script>
<script type="text/javascript" src="../js/forms.js"></script>

<style type="text/css">

#form_table{

	border:4px solid #0170e4;
	width:450px;
	margin: 30px auto;
	font-family: arial;
	
	}
#form_table th {
	text-align: right;
	color: #000;
	font-size: 14px;
	}
#form_table td {
	position: relative;
	width: 40%;
	}
#form_table caption {

	height: 58px;
	 line-height: 58px;
	 width: 450px;
	 font-size: 21px;
	 font-weight: bolder;
	 }
#form_table input, #form_table textarea {
	width: 250px;

	display: inline;


	margin:2px 5px;
	font-family: arial;
	height: 28px;
	font-size: 13px;
	border-radius:8px;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
}
#form_table input[type="submit"], #form_table input[type="reset"] {
	width: 120px;
	}
#form_table input:focus, #form_table textarea:focus{

	}
#form_table input + span, #form_table textarea + span  {
	display: none;
	
	line-height: 32px;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	padding:0px 20px;
	position: absolute;
	width: 180px;
	z-index:99;
	}
 
</style>

</head>
<body>

<form name="form1" method="post" action="">
<table width="497" border="0" id="form_table">
  <tr>
    <th width="40%">Curent Password  &#8250;</th>
    <td width="60%"><label>
      <select name="select">
        <?php foreach ($kategoris as $isi) { echo $isi ;} ?>
      </select>
    </label></td>
  </tr>
  <tr>
    <th>New password  &#8250;</th>
    <td>
    <input name="password" type="password" id="password">
    <span>Your Active Email Address</span>    </td>
  </tr>
  <tr>
    <th> </th>
    <td>
    <input type="button" name="button" onclick="formhashb(this.form, this.form.password);" value="Submit"></td>
  </tr>
</table>
<input type="hidden" name="pass1" value="English">
<input type="hidden" name="pass2" value="English">
</form>
</body>
</html>