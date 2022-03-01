<?php 
include "../functions.php";


sec_session_start();
include("../class/init2.php");
$user_id = $_SESSION['user_id'];


$email_integration= $kpi->get_email_integeration($user_id) ;
foreach ($email_integration as $email_integratio) {

$username_email=$email_integratio['username'];
$pass_email=$email_integratio['pass'];

}


	
?>

<form id="form1" name="form1" method="post" action="http://mail.bki.co.id/names.nsf?Login">
  <table width="200" border="1">
    <tr>
      <th scope="col"><label>
        <input type="hidden" name="%%ModDate" value="071538B800000000" />
      </label></th>
    </tr>
    <tr>
      <td><label>
        <input type="hidden" name="username" value="<?php echo $username_email ;?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>
      <input type="hidden" name="password" value="<?php echo base64_decode($pass_email) ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><label>
        <input type="hidden" name="DWAMode" value="0" />
      </label></td>
    </tr>
    <tr>
      <td><label>
        <input type="hidden" name="$PublicAccess" value="1" />
      </label></td>
    </tr>
    <tr>
      <td><label>
        <input type="hidden" name="reasonType" value="2"  />
      </label></td>
    </tr>
    <tr>
      <td><label>
        <input type="hidden" name="RedirectTo" value="/inotes.nsf" />
        <input type="submit" name="Submit" value="Submit" />
      </label></td>
    </tr>
  </table>
</form>
<?php 
echo     "<script type='text/javascript'>
     
           document.getElementById('form1').submit();
           
		   

    </script>"	;


?>
</body>
</html>
