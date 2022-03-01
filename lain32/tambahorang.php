<script type="text/javascript" src="js/sha512.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>
<script type="text/javascript" src="js/table/table.js"></script>
<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>

<?php


	$salting = $_SESSION['salt'];



if(isset($_GET['error'])) { 
   
   echo 'Error Logging In!';
   
   }

if($salting < 5) {
	
 echo "<script type='text/javascript'>
 <!-- 
 window.location = 'panel.php?module=home' //
 --> </script>" ;
 die;
	}

?>

 <div class="box round first">
                <h2>
                    User manager </h2>
   <div class="block">
                    <!-- paragraphs -->
                    <p class="start">
                      Lorem Ipsum is simply dummy
                        text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only
                        five centuries, but also the leap into electronic typesetting, remaining essentially
                        unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
                        Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum.</p>
                    <p>
                        It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point of using Lorem Ipsum is that it
                        has a more-or-less normal distribution of letters, as opposed to using 'Content
                        here, content here', making it look like readable English. Many desktop publishing
                        packages and web page editors now use Lorem Ipsum as their default model text, and
                        a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various
                        versions have evolved over the years, sometimes by accident, sometimes on purpose
                        (injected humour and the like).</p>
						<hr />
						<form action="lain32/doaddreg.php" method="post" name="addUser">
<table class="form">
   <tr><td><label>Nama Lengkap: </label></td><td><input name="nama" type="text" value="" size="50"  required />
   <br /></td></tr>
   <tr><td><label>Nip: </label></td><td><input name="nip" type="number" value="" size="50" required />
   <br /></td></tr>
   <tr><td><label>Divisi: </label></td><td><input name="divisi" type="text" value="" size="50" required />
   <br /></td></tr>
   <tr><td><label>Tlp: </label></td><td><input name="tlp" type="text" value="" size="50" required />
   <br /></td></tr>
   <tr><td><label>Email: </label></td><td><input name="email" type="text" value="" size="50" required />
   <br /></td></tr>
    <tr><td><label>Previl: </label></td>
      <td><label>
        <select name="previ">
          <option value="1">Guest</option>
          <option value="2">Admin</option>
          <option value="3">Assisten</option>
          <option value="4">Surveyor/Engineer</option>
          <option value="5">Manager</option>
          <option value="6">Vice President</option>
          <option value="7">Senior Vice President</option>
        </select>
        </label></td></tr>
   <tr><td><label>user: </label></td><td><input name="username" type="text" size="50" required  />
   <br /></td></tr>
   <tr>
     <td>Password: </td>
     <td><input name="password" type="password" id="password" size="50"/></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td><input name="button" type="button"  class="btn btn-blue" onclick="formhash(this.form, this.form.password);" value="Generate password" /></td>
   </tr>
   <tr><td><label></label></td><td><input name="submit" class="btn btn-green" type="submit" value="Create        " /></td></tr>
 </table>  
   <br />
   <?php
   $jabatan=array("Error","Guest", "Admin", "Asisst", "Surveyor/Engineer", "Manager", "Vice President", "Senior Vice President");
   
   
		echo " <p> <table class='data display datatable' id='example' ><thead><tr><th>no </th><th>NIP </th><th>Nama</th><th>telphone</th><th>Email </th><th>divisi </th><th>Previlage </th><th>Hapus</th></th></tr></thead><tbody>";
		
		if ($load_stmt = $mysqli->prepare("SELECT id_user,id_pegawai, nama, tlp, email, divisi,previl FROM og_user where previl < 9 ")) {   
	   // Execute the prepared query.
		   $load_stmt->execute();
		   $load_stmt->bind_result($iduser,$nip, $nama , $tlp , $email , $divisi,$hak_akses );
		   $no=1;
		   // fetch result.
		   while($load_stmt->fetch()){
	     
				echo "<tr><td>$no</td><td>$nip</td><td>$nama</td><td>$tlp</td><td>$email</td><td>$divisi</td><td> $jabatan[$hak_akses]</td>
				<td> | <a href='./lain32/dell.php?id=$iduser'>Hapus</a></td></tr>";
				
				$no++ ;
		
			}
	    echo "</tbody></table><hr>" ;
	  
	    }
	
		
?>
        </form>
				</div>
				</div>