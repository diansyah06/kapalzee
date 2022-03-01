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

	
	  <form id="form1" name="form1" method="post" action="proc_forgot.php">
  <table id="form" >
    
    <tr>
      <td ><span class="token-input-token-facebook style3">Name  :</span></td>
      <td width="392"><label>
        <input type="text" id="demo-input-local" name="uids" />
      </label></td>
    </tr>
    <tr>
      <td class="style3"><span class="token-input-token-facebook style3">NUP  : (only number eq 8971) </span></td>
      <td><label>
        <input type="number" name="nup" required  />
      </label></td>
    </tr>
    <tr>
      <td><span class="style3"><span class="token-input-list-facebook style5">Reset passwords </span>:</span></td>
      <td><input name="submit" type="submit"   value="Submit"  /></td>
    </tr>
  </table>
</form>

	
        
       
        <script type="text/javascript">
        $(document).ready(function() {
            $("#demo-input-local").tokenInput([
			
<?php 					   


			while($load_tipe->fetch()){ 
	
                echo "{id: " . $id_user . ", name: '" . $Nama . "'}," ;
			}			   
		
}
						
?>				
            ],{theme: "facebook"});
        });
        </script>
    </div>