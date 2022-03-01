<?php  include("../sis32/db_connect.php"); include "../functions.php";
sec_session_start();
date_default_timezone_set('Asia/Jakarta');
$user_id = $_SESSION['user_id'];	

$per_page = 5;

$page = $_REQUEST['page'];

$start = ($page-1)*5;


if ($load_deskr = $mysqli->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status ,u.path from message2_recips r
inner join message2 m on m.mid=r.mid and m.seq=r.seq
inner join rm_biodata u on u.id_user=m.created_by
where m.created_by=? and r.uid=?
and r.status != 'D'
order by created_on desc limit ? , 5 ")) {   
				   // Execute the prepared query.
				   
						 $load_deskr->bind_param('iii', $user_id, $user_id, $start ); 
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($id, $sec, $create_on,$create_by,$body,$status, $alamat );
					   $row_cnt = $load_deskr->num_rows;
					  $emboh = $load_deskr->num_rows;

?>

<?php
while($load_deskr->fetch())
{?>
	<div class="shopp" onclick="location.href='panel.php?module=viewinbox&id=<?php echo $id ; ?>';" style="cursor:pointer;" >
		
		<img src="<?php echo $alamat ;?>" width="75" style="float:left" /><div class='tanggal'><?php echo $tanggal .'<img src=' . 'img/inbox/' . $status . '.png  width=10; />' ;?></div>
		<div class="label"><?php echo $body ;?> <p> </p></div>
	
	</div>
<?php
}

}?>

<script type="text/javascript">
$(document).ready(function(){
	
	var Timer  = '';
	var selecter = 0;
	var Main =0;
	
	bring(selecter);
	
});

function bring ( selecter )
{	
	$('div.shopp:eq(' + selecter + ')').stop().animate({
		opacity  : '1.0',
		height: '80px'
		
	},300,function(){
		
		if(selecter < 6)
		{
			clearTimeout(Timer); 
		}
	});
	
	selecter++;
	var Func = function(){ bring(selecter); };
	Timer = setTimeout(Func, 20);
}

</script>