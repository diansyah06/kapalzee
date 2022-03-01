<?php
$user_id = $_SESSION['user_id'];

$email_integration= $kpi->get_email_integeration($user_id) ;
foreach ($email_integration as $email_integratio) {

$username_email=$email_integratio['username'];
$pass_email=$email_integratio['pass'];

}


if (isset($username_email)){ 
$statement="<iframe src='./plugin/email_bki.php' width='1200px' height='900px'></iframe>";

}else{
$statement= "<p align='center'>Anda belum memasukkan configurasi email bki</p>
<p align='center'><a href='./panel.php?module=editprofile' class='style9'>Click here to configurasi </a></p>";

}


?>
<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
		
		
		
</script>
<style type="text/css">
<!--
.style9 {color: #0000FF;
font-weight: bold;

}

-->
</style>

<script type="text/javascript" src="js/cek_po.js"></script>
<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>

 <div class="box round first">
                <h2>
                    BKI Email Integration </h2>
   <div class="block">
                    <!-- paragraphs -->
                    <p class="start">
                     
					 <?php echo $statement ; ?>
					 
					 </p>
   </div>
 </div>