<script type="text/javascript" src="js/charCount.js"></script>

 <script type="text/javascript">
$(function() {
	$("#message1").charCount({});

$(".comment_button").click(function() {
	var modul= "whiteboard";
	var act = "add_whiteboard";

   
    var boxval = $("#message1").val();
	
    var dataString = 'whiteboard='+ boxval ;
	
	if(boxval=='')
	{
	alert("Please Enter Some Text");
	
	}
	else if(boxval.length >= 150 ) 
	{ alert("Message to long"); }
	
	else {
	$("#flash").show();
	$("#flash").fadeIn(400).html('<img src="img/ajax-loader.gif" align="absmiddle">&nbsp;<span class="loading">Loading Comment...</span>');
$.ajax({
		type: "POST",
  url: "people/people_proc.php",
   data: dataString,
  cache: false,
  success: function(html){
 
  $("ol#update").prepend(html);
  $("ol#update li:first").slideDown("slow");
   document.getElementById('message1').value='';
  $("#flash").hide();
	
  }
 });
}
return false;
	});


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
data: "lastmsg="+ last_msg_id, 
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

});


</script>
<link href="css/whiteboard/wtfdiary.css" rel="stylesheet" type="text/css">
<link href="css/whiteboard/style.css" rel="stylesheet" type="text/css">
<div class="box round">
                <h2>
                    Research And Development White Board</h2>
    
				 <p class="start">
                      <div id="container">

<div id='cover_container' style="background:url('img/cover.jpg');">
<div id='info_box'>
<div id="profile_img"><img src='img/profil/image.jpg' class='avatar_img'/></div>

<div id="info-box">
<div id="info-name"><b>Whiteboard  </b></div>
<div id="info-content">
<div style="float:right">
<div><a href='change_cover.php'><img src='img/cameraa.png' title='Change Cover Picture'/></a></div>
</div>

<div id="info-photos">
<div>Photos</div>
<div><b>17</b></div>
</div>

<div id="info-friends">
<div>Friends</div>
<div><b>270</b></div>
</div>

</div>
</div>

<div style='clear:both'></div>

</div>
</div>

<div id="container-content">
<div id="content">
<style>
.load_more {
	background-color:#FFFFFF;
	background-image:url("more.gif");
	background-position:left top;
	background-repeat:repeat-x;
	border-color:#DDDDDD #AAAAAA #AAAAAA #DDDDDD;
	border-style:solid;
	border-width:1px;
	display:block;
	font-size:14px;
	font-weight:bold;
	height:22px;
	line-height:1.5em;
	margin-bottom:6px;
	outline:medium none;
	padding:6px 0;
	text-align:center;
	text-shadow:1px 1px 1px #FFFFFF;
	width:100%;
}
.load_more {
	-moz-border-radius:5px 5px 5px 5px;
}
.load_more:hover {
	background-position:left -78px;
	border:1px solid #BBBBBB;
	text-decoration:none;
}
.load_more:active {
	background-position:left -38px;
	color:#666666;
}
a {
	color:#2276BB;
	text-decoration:none;
	}
form div{position:relative;margin:1em 0;}
form .counter{
	position:absolute;
	right:0px;
	top:-25px;
	font-size:20px;
	font-weight:bold;
	color:#ccc;
	}
form .warning{color:#600;}	
form .exceeded{color:#e00;}	
}
</style>
	<div>
		<h2>What is happening?</h2> <label for="message">Type your message</label>
		<form id="form" method="post" action="">  

    	<div>
        	<textarea name="message1" id="message1" style="width: 100%; height: 66px;" ></textarea>
			<input type="submit"  value="Update"  id="v" name="submit" class="comment_button"/>
        </div>	
    

    </form>
		<div id="flash" align="left"  ></div>
	<br clear="all" /><br clear="all" />
	<ol  id="update" class="timeline">	
	
	<?php
		if ($load_deskr = $mysqli->prepare("SELECT r.id , r.message, r.dari,  r.tipe, r.tanggal,u.path  FROM rm_message r inner join rm_biodata u on u.id_user=r.dari where tipe = '2' order by id DESC LIMIT 5")) {   
				   // Execute the prepared query.

					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($id, $message, $dari,$tipe,$tanggal, $alamat );

				
					   while($load_deskr->fetch()){
					   echo "<div class='separate' id='id-$id'><a  href='panel.php?module=profile&id=$dari'><img src='$alamat'style='height:60px;' /></a> <div class='tanggal'>  $tanggal </div><p>$message</p></div>"; 
				
				
						}
					}
	?>
	
		
</ol>		
	<div id="more" style="margin-top: 20px;"> <a  id="<?php echo $id; ?>" class="load_more" href="#">more</a> </div>
	</div>
	
	

</div>

</div>

				</div>
				</div>
				

