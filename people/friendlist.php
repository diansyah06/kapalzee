<?php



//Load friend list.........
			
?>
<!-- Load TinyMCE -->
<style>
.friends_area{
    width:200px;
	margin:10px 0 3px 12px;
	float:left;color:#000;
	padding:6px;cursor:pointer;
    height:49px;
	-moz-border-radius: 6px; 
	-webkit-border-radius: 6px;
  }
a.close{
	
	color:#666666;
	display:block;
	padding:6px;
	text-decoration:none;
	-moz-background-clip:border;
	-moz-background-inline-policy:continuous;
	-moz-background-origin:padding;
	border:solid #999 1px;
	background:#CCCCCC;
	
	color:#333333;
	cursor:pointer;
	display:inline-block;
	float:left;
	font-family:'Lucida Grande',Tahoma,Verdana,Arial,sans-serif;
	font-size:11px;
	font-weight:bold;
	margin:0 0 0 4px;
	outline-color:-moz-use-text-color;
	outline-style:none;
	outline-width:medium;
	white-space:nowrap;
}
.top_area{
	background:#627AAD;
	font-size:14px;
	color:#FFFFFF;
	font-weight:bold;
	padding:6px 6px 6px 12px;		
}
.name{
	font-size:11px;
	
	padding:0px;
	cursor:pointer;
	font-style:normal;
	padding-left:4px;
	}
#search_area{
	background:#F2F2F2 none repeat scroll 0 0;
	border-bottom:1px solid #E0E0E0;

	color:#999999;
	padding-left:5px;
	padding-top:11px;
	height:26px;
}
.friends_area:hover{ 
	-moz-border-radius: 6px; 
	-webkit-border-radius: 6px;
	background: #F2F2F2;
}
</style>
    <script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            setupTinyMCE();
           
        });
    </script>
	<script src="js/cek_po.js" type="text/javascript"></script> 
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

<div class="top_area" >Friedn lIst </div>
<div id="search_area" align="left">
Your friends will receive a suggestion from you to like this Page.
</div>
<div style="overflow-y:scroll; height:260px; margin-top:3px;">
	<?php
	
	$i = 0;
	
	
	//load foto
	
	
	
	
	
	
		if ($load_tipe= $mysqli->prepare("SELECT  k.id_user , k.nama, k.tlp,c.path  FROM og_user k JOIN rm_biodata c ON c.id_user=k.id_user ")) { 
				   // Execute the prepared query.
					   $load_tipe->execute();
					   $load_tipe->bind_result($id_user,$Nama,$tlp ,$foto);
					   
					   while($load_tipe->fetch()){ 
					   echo "
			<div class='friends_area' id='$id_user' title='$Nama'>
	   	   <img src='$foto'  height='50' width='50' style='float:left;' alt='' class='pic' />
		   <label style='float:left; width:100px; overflow:hidden;' class=name>
			   <a href='panel.php?module=profile&id=$id_user' ><b> $Nama</b></a><br />
			   $tlp 
		   </label>
			<br clear=all />
	   </div>" ;
					   
					   
					   
					   $i++;// just give space after 3 boxes
		if($i%4 == 0) {echo '<br clear="all" /><br clear="all" />';$i = 0;}
					   
					   
					   }	   	   
				}	 
				?>    

</div>


 <br clear="all" />



				</div>
				</div>
				

