


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
	

<div class="box round">
                <h2>
                    View Message</h2>
                <div class="block">
				 <p class="start">
                        Lorem Ipsum is simply dummy
                        text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only
                        five centuries, but also the leap into electronic typesetting, remaining essentially
                        unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
                        Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum.</p> <hr />
						  <button id="opener" onclick="openWin();" >
                                    + Send New Message</button>

<div align="center"> 
	<div id="container">
		<div id="content">


<?php 
date_default_timezone_set('Asia/Jakarta');
$user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['usernama'] ;	
$currentUser=$user_id;


print "<h2>Viewing message Threat: " . $_GET['id'] . "</h2>";

/* $dsn = 'mysql:host=localhost;dbname=rms';
$PDO = new PDO($dsn, 'root', ''); */
$PDO =$db;
$sql = "select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path from message2_recips r
inner join message2 m on m.mid=r.mid and m.seq=r.seq
inner join rm_biodata u on u.id_user=m.created_by
where r.uid=? and m.mid=? and r.status in ('A', 'N') order by m.created_on DESC ";
$stmt = $PDO->prepare($sql);
$args = array($currentUser, $_GET['id']);

if (!$stmt->execute($args)) {
    die('error');
}
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($rows)) {
    /** get all of the people this is between **/
    $sql = "select distinct(uid) as uid, u.path as alamat , o.nama as jeneng from message2_recips r inner join rm_biodata u on r.uid=u.id_user join og_user o on u.id_user=o.id_user where mid=? ";
    $stmt = $PDO->prepare($sql);
    $args = array($_GET['id']);
    $stmt->execute($args);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $uids = array();
	$alamat= array();
	$id_users= array();
    foreach ($results as $result) {
        $uids[] = $result['uid'];
		$id_users[] = $result['uid'];
		$alamat[] = $result['alamat'];
		$jeneng[] = $result['jeneng'];
    }
    $last = array_pop($uids);

	
    print '<p>Conversation between ';
    print implode(', ', $uids) . ' and ' . $last;
    echo '.</p>';

	
	$arrlength=count($alamat);

for($x=0;$x<$arrlength;$x++)
  {
 echo  "<a href='panel.php?module=profile&id=$id_users[$x]'><img  src='$alamat[$x]' title='$jeneng[$x]'  style='width:50px;height:50px; padding:3px;' > </a>" ;
  
  
  }

	
   echo "</p>";
	
    foreach ($rows as $row) {
     /*   echo '<tr><td>' . $row['created_by'] . '</td><td>' . $row['created_on'];
                echo '</td><td>' . $row['body'] . '</td></tr>';
				*/
				
				
		echo "<div class='shopp'>
		
		<img src='" . $row['path'] . "'  width='75' style='float:left'  /><div class='tanggal'>" . $row['created_on'] . "'<img src='img/inbox/a.png'" . $status . "'a.png  width=10; />' </div>
		<div class='label'> ".  $row['body'] . " <p> </p></div>
	
	</div>" ;
	
				
    }



    /** now update the message to viewed **/
    $sql = "update message2_recips set status='A' where status='N' and mid=? and uid=?";
    $stmt = $PDO->prepare($sql);
    $args = array($_GET['id'], $currentUser);
    $stmt->execute($args);

    echo '<form action="people/post.php" method="post">';
    echo '<strong>Reply:</strong><br />';
    echo '<textarea name="body" ></textarea><br />';
    echo '<input type="hidden" name="mid" value="' . $row['mid'] . '" />';
    echo '<input type="submit" value="reply" /></form>';
}
else {
    echo 'Cannot find this message';
}
echo '<div><a href="panel.php?module=message&sub=inbox">Inbox</a></div>';
echo '<div><a href="./people/delete.php?id=' . $_GET['id'] . '">Delete</a></div>';

?>
















		

		
		
		</div>
	</div>
</div>
	
	
	<!--<div><br></br>
		<form id="form" method="post" action="">  

    	<div>
        	<textarea name="mid" class="message1" id="message1" style=" height: 66px;" ></textarea><br />
			<input type="submit"  value="Update"  id="v" name="submit" />
        </div>	
    

    </form>
</div>-->

<script>
function openWin()
{
myWindow=window.open('people/new_message.php','','width=600,height=220');
myWindow.focus();
}
</script>
			
				</div>
				</div>
				

