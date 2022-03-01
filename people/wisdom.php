<?php


//Load jenis Cek point.........
				if ($load_tipe= $mysqli->prepare("SELECT id , nama, descrip  FROM  rm_cekpointtipe where id=? limit 1")) {
				 $load_tipe->bind_param('s', $pointke); // Bind "$id_rules" to parameter.   
				   // Execute the prepared query.
					   $load_tipe->execute();
					   $load_tipe->bind_result($id,$Nama,$descript );
					   $buang=array();
					   while($load_tipe->fetch()){ $buang[]= " "; }	   	   
				}	     
?>
	<script src="js/cek_po_people.js" type="text/javascript"></script> 
<div class="box round">
                <h2>
                    The Wisdom</h2>
                <div class="block">
				 <p class="start">
                        Masss broooo kata kata maximum 500 charater yooo </p>  
				 <?php echo $descript ;?><hr />
<form action="" method="post" enctype="multipart/form-data">
				<table  class="form">
                  
                  <tr>
                    <td> <label>Description</label></td>
                    <td><textarea id="Description" name="textarea"  style="width:500px; height:120px;"></textarea></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><div class="btn btn-green" onclick="fung_add_wisdom();">Send Wisdom</div> </td>
                  </tr>
                </table> 
				
	  </form>
				</div>
				</div>
				
<div class="box round">
                <h2>
                    Wisdom you ever Post</h2>
					
                <div id="deskripsi" class="deskripsi" ><?php 
					 if ($load_tipe= $mysqli->prepare("SELECT id , isi, tanggal , id_user  FROM  rm_wisdom  ")) {
				   // Execute the prepared query.
					   $load_tipe->execute();
					   $load_tipe->bind_result($id,$isi,$tanggal , $user );
					   $buang=array();
					   while($load_tipe->fetch()){ 
					   
					   
					   echo " $tanggal <p> $isi <p> $user <hr> " ;
					   
					   
					    }	   	   
				}	     
						?>
						
					 

				</div>
				</div>
			

