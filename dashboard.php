<?php
$salting=$_SESSION['salt'] ;

//message
if ($load_deskr = $mysqli->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path from message2_recips r
inner join message2 m on m.mid=r.mid and m.seq=r.seq
inner join rm_biodata u on u.id_user=m.created_by
where r.uid=? and r.status in ('A', 'N')
and r.seq=(select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('A', 'N'))
and if (m.seq=1 and m.created_by=?, 1=0, 1=1)
order by created_on desc ")) {   
				   // Execute the prepared query.
				   
						 $load_deskr->bind_param('ii', $user_id, $user_id ); 
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($id, $sec, $create_on,$create_by,$body,$status, $alamat );
					   $row_cnt = $load_deskr->num_rows;
					  $emboh = $load_deskr->num_rows;
}					  


//unread message
if ($load_deskr = $mysqli->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path from message2_recips r
inner join message2 m on m.mid=r.mid and m.seq=r.seq
inner join rm_biodata u on u.id_user=m.created_by
where r.uid=? and r.status in ('A', 'N')  and r.status != 'A'  
and r.seq=(select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('N'))
and if (m.seq=1 and m.created_by=?, 1=0, 1=1)
order by created_on desc ")) {   
				   // Execute the prepared query.
				   
						 $load_deskr->bind_param('ii', $user_id, $user_id ); 
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($id, $sec, $create_on,$create_by,$body,$status, $alamat );
					   $row_cnt = $load_deskr->num_rows;
					  $unread = $load_deskr->num_rows;
}					  

//rnd whiteboard
if ($insert_stmt = $mysqli->prepare("SELECT * FROM rm_message where tipe = 2")) {    
		   
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   $insert_stmt->store_result();
		   $whiteBoard_count = $insert_stmt->num_rows;
	}

//project on going

				if ($salting< 5 ){
				$statement = "SELECT  rm_cekpoint.id_cek, rm_cekpoint.rules, rm_cekpoint.start, rm_cekpoint.duedate , rm_ruleslist.Rules  FROM rm_cekpoint JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules   where user = ? and rm_cekpoint.closeby = 0 Order by id_cek Desc " ;
$kond= true ;
				}else {
				$statement = "SELECT  rm_cekpoint.id_cek, rm_cekpoint.rules, rm_cekpoint.start, rm_cekpoint.duedate , rm_ruleslist.Rules  FROM rm_cekpoint JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules Order by id_cek Desc" ;
 $kond= false ;
				}
				
			if ($insert_stmt = $mysqli->prepare($statement)) { 
			 
			if ( $kond ){	   
						   $insert_stmt->bind_param('i', $user_id   ); 
			}  
		   
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   $insert_stmt->store_result();
		   $proj_going_count = $insert_stmt->num_rows;
	}


// project done
if ($salting< 5 ){
				$statement = "SELECT  rm_cekpoint.id_cek, rm_cekpoint.rules, rm_cekpoint.start, rm_cekpoint.duedate , rm_ruleslist.Rules  FROM rm_cekpoint JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules   where user = ? and rm_cekpoint.closeby != 0 Order by id_cek Desc " ;
$kond= true ;
				}else {
				$statement = "SELECT  rm_cekpoint.id_cek, rm_cekpoint.rules, rm_cekpoint.start, rm_cekpoint.duedate , rm_ruleslist.Rules  FROM rm_cekpoint JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules  rm_cekpoint.closeby != 0 Order by id_cek Desc" ;
 $kond= false ;
				}
				
			if ($insert_stmt = $mysqli->prepare($statement)) { 
			 
			if ( $kond ){	   
						   $insert_stmt->bind_param('i', $user_id   ); 
			}  
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   $insert_stmt->store_result();
		   $proj_done_count = $insert_stmt->num_rows;
	}
//wise word

