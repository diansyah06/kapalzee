<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script src="js/ajaxupload.3.5.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            setupTinyMCE();
           
	
		   
        });
    </script>

	<script type="text/javascript" >
	// Fungsi Uplaod /
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: 'people/upload-gambar.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response !="error"){
				var myarr = response .split(":");
					$('<li></li>').appendTo('#files').html('<img src="./img/user/'+myarr[1]+'" alt="" /><br />'+myarr[1]).addClass('success');				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});
		
	});
</script>
	
<?php 
$user_id = $_SESSION['user_id'];
if ($load_deskr = $mysqli->prepare("SELECT  jabatan, alamat, email, ym, fb, handphone, tujuan, edukasi, pekerjaan, path,dpn ,blk  FROM rm_biodata  where id_user  = ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('s', $user_id ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($jabatan, $alamat,$email, $ym, $fb , $handphone , $tujuan , $edukasi , $pekerjaan , $path ,$dpn ,$blk);

				
					   $load_deskr->fetch();
					   
	}				
	
	if ($load_deskr = $mysqli->prepare("SELECT  tipe, mulai, akhir, nama,id  FROM rm_sub_biodata  where id_user  = ? ")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('s', $user_id ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($tipe, $mulai, $akhir,$nama,$id );

				$edu=array();
				$training=array();
				$experience =array();
				$skill=array();
				
				while($load_deskr->fetch()){
				
				if ($tipe==1){      
				$edu[]="<tr><td>$nama &nbsp; &nbsp; &nbsp;</td><td>" . $mulai . " - " . $akhir . " &nbsp; &nbsp; <a href='#' onClick='fung_dell_edu($id);'>[hapus]</a></td></tr> ";
				
				}else if ($tipe==2){
				$training[]="<tr><td>$nama &nbsp; &nbsp; &nbsp;</td><td>" . $mulai . " - " . $akhir . " &nbsp; &nbsp;  <a href='#' onClick='fung_dell_edu($id);'>[hapus]</a></td></tr> ";
				
				}else if ($tipe==3) {
				$experience[]="<tr><td>$nama &nbsp; &nbsp; &nbsp;</td><td>" . $mulai . " - " . $akhir . " &nbsp; &nbsp;  <a href='#' onClick='fung_dell_edu($id);'>[hapus]</a></td></tr> ";
				
				}else if ($tipe==4) {
				$skill[]="<tr><td>$nama &nbsp; &nbsp; &nbsp;</td><td>&nbsp; &nbsp;  <a href='#' onClick='fung_dell_edu($id);'>[hapus]</a></td></tr> ";
				
				}
					   
					   
					   
					   }
					   
	}				
	
$edukasii= array("","<option value='1'>High Scholl degree</option>","<option value='2'>Diploma degree</option>","<option value='3'>Bachelor degree</option>","<option value='4'>Master degree</option>","<option value='5'>Doctor degree</option>");	


$email_integration= $kpi->get_email_integeration($user_id) ;
foreach ($email_integration as $email_integratio) {

$username_email=$email_integratio['username'];
$pass_email=$email_integratio['pass'];

}

$ogs_integration= $kpi->get_ogs_integeration($user_id) ;
foreach ($ogs_integration as $ogs_integratio) {

$username_ogs=$ogs_integratio['username'];
$pass_ogs=$ogs_integratio['pass'];

}
					
?>

	

 <div class="box round first">
                <h2>
                    Profil Menu </h2>
   <div class="block">
                    <!-- paragraphs -->

                   <!-- mulaiiiiii -->
  <form action="" method="post" enctype="multipart/form-data" name="form1"  id="form1">
 	  
  	<script src="js/cek_po_people.js" type="text/javascript"></script>
  <table class="form">
    <tr>
      <td><label>Position</label></td>
      <td><label>
        <input type="text" class="medium"  id="sapii" name="textfield2" onclick="validate();"  value="<?php echo $jabatan ; ?>"  />
      </label></td>
    </tr>
    <tr>
      <td><label>Address</label></td>
      <td><label>
        <input type="text" class="medium"   id="textfield3" name="textfield3"  onclick="validate();" value="<?php echo $alamat ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>Email</label></td>
      <td><label>
        <input type="text" class="medium"  id="textfield4" onclick="validate();"  name="textfield4" value="<?php echo $email ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>Yahoo Mesengger </label></td>
      <td><label>
        <input type="text" class="medium"   id="textfield5" onclick="validate();"  name="textfield5" value="<?php echo $ym ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>Facebook</label></td>
      <td><label>
        <input type="text" class="medium" id="textfield6"  onclick="validate();"  name="textfield6" value="<?php echo $fb ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>Handphone</label></td>
      <td><label>
        <input type="text" class="medium" id="textfield7"  onclick="validate();"  name="textfield7" value="<?php echo $handphone ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>Title (*ST,MT) </label></td>
      <td><label>Front
        <input name="textfield" id="textfield" type="text"  maxlength="7" value="<?php echo $dpn ; ?>" />
        Back<input name="textfield11" id="textfield11"textfield"" type="text"  maxlength="8" value="<?php echo $blk ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>objective</label></td>
      <td><label>
        <input type="text" class="medium" id="textfield8"  onclick="validate();"  name="textfield8" value="<?php echo $tujuan ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>Education</label></td>
      <td>
        <label>Start : </label>
        <select name="select" id="select" >
          <?php $awal=1960 ; for ($i=1; $i<=60; $i++){ $nilai=$awal + $i ; echo "<option value= $nilai >$nilai</option>";}?>
        </select>
Finish :       
<select name="select2" id="select2">
<?php $awal=1960 ; for ($i=1; $i<=60; $i++){ $nilai=$awal + $i ; echo "<option value= $nilai >$nilai</option>";}?>
        </select> <label>
Institution</label>        
<input type="text" class="medium" name="textfield9" id="textfield9" />
      <a class="btn-mini btn-black btn-plus"  onclick="fung_add_edukasi('1');"><span></span>Add</a> <p></p><?php echo "<table>" ; foreach ($edu as $isi) { echo $isi ;} echo "</table>" ; ?> </td>
    </tr>
    <tr>
      <td><label>Last Education</label></td>
      <td><label>
        <select name="select3" id="select3">
		<?php echo $edukasii[$edukasi] ;?> 
          <option value="1">High Scholl degree</option>
          <option value="2">Diploma degree</option>
          <option value="3">Bachelor degree</option>
          <option value="4">Master degree</option>
          <option value="5">Doctor degree</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><label>Training or Course </label> </td>
      <td><label>Start :</label>
        <select name="select4" id="select4">
		<?php $awal=1960 ; for ($i=1; $i<=60; $i++){ $nilai=$awal + $i ; echo "<option value= $nilai >$nilai</option>";}?>
        </select>
<label>Finish :</label>
<select name="select4" id="select4i">
<?php $awal=1960 ; for ($i=1; $i<=60; $i++){ $nilai=$awal + $i ; echo "<option value= $nilai >$nilai</option>";}?>
</select><label>
Institution</label>
<input type="text" class="medium" name="textfield92"  id="textfield92"/><a class="btn-mini btn-black btn-plus" onclick="fung_add_edukasi('2');"><span></span>Add</a><p></p><?php echo "<table>" ; foreach ($training as $isi) { echo $isi ;} echo "</table>" ; ?> </td>
    </tr>
    <tr>
      <td><label>Experience</label></td>
      <td><label>Start :</label>
        <select name="select5" id="select5">
		<?php $awal=1960 ; for ($i=1; $i<=60; $i++){ $nilai=$awal + $i ; echo "<option value= $nilai >$nilai</option>";}?>
        </select>
<label>Finish :</label>
<select name="select5" id="select5i">
<?php $awal=1960 ; for ($i=1; $i<=60; $i++){ $nilai=$awal + $i ; echo "<option value= $nilai >$nilai</option>";}?>
</select>
<label>Company &nbsp; </label>
<input type="text" class="medium" name="textfield93" id="textfield93" /><a class="btn-mini btn-black btn-plus" onclick="fung_add_edukasi('3');"><span></span>Add</a><p></p><?php echo "<table>" ; foreach ($experience as $isi) { echo $isi ;} echo "</table>" ; ?> </td>
    </tr>
    <tr>
      <td><label>Skill</label></td>
      <td><label>
        <input type="text" class="medium" name="textfield10" id="textfield10"/>
      </label><a class="btn-mini btn-black btn-plus" onclick="fung_add_edukasi('4');"><span></span>Add</a><p></p><?php echo "<table>" ; foreach ($skill as $isi) { echo $isi ;} echo "</table>" ; ?></td>
    </tr>
    <tr>
      <td><label>Work</label></td>
      <td><textarea name="textarea" class="tinymce" id="textarea"    ><?php echo $pekerjaan ; ?></textarea></td>
    </tr>
    
	    <tr>
      <td><label>Email Integeration </label></td>
      <td>username : 
        <label>
        <input type="text" id="textfield12" name="textfield12" value="<?php echo $username_email ; ?>" />
        </label> 
        Passwords : 
        <label>
        <input type="password" id="textfield13"  name="textfield13" />
        <a href="#" onclick="fung_add_email_integarasi();">Add</a> <a href="#" onclick="fung_dell_email_integarasi();">Dell</a> </label></td>
	    </tr>
		<tr>
      <td><label>OGS Integeration </label></td>
      <td>username : 
        <label>
        <input type="text"  id="textfield14" name="textfield14" value="<?php echo $username_ogs ; ?>" />
        </label> 
        Passwords : 
        <label>
        <input type="password" id="textfield15" name="textfield15" />
        <a href="#" onclick="fung_add_OGS_integarasi();" >Add</a> <a href="#" onclick="fung_dell_OGS_integarasi();" >Dell</a> </label></td>
	    </tr>
    <tr>
      <td><label>Foto</label></td>
      <td>
		
	  <div id="upload" style="margin:30px 200px; padding:15px; font-family:Arial, Helvetica, sans-serif;	text-align:center;	background:#f2f2f2;	color:#3366cc; 	border:1px solid #ccc;	width:150px; cursor:pointer !important;-moz-border-radius:5px; -webkit-border-radius:5px;" ><span>Upload File<span></div><span id="status" ></span>
		
		<ul id="files" ></ul></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label><a class="btn btn-green" onclick="fung_changeprofile();">Save</a></label></td>
    </tr>
  </table>
</form>
   
   <script type="text/javascript">
<!--
// Form validation code will come here.
function validate()
{
 
  
   if( document.form1.textfield2.value == "" )
   {document.form1.textfield2.className = "errormedium";  return false;} else { document.form1.textfield2.className = "successmedium";}

 if( document.form1.textfield3.value == "" )
   {document.form1.textfield3.className = "errormedium"; return false;} else { document.form1.textfield3.className = "successmedium"; }

 if( document.form1.textfield4.value == "" )
   {document.form1.textfield4.className = "errormedium"; return false;  } else { document.form1.textfield4.className = "successmedium"; }
  
 if( document.form1.textfield5.value == "" )
   {document.form1.textfield5.className = "errormedium";  return false;} else { document.form1.textfield5.className = "successmedium"; }
  
 if( document.form1.textfield6.value == "" )
   {document.form1.textfield6.className = "errormedium";  return false;} else { document.form1.textfield6.className = "successmedium";}
  
 if( document.form1.textfield7.value == "" )
   {document.form1.textfield7.className = "errormedium";  return false;} else { document.form1.textfield7.className = "successmedium"; }

 if( document.form1.textfield8.value == "" )
   {document.form1.textfield8.className = "errormedium"; return false;} else { document.form1.textfield8.className = "successmedium"; }

return( true );
}
//-->
</script>
           <!-- mulai -->
		   
 
		   
   </div>
 </div>
 <div class="box round">
                <h2>
                    <a href="sd" onclick="">List Of Word</a> </h2>
                <div class="deskripsi">
				</div>
</div>
