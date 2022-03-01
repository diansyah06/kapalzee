<?php

if (isset($_GET['id'])){
$user_ids=$_GET['id'];

}else {
$user_ids = $_SESSION['user_id'];
$nama_userr = $_SESSION['usernama'] ;

}





if ($load_deskr = $mysqli->prepare("SELECT  jabatan, alamat, email, ym, fb, handphone, tujuan, edukasi, pekerjaan, path  FROM rm_biodata  where id_user  = ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('i', $user_ids ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($jabatans, $alamatt,$emaill, $ym, $fbb , $handphonee , $tujuann , $edukasi , $pekerjaann , $patha );

				
					   $load_deskr->fetch();
					   
					   //load nama 
					   if ($load_naama = $mysqli->prepare("SELECT  nama, nick FROM og_user  where id_user  = ?  LIMIT 1")) {  
					   
					    $load_naama->bind_param('i', $user_ids ); // Bind "$id_rules" to parameter.
					   $load_naama->execute();
					    $load_naama->store_result();
					   $load_naama->bind_result($namaaa,$nick );
						
				
					   $load_naama->fetch();
					   $nama_userr=$namaaa;
					   }
					   
					   
	}				
	
	if ($load_deskr = $mysqli->prepare("SELECT  tipe, mulai, akhir, nama  FROM rm_sub_biodata  where id_user  = ? Order by id ASC ")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('s', $user_ids ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($tipe, $mulai, $akhir,$nama );

				$edu=array();
				$training=array();
				$experience =array();
				$skill=array();
				
				while($load_deskr->fetch()){
				
				 
				
				if ($tipe==1){      
				$edu[]="<div class='content'><h3>Augt $mulai - July $akhir</h3><p>$nama <br /></p></div>";
				
				}else if ($tipe==2){
				$training[]="<div class='content'><h3>Augt $mulai - July $akhir</h3><p>$nama <br /></p></div>";
				
				}else if ($tipe==3) {
				$experience[]="<div class='content'><h3>Augt $mulai - July $akhir</h3><p>$nama <br /></p></div>";
				
				}else if ($tipe==4) {
				$skill[]="<li>$nama</li>";
				
				}
					   
					   
					   
					   }
}

$status_yma=extractnama($ym);
$status_ym=yahoo($status_yma);

if ($status_ym=="online"){$link_ym= "img/YM_online.png" ; }else { $link_ym= "img/YM_offline.png" ;  }



//fungsi pernak pernik
function yahoo($id){ 


    $url = 'http://opi.yahoo.com/online?u='; 
    $data = FILE_GET_CONTENTS($url . $id); 
    IF (TRIM(STRTOLOWER(STRIP_TAGS($data))) != 'user not specified.') { 
        RETURN (STRLEN($data) == 140) ? 'online' : 'offline'; 
    } ELSE { 
    RETURN TRIM(STRIP_TAGS($data)); 
    } 
    } 
	
function extractnama($text)
{
  $part = explode('@',$text);
 $left_part = $part[0];
$left_part = preg_replace('/[^a-zA-Z0-9_ -%][().][\/]/s', '', $left_part);
    return $left_part;
}
	
?>

<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>

<script type="text/javascript">

        $(document).ready(function () {


            $('.datatable').dataTable();
			setSidebarHeight();
			


        });
</script>
<link type="text/css" rel="stylesheet" href="css/green.css" />
<link type="text/css" rel="stylesheet" href="css/print.css" media="print"/>
 <div class="box round first">
                <h2>
                    Profil Menu </h2>
   <div class="block">
                    <!-- paragraphs -->
                    

	    <p>&nbsp;</p>
                   <!-- mulaiiiiii -->
   <div id="paper-mid">
        <div class="entry">
          <!-- Begin Image -->
		  <?php if ($patha == ""){ $patha="img/img-profile.jpg" ; } ?>
		  
          <img class="portrait" src="<?php echo $patha ;?>" alt="batosai" />
          <!-- End Image -->
          <!-- Begin Personal Information -->
          <div class="self">
            <h1 class="name"><?php echo $nama_userr ; ?> <br />
              <span><?php echo  $jabatans ; ?> </span></h1>
            <ul>
              <li class="ad"><?php echo  $alamatt; ?></li>
			  
              <li class="mail"><?php echo  $emaill ; ?></li>
              <li class="tel"><?php echo  $handphonee ; ?></li>
              <li class="web"><?php echo  $fbb ; ?></li>
			  
            </ul>
          </div>
          <!-- End Personal Information -->
          <!-- Begin Social -->
          <div class="social">
            <ul>
              <li><a class='north' href="ymsgr:sendIM?<?php echo $status_yma ; ?>" title="yahoo messenger <?php echo $status_ym ; ?>"><img src="<?php echo $link_ym ; ?> " style="width:23px;" alt="yahoo messenger <?php echo $status_ym ; ?>"  /></a></li>
              <li><a class='north' href="javascript:window.print()" title="Print"><img src="img/profil/icn-print.jpg" alt="" /></a></li>
              <li><a class='north' id="contact" href="#" onclick="openWin();" title="Message Me"><img src="img/profil/icn-contact.jpg" alt="" /></a></li>
              <li><a class='north' href="#" title="Follow me on Twitter"><img src="img/profil/icn-twitter.jpg" alt="" /></a></li>
              <li><a class='north' href="<?php echo  $fbb ; ?>"  target="_blank" title="My Facebook Profile"><img src="img/profil/icn-facebook.jpg" alt="" /></a></li>
            </ul>
          </div>
          <!-- End Social -->
        </div>
        <!-- Begin 1st Row -->
        <div class="entry">
          <h2>OBJECTIVE</h2>
          <p><?php echo  $tujuann ; ?>.</p>
        </div>
        <!-- End 1st Row -->
        <!-- Begin 2nd Row -->
        <div class="entry">
          <h2>EDUCATION</h2>
		  <?php foreach ($edu as $isi) { echo $isi ;} ?>
          
        </div>
        <!-- End 2nd Row -->
        <!-- Begin 3rd Row -->
        <div class="entry">
          <h2>EXPERIENCE</h2>
		  <?php foreach ($experience as $isi) { echo $isi ;} ?>
          
        </div>
		
		 <div class="entry">
          <h2>Training</h2>
		  <?php foreach ($training as $isi) { echo $isi ;} ?>
          
        </div>
		
        <!-- End 3rd Row -->
        <!-- Begin 4th Row -->
        <div class="entry">
          <h2>SKILLS</h2>
          <div class="content">
            <h3> Knowledge</h3>
            <ul class="skills">
			<?php foreach ($skill as $isi) { echo $isi ;} ?>
            
            </ul>
          </div>
          <div class="content">
            <h3>Languages</h3>
            <ul class="skills">
              <li>Indonesia</li>
              <li>English</li>
              <li>Java</li>
              <li>Visual</li>
              <li>ActionScript</li>
              <li>C++</li>
            </ul>
          </div>
        </div>
        <!-- End 4th Row -->
         <!-- Begin 5th Row -->
        <div class="entry">
        <h2>WORKS</h2>
        	<ul class="works">
			<?php echo $pekerjaann ; ?>
        		<li><a href="img/profil/1.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="img/profil/image.jpg" alt="" /></a></li>
        		<li><a href="img/profil/2.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="img/profil/image.jpg" alt="" /></a></li>
        		<li><a href="img/profil/3.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="img/profil/image.jpg" alt="" /></a></li>
        		<li><a href="img/profil/1.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="img/profil/image.jpg" alt="" /></a></li>
        		<li><a href="img/profil/2.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="img/profil/image.jpg" alt="" /></a></li>
        		<li><a href="img/profil/3.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="img/profil/image.jpg" alt="" /></a></li>
        		<li><a href="img/profil/1.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="img/profil/image.jpg" alt="" /></a></li>
        		<li><a href="img/profil/1.jpg" rel="gallery" title="Lorem ipsum dolor sit amet."><img src="img/profil/image.jpg" alt="" /></a></li>
        	</ul>
        </div>
        <!-- Begin 5th Row -->
      </div>

   
   
           <!-- mulai -->
   </div>
 </div>
 
 <div class="box round ">
                <h2>
                    My work This Month. ! </h2>
					
					
					

 <div class="deskripsi">
				
	<?php			
	$user_id = $user_ids;
	$year= date("Y");
	$month= date("m");
	
	
	
	$PreviousMonth = mktime(0, 0, 0, $month - 1, 1, $year);
	$CurrentMonth = mktime(0, 0, 0, $month, 1, $year);
	$NextMonth = mktime(0, 0, 0, $month + 1, 1, $year);
	
	$awal=date('Y-m-d', $CurrentMonth);
	$akhir=date('Y-m-d', $NextMonth);
	
				$kpiss=$kpi->get_kpi_user($user_id,$awal,$akhir);
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Kegiatan</th>
											<th>Jenis</th>
											<th>Group</th>
											<th>Start</th>
											<th>Finish</th>
											<th>Surat</th>
											
											
											
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($kpiss as $kpis) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td title='$kpis[keterangan]'>" . $kpis['name'].  " </a></td>
									<td >". $kpis['jenis']. "</td>
									<td>" . $kpis['Grup'] . "</td>
									<td>" . $kpis['star'] ."</td>
									<td>". $kpis['finish'] ."</td>
									<td>". $kpis['surat']. "</td>
									
									
									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table><hr>";
	
	
			 
	?>			 
				</div>
</div>
  