if ($insert_stmt = $mysqli->prepare("SELECT * FROM rm_wisdom where id_user = ?")) {    
		   $insert_stmt->bind_param('i', $user_id   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		   $insert_stmt->store_result();
		   $wise_count = $insert_stmt->num_rows;
	}



?>

<link href="css/timeline.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript">

        $(document).ready(function () {

            setupLeftMenu();
			setSidebarHeight();


        });
		


//gae load wisdom
function getwisdom(){ 
	var modul= "wisdom";
	var act = "show";
	
	$.post("refresh.php", { act: act , modul: modul} , function(html) {
			$('#petuah').html(html);
			$("#petuah").hide();
			$("#petuah").fadeIn(400);});
 
} 
		


		
var auto_refresh = setInterval(
function ()
{

//gae load activyti terakir
	var name_element = document.getElementById('updatee');
	var updatee = name_element.value;

$.ajax({//Make the Ajax Request
		type: "POST",
		url: "refresh.php",
		data: "activity_feed="+ updatee, 
		beforeSend:  function() {

		  
		},
		success: function(html){//html = the server response html code
			$("#updatee").remove();//Remove the div with id=more 
		$("ol#update").prepend(html).fadeIn(800);//Append the html returned by the server .

		}
		});
		getwisdom();
}, 10000);
		
		

		//load more

$('.load_more').live("click",function() {//If user clicks on hyperlink with class name = load_more
var last_msg_id = $(this).attr("id");
//Get the id of this hyperlink 
//this id indicate the row id in the database 
if(last_msg_id!='end'){
    //if  the hyperlink id is not equal to "end"
		$.ajax({//Make the Ajax Request
		type: "POST",
		url: "people/people_proc.php",
		data: "activity="+ last_msg_id, 
		beforeSend:  function() {
		$('a.load_more').html('<img src="img/ajax-loader.gif" />');//Loading image during the Ajax Request
		  
		},
		success: function(html){//html = the server response html code
			$("#more").remove();//Remove the div with id=more 
		$("ol#update").append(html);//Append the html returned by the server .

		}
		});
  
}
return false;


});





		
    </script>	
		
		
            <div class="box round  first">
                <h2>
                    Overview</h2>
					
                <div class="block">
                    <div class="stat-col">
                        <span><a href="panel.php?module=message&amp;sub=inbox">Message</a></span>
                        <p class="purple">
                            <?php echo $emboh ; ?></p>
                  </div>
                    <div class="stat-col">
                        <span><a href="panel.php?module=whiteboard">R &amp; D Whiteboard</a> </span>
                        <p class="yellow">
                            <?php echo $whiteBoard_count ; ?></p>
                  </div>
                    <div class="stat-col">
                        <a href="panel.php?module=message&amp;sub=inbox"><span>Unread Message </span>
                        </a>
                        <p class="green">
                            <?php echo $unread ; ?></p>
                  </div>
                    <div class="stat-col">
                        <span><a href="panel.php?module=lisproj">Project On Going</a></span>
                        
                        <p class="blue">
                            <?php echo $proj_going_count ; ?></p>
                  </div>
                    <div class="stat-col"><span>Project Done</span> 
                      <p class="red">
    <?php echo $proj_done_count ; ?> </p>
                  </div><div class="stat-col">
                        <span><a href="panel.php?module=wisdom">Your Wise Word</a></span>
                        <p class="purple">
                            <img src="img/icon-direction.png" alt="" />&nbsp;<?php echo $wise_count ; ?></p>
                    </div>
                    <div class="stat-col last">
                        <span>Total</span>
                        <p class="darkblue">
                            70,000</p>
                    </div>
                    <div class="clear">
                    </div>
                </div>
            </div>
        </div>
	<style type="text/css">

</style>	
		
			<div class="grid_5">
<div class="box round">
                <h2>Activity</h2>
					  <div id="flash"></div>
<script src="js/cek_po.js" type="text/javascript"></script>

		  <script src="js/pace.min.js"></script>
		 <link href="css/pace_theme.css" rel="stylesheet" />
					  
                <div id="team" class="team">
				<div id="flash" align="left"  ></div>
					
<?php
   
   

   $usericonlist = '<h1>User List</h1>';  
   
   $usericonlist .= '<div class="userthumbs">';
   $cekpoint=46;
   $lastaktifiti=$Activity->get_last_activity();
   foreach ($lastaktifiti as $lastaktifit) {
   
   $idlast= $lastaktifit['id'];
   }
   
   
   $aktivitys=$Activity->get_activity(3);
    echo " <div style='overflow-y:scroll; height:632px; margin-top:3px; '> <input type='hidden' id='updatee' name='updatee' class='updatee' value=$idlast /> <ol  id='update' class='timeline'>	";
   foreach ($aktivitys as $aktivity) {
   
   $sesuaiformat=$Activity->format_tanggal($aktivity['date_hour']);
   
  
			
					   echo "<div title='$aktivity[nick]' class='friends_area' ><img src='$aktivity[path]' height='45' style='float:left;' alt=''> 
		   					<label style='float:left' class='name'>
		   					<b>$aktivity[nick] </b><br> <span class='aktifitas'> $aktivity[name_activity] </span> <span style='padding: 4px 10 30px 18px; width:30' class='db-ico ico-$aktivity[icon]'> </span> <a class='terusan-$aktivity[icon]' style='font-weight:bold;' href='$aktivity[link]'> $aktivity[object] </a><br>
							<span class='tanggalfeed'>
		    				$sesuaiformat </span></label></div>";
							
							$last_id= $aktivity['id'];
   
   }
   
echo "</ol>	<div id='more' style='margin-top: 20px;'> <a  id=$last_id class='load_more' href='#'>more</a> </div></div>";
			   
   
	
        
   
				
?>
			
				
				
			</div>
</div>
</div>


        <div class="grid_5">
            <div class="box round">
                <h2>
                    R & D  White Board</h2>
                <div class="block">
                    <p class="start">
                        <img src="img/horizontal.jpg" alt="Ginger" class="left" />
						<?php
		if ($load_deskr = $mysqli->prepare("SELECT rm_message.id , rm_message.message, rm_message.dari,  rm_message.tipe, rm_message.tanggal , og_user.nama FROM rm_message JOIN og_user ON og_user .id_user=rm_message.dari where tipe = '2' order by id DESC LIMIT 1")) {   
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($id, $message, $dari,$tipe,$tanggal, $nama );

				
					   while($load_deskr->fetch()){
					    $tanggal=strtotime($tanggal);
					   $tanggal=date('l jS \of F Y',$tanggal);
					   
					   echo "<div style='text-align:center;' ><b><p> $tanggal </p> <p>$message</p><b>--$nama--<b><hr> </> </div>"; 
				
				
						}
					}
	?>
                </div>
            </div>
        </div>
        <div class="grid_5">
            <div class="box round" >
                <h2>
                    Wisdom</h2>
                <div class="block">
				<h4> "Quote" Of The day </h4>
                    <p class="start">
					
                        <img src="img/vertical.jpg" alt="Ginger" class="right" />
                    <p>
					<div id="petuah" class "petuah">
				<?php	
					if ($load_tipe= $mysqli->prepare("SELECT rm_wisdom.id , rm_wisdom.isi, rm_wisdom.tanggal , rm_wisdom.id_user , og_user.nama  FROM  rm_wisdom JOIN og_user ON og_user .id_user=rm_wisdom.id_user order by rand() Limit 1 ")) {
				   // Execute the prepared query.
					   $load_tipe->execute();
					   $load_tipe->bind_result($id,$isi,$tanggal , $user , $nama );
					   $buang=array();
					   while($load_tipe->fetch()){ 
					   $tanggal=strtotime($tanggal);
					   $tanggal=date('l jS \of F Y',$tanggal);
					   
					   
					   echo " <b>$tanggal <b><p> $isi <p> <b>--$nama <b><hr> " ;
					   
					   
					    }	   	   
				}	     
					
					?>
                        </p>
					</div>	
                </div>
            </div>
        </div>
