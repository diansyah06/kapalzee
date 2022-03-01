<?php include("../sis32/db_connect.php"); include "../functions.php";
sec_session_start();
//harus ada pengecekan user login maupun yang bersangkutan


date_default_timezone_set('Asia/Jakarta');

		if ($load_tipe= $mysqli->prepare("SELECT id_user , nama, tlp  FROM  og_user ")) { 
				   // Execute the prepared query.
					   $load_tipe->execute();
					   $load_tipe->bind_result($id_user,$Nama,$tlp );
					   


?>

<script type="text/javascript" src="../js/jquery.min_token.js"></script>
    <script type="text/javascript" src="../js/jquery.tokeninput.js"></script>
	
	
	<link href="../css/inbox/token-input-facebook.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
<!--
.style3 {font-family: "Courier New", Courier, monospace}
.style5 {font-size: 14px}
-->
    </style>
    <div>
	
	<script>
	function formsubmit(){
	document.getElementById("form1").submit();
	}
	</script>

	
	  <form id="form1" name="form1" method="post" action="post.php">
  <table id="form" >
    
    <tr>
      <td ><span class="token-input-token-facebook style3">Message To  :</span></td>
      <td width="392"><label>
        <input type="text" id="demo-input-local" name="uids" />
      </label></td>
    </tr>
    <tr>
      <td class="style3"><span class="token-input-list-facebook style5">Message Text </span>:</td>
      <td><label>
        <textarea name="body" style="width:400px; height:120px;"></textarea>
      </label></td>
    </tr>
    <tr>
      <td></td>
      <td> <input type="submit" value="Submit"  onclick=" alert('message Sent');"  /></td>
    </tr>
  </table>
</form>

	
        
       
        <script type="text/javascript">
        $(document).ready(function() {
            $("#demo-input-local").tokenInput([
			
<?php 					   while($load_tipe->fetch()){ 

	
                echo "{id: " . $id_user . ", name: '" . $Nama . "'}," ;

					
		}			   
echo  "{id: 47, name: 'Java'}";
}
						
?>				
            ],{theme: "facebook"});
        });
        </script>
    </div>