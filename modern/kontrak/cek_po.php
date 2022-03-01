<?php
				
$pointke=$_GET['point'];
$unixkont=$_GET['id'];
$unixkont=intval($unixkont);
$user_id = $_SESSION['user_id'];
$previl = cekprevil($mysqli) ;


$kontras=$kontrak->get_kontrak_id($unixkont);
foreach ($kontras as $kontra) {
$status= "[ " . $kontra['nama'] . " ]  ID : " . $kontra['id_kontrak'] . "  Start : " . $kontra['dates'] ;


}

//cek hak akses page
$memb = $users->hak_akses_page($user_id,$unixkont);
	if (!$memb){
		echo "<script> window.location = 'panel.php?module=home' ; </script>";
	}




				
	
/* if  ($previl < 5){
	
	if	($user_id != $user){ 
	
	echo "<script type='text/javascript'>
 <!-- 
 window.location = 'panel.php?module=home' //
 --> </script>" ;
 }

} */




?>				
 <!--jQuery Date Picker-->
    <script src="js/jquery-ui/jquery.ui.widget.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.datepicker.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.progressbar.min.js" type="text/javascript"></script>
	<link href="css/themes/base/custom.css" rel="stylesheet" type="text/css" />
   
    <!-- jQuery dialog related-->
	
	 <script type="text/javascript">
        $(document).ready(function () {
           
            setDatePicker('date-picker');
			setDatePicker('date-picker2');
			$('#awal').hide();	
			$('#awal').fadeIn('slow');		
           
            
        });
		
		
function prefi() {
	

window.location='panel.php?module=ed_cek&point=<?php echo ($pointke-1) ;?>&id=<?php echo $unixkont ;?> ';

}	

function forw() {
	

window.location='panel.php?module=ed_cek&point=<?php echo ($pointke+1) ;?>&id=<?php echo $unixkont ;?> ';

}
    </script>
	
	<style type="text/css">
<!--
.style1asdfg {
	font-size: 18px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
}
.style2asdfg {
	font-size: 36px;
	color: #FF00FF;
}
-->
</style>
<div class="box round first">
                <h2>
                   Project <?php  echo  "     " .  "  : " . $status  ; ?></h2>
                <div class="block">
				 <div id="nomer">
				 
		 	
				
				<?php
	$nama_cekpo=array("error","Drawing input","Input Comment");		
				$stile ='style1asdfg';
				
				if ($pointke!=1 ){ echo "<button class='btn btn-yellow' onClick='prefi();' ><-Previous</button> ";}
				$unixRule=intval($_GET['id']);
				echo "&nbsp; &nbsp; &nbsp; &nbsp;";
				$unixRule_link= sprintf ("%04d\n",   $unixRule);
				
				for ($i = 1; $i <= 13; $i++) {
    			
					$link="panel.php?module=ed_cek&point=$i&id=$unixRule_link";
					
					if ($pointke==$i){$stile ='style2asdfg'; } 
					
					echo "<a href='$link'  class='$stile' title='$nama_cekpo[$i]'>$i</a> &nbsp; &nbsp; &nbsp; &nbsp" ;
					$stile ='style1asdfg';
				}
				
				if ($pointke!=13 ){ echo "<button class='btn btn-green' onClick='forw();'>Next  -></button>";}
				
				?>
				
				
				  
				</p>
		 </div>
				
			</div>
</div>

<?php



switch ($pointke) {
	case '1' : include "kontrak/swit_master_draw.php" ; break;
	case '2' : include "coment/master_com.php" ; break;
	
	
	
}


?>