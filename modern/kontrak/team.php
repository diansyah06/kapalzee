<?php
$pointke=$_GET['point'];
$cekpoin=$_GET['id'];
$cekpoint=intval( $cekpoin);
$list_jabatan_projs=$kontrak->get_Position_proj();
//Load nama user.........
				if ($load_rules = $mysqli->prepare("SELECT id_user , nama  FROM  og_user ")) {   
				   // Execute the prepared query.
					   $load_rules->execute();
					   $load_rules->bind_result($id_user,$Namauser );
					   $buanga=array();
					   while($load_rules->fetch()){ $buanga[]= "<option value='$id_user' >$Namauser</option> "; }	   	   
				}	
				
//Load nama pemimpin user.........
				if ($load_rules = $mysqli->prepare("SELECT  og_user.nama , rm_biodata.path FROM  rm_cekpoint JOIN og_user on og_user.id_user=rm_cekpoint.user JOIN  rm_biodata on og_user.id_user= rm_biodata.id_user where rm_cekpoint.id_cek=  ?")) {   
				$load_rules->bind_param('s', $cekpoint); // Bind "$id_rules" to parameter.   
				   // Execute the prepared query.
					   $load_rules->execute();
					   $load_rules->bind_result($leader ,$wajah_leader);
					   $asd=array();
					   while($load_rules->fetch()){ $asd[]= "<option value='$leader' >$Namauser</option> "; }	   	   
				}	
								
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



<div class="box round">
                <h2>
                    <?php echo $Nama ;?></h2>
                <div class="block">

				 <p class="start">
                        Lorem Ipsum is simply dummy
                        text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only
                        five centuries, but also the leap into electronic typesetting, remaining essentially
                        unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
                        Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum.</p>  <?php echo $descript ;?><hr />
<form action="" method="post" enctype="multipart/form-data">
				  <table class="form">
                    <tr>
                      <td ><label>Team leader</label> </td>
                      <td ><select name="select">
					  <?php 
					  	$user_ids = $_SESSION['user_id'];
     					$usernames = $_SESSION['usernama'];
					  	
						echo   "<option value='$user_ids' >$usernames</option>" ;
		
					   foreach ($buang as $isi) { echo $isi ;} 
					   ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td><label>Member</label></td>
                      <td><select name="select2" id="nama" class="select2">
					   <?php foreach ($buanga as $isi) { echo $isi ;} ?>
                      </select>  &nbsp;  &nbsp; <label>
                      <select name="select3" id="jabatan">
					   <?php foreach ($list_jabatan_projs as $list_jabatan_proj) {
					   echo "<option value='" . $list_jabatan_proj['id'] . "'>" . $list_jabatan_proj['nama'] . "</option>" ;} ?>
                      </select>
                      </label> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; 
                      <div class= 'btn-icon btn-grey btn-plus'  onclick="fung_add(<?php echo $cekpoint ; ?>);" ><span></span>Add</div></td>
                    </tr>
                    <tr>
                      <td><label>Date of join</label></td>
                      <td><input type="text" id="date-picker" name="textfield"  value="<?php echo date('m/d/Y') ; ?> " /></td>
                    </tr>
					<tr>
                      <td>&nbsp;  </td>
                      <td>&nbsp;  </td>
                    </tr>
                  </table>
				
				</form>
				</div>
				</div>
			<link href="css/user.css" rel="stylesheet" type="text/css" />
<style type="text/css">

span.read {
 display: none;
}
.friends_area .name:hover span.read {
    display: block;
 float: right;
 margin: 0 10px  0 10;
 color: #f00;
}
</style>

<div class="grid_5">
<div class="box round">
                <h2>
                    List Team</h2>
					  <div id="flash"></div>
<script src="js/cek_po.js" type="text/javascript"></script>
					  
                <div id="team" class="team">
<?php
   
   
   $zz=$users->get_jabatan();
			foreach ($zz as $z ) {
			$x= $z['id'];
			$jabatn[$x]=$z['nama'] ;
			} 
			

   $usericonlist = '<h1>User List</h1>';  
   
   $usericonlist .= '<div class="userthumbs">';
   
   if ($load_friend = $mysqli->prepare("SELECT og_team.id, og_team.id_project, og_team.id_user, og_team.proj_jabatan, og_user.nama , rm_biodata.path FROM  og_team JOIN og_user on og_user.id_user=og_team.id_user JOIN  rm_biodata on og_user.id_user= rm_biodata.id_user where og_team.id_project = ? ")) {   
				   // Execute the prepared query.
				       $load_friend->bind_param('s', $cekpoint); // Bind "$id_rules" to parameter.
					   $load_friend->execute();
					   $load_friend->bind_result($id,$id_cek, $id_user , $gabung ,$nama ,$almat_wajah );
					   $buang=array();
					   
					   
					   
					   echo "<div style='overflow-y:scroll; height:370px; margin-top:3px;'>";
					   //Leaderrrr///
					   echo "<div class='friends_area'><img src='$wajah' height='50' style='float:left;' alt=''> 
		   					<label style='float:left' class='name'>
		   					<b>Abdul Ghofar - $jabatn[$gabung]</b><img id='image2' style='float:left;' src='img/user/crown.png' height='20' /><br>
		    				Vice President Oil and Gas Unit</label></div>";
					   while($load_friend->fetch()){
						 echo "<div id=sapi$id class='friends_area'><img src='$almat_wajah' height='50' width='50' style='float:left;' alt=''> 
						   <label style='float:left' class='name'> 
						   <b>$nama - $jabatn[$gabung]</b>  <span class='read' onclick='fung_del($id,$id_cek); $(sapi$id).remove(); '>Delete</span><br>Institute of Technologies</label></div>";
				
						}
			 			echo '</div>';
			   
	}	   
        
   
				
?>
				
				
				
			</div>
</div>
</div>
 <div class="grid_5">
            <div class="box round">
                <h2>
                    Description  </h2> 
					<?php 
					if ($load_h = $mysqli->prepare("SELECT id, desk FROM rm_cek_desk  where id_cek  = ? AND point= ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_h->bind_param('ss', $cekpoint ,$pointke ); // Bind "$id_rules" to parameter.
					   $load_h->execute();
					  $load_h->store_result();
					  $load_h->bind_result($id,$hasil);
					  $load_h->fetch();
					
					 
					}
					
					
					?>
                 <a class="btn-mini btn-black btn-cross"  onclick="fung_del_desk(<?php echo $id .  "," . $cekpoint . "," .$pointke  ; ?>); "><span></span> Delete</a> 
                  <div class="block">
                    <p  id="deskripsi" class="deskripsi">
					<?php   echo $hasil ; ?>
                        
                </div>
            </div>
        </div>