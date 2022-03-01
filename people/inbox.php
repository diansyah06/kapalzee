<link href="css/inbox/css.css" rel="stylesheet" type="text/css">
 <!-- jQuery dialog related-->
    <script src="js/jquery-ui/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.mouse.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.draggable.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.position.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.resizable.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.dialog.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.core.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.blind.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.explode.min.js" type="text/javascript"></script>
    <!-- jQuery dialog end here-->
	<link href="css/themes/base/custom.css" rel="stylesheet" type="text/css" />


	<script src="js/cek_po.js" type="text/javascript"></script> 
	<script src="js/setup.js" type="text/javascript"></script> 

<?php

$submodul=$_GET['sub'];

if ($submodul=="inbox" ) {$link = "loadinbox.php" ; } 

else if ($submodul=="sent"){ $link = "loadsent.php" ; }

else{

die ;}

?>


	
<script type='text/javascript'>

$(document).ready(function(){

	 
	function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
	
	$('#paging_button li').click(function(){
		
		showLoader();
		
		$('#paging_button li').css({'background-color' : ''});
		$(this).css({'background-color' : '#006699'});

		$('#content').load('people/<?php echo $link  ; ?>?page=' + this.id, hideLoader);
		
		return false;
	});
	
	$('#1').css({'background-color' : '#006699'});
	showLoader();
	$('#content').load('people/<?php echo $link  ; ?>?page=1', hideLoader);
	
});
</script>
<?php
$per_page = 5;


if ($load_deskr = $mysqli->prepare("SELECT id , message, dari,  tipe, tanggal FROM rm_message where tipe = '2' ")) {   
				   // Execute the prepared query.
	
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($id, $message, $dari,$tipe,$tanggal );
					   $row_cnt = $load_deskr->num_rows;
					$count = $load_deskr->num_rows;
					  $pages = ceil($count/$per_page);
					  
					}
					  
?>

<div class="box round">
                <h2>
                    Friend List</h2>
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
						  <button id="opener" onclick="openWin();" >
                                    + Send New Message</button>

<div align="center"> 

	<div id="container">
	
		<div class="search-background">
			<label><img src="img/loader.gif" alt="" /></label>
		</div>
	
		<div id="content">
		&nbsp;
		</div>
		
	</div>
	
	<div id="paging_button" align="center">
		<ul>
		<?php
		//Show page links
		for($i=1; $i<=$pages; $i++)
		{
			echo '<li id="'.$i.'">'.$i.'</li>';
		}?>
		</ul>
	</div>
	<div><br></br>
		<!--<form id="form" method="post" action="">  

    	<div>
        	<textarea name="message1" class="message1" id="message1" style=" height: 66px;" ></textarea><br />
			<input type="submit"  value="Update"  id="v" name="submit" />
        </div>	
    

    </form>-->
</div>
</div>
<script>
function openWin()
{
myWindow=window.open('people/new_message.php','','width=600,height=220');
myWindow.focus();
}
</script>
								
								
								
				</div>
				</div>
				

