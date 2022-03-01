<?php

$kontraks=$kontrak->get_kontrak();
	$salting = $_SESSION['salt'];



if(isset($_GET['error'])) { 
   
   echo 'Error Logging In!';
   
   }

if($salting < 2) {
	
 echo "<script type='text/javascript'>
 <!-- 
 window.location = 'panel.php?module=home' //
 --> </script>" ;
 die;

	}
	
if(isset($_GET['del'])) { 

	$ids=$_GET['ids'];
   	$gambars = $drawing->get_proj_gambar_temp_almat($ids);
   	if (file_exists($gambars)) {
   	unlink($gambars);
	}
   $drawing->Delete_proj_gambar_temp($ids);
   
   }	
	
	
if(isset($_POST['checkbox'])){$checkbox = $_POST['checkbox'];



 
$size = count($_POST['checkbox']);
 
$i = 0;

while ($i < $size) {

$id = $_POST['checkbox'][$i];

$no_gamb= $_POST['textfield'][$id];
$judul= $_POST['textfield2'][$id];
$tipe= $_POST['radiobutton1'][$id];

$doc_tipe= $_POST['radiobutton'][$id];


$drawing->update_proj_gambar_temp($no_gamb, $judul , $tipe,$doc_tipe,$id );

++$i;
}
 }
?>


<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
		
</script>


<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="css/themes/base/custom.css" rel="stylesheet" type="text/css" />
<div class="box round first">
                <h2>
          			List Upload Document Or Drawing </h2>
<div class="block">
				

                  <form id="form1" name="form1" method="post" action="">
				  <div class="CSSTableGenerator" >
				  <table  border="1">
                  <tr>
                    <td width="25">&nbsp;</td>
                    <td ><strong>Name of File </strong></td>
                    <td ><strong>No Drawing or Doc </strong></td>
                    <td ><strong>Title</strong></td>
                    <td width="258"><strong>Department</strong></td>
                    <td width="150"><strong>Document_Tipe</strong></td>
					<td width><strong>Pid</strong></td>
                    <td ><strong>Action</strong></td>
                  </tr>
                  <tr>
				  <?php 	

$per_page = 25; // number of results to show per page
$result = $drawing->get_proj_gambar_temp(0,9000);
$total_results = count($result) ;
$total_pages = ceil($total_results / $per_page);//total pages we going

if (isset($_GET['page'])) {
$show_page = $_GET['page']; //current page
if ($show_page > 0 && $show_page <= $total_pages) {
$start = ($show_page - 1) * $per_page;
$end = $start + $per_page;
} else {
// error - show first set of results
$start = 0;
$end = $per_page;
}
} else {
// if page isn't set, show first set of results
$start = 0;
$end = $per_page;
}
// display pagination
$page = intval($_GET['page']);
$tpages=$total_pages;
if ($page <= 0)
$page = 1;




	$get_draws=$drawing->get_proj_gambar_temp($start,$end);



	foreach ($get_draws as $get_draw) {	
		$structure="";
		$elec="";
		$machni="";
		
		$doc="";
		$draw="";
		
		if ($get_draw['tipe']==1) {$structure=" checked"; }
		if ($get_draw['tipe']==2) {$elec=" checked"; }
		if ($get_draw['tipe']==3) {$machni=" checked";}
		
		if ($get_draw['doc_tipe']==1) {$draw=" checked"; }
		if ($get_draw['doc_tipe']==2) {$doc=" checked"; }
	
	
	
	
		echo "<td><input type='checkbox' name='checkbox[]' id='checkbox' value='". $get_draw['id'] . "' /></td>
                    <td><a href='kontrak/reads.php?module=read&kon=$proj_id&gam=$get_draw[id]'" .  "target='_blank'>" . $get_draw['nama_file'] . "</a></td>
                    <td><label><input type='text' id='textfield[". $get_draw['id']. "]' name='textfield[". $get_draw['id']. "]' value='". $get_draw['no_gamb'] . "' /></label></td>
                    <td><label><input  name='textfield2[". $get_draw['id']. "]' type='text' size='50' value='". $get_draw['judul'] . "'/></label></td>
					
                    <td><label><input name='radiobutton1[". $get_draw['id'] ."]' type='radio' value='1' ". $structure . " />Structure</label><label><input name='radiobutton1[". $get_draw['id'] ."]'  type='radio' value='3' ". $machni . "/>Machinery & system</label><label><input name='radiobutton1[". $get_draw['id'] ."]'  type='radio' value='2' ". $elec . " />Electrical</label></td>
					
                    <td><label><input name='radiobutton[". $get_draw['id'] ."]' type='radio' value='2' ". $doc . "/>Document</label><label><input name='radiobutton[". $get_draw['id'] ."]' type='radio' value='1' ". $draw . "/>Drawing</label></td>
					
					<td>". $get_draw['kontrak_id'] . "</td>
                    <td><a href='panel.php?module=u_bulkss&del=y&ids=$get_draw[id]'>"  . Delete . " </a></td>
                  </tr>" ;
 
	}
 
 echo                "</table></div><p></p>" ;


















 
 
 
 
 
 
 
 
 
 
 
 
 
 
$reload = $_SERVER['PHP_SELF'] . "?module=u_bulkss&tpages=" . $tpages;
echo '<div  id="paging_button" align="center"><ul id="pagination-flickr">';
if ($total_pages > 1) {
echo $paging->paginate($reload, $show_page, $total_pages);
}
echo "</ul></div><p></p><br></br>";
 
 
 
 
 
 
 
 
 
 
?>
                  
				  <script language="JavaScript">

function checkAll()
{
 var cbs = document.getElementsByTagName('input');
 for(var i=0; i < cbs.length; i++)
 {
    if(cbs[i].type == 'checkbox')
    {
        cbs[i].checked = true;
     }
 }
}

function uncheckAll()
{
 var cbs = document.getElementsByTagName('input');
 for(var i=0; i < cbs.length; i++)
 {
    if(cbs[i].type == 'checkbox')
    {
        cbs[i].checked = false;
     }
 }
}
</script>

                  <tr>
                    <table>
                      <tr>
                        <td><label>
                          <input type="button" name="Submit2" value="Check All" onClick="checkAll();" />
                        </label></td>
                        <td><input type="button" name="Submit3" value="uncheck All"  onclick="uncheckAll();" /></td>
                        <td><label>
                          <input type="submit" name="Submit" value="Submit" />
                        </label></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><label></label></td>
                      </tr>
                    </table>
                  </form>
                  <tr>
				  
<style>
.CSSTableGenerator {
	margin:0px;padding:0px;
	width:100%;

	border:1px solid #000000;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.CSSTableGenerator table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	
	margin:0px;padding:0px;
}.CSSTableGenerator tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.CSSTableGenerator table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.CSSTableGenerator table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.CSSTableGenerator tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.CSSTableGenerator tr:hover td{
	
}
.CSSTableGenerator tr:nth-child(odd){ background-color:#aad4ff; }
.CSSTableGenerator tr:nth-child(even)    { background-color:#ffffff; }.CSSTableGenerator td{
	vertical-align:middle;
	
	
	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:7px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.CSSTableGenerator tr:last-child td{
	border-width:0px 1px 0px 0px;
}.CSSTableGenerator tr td:last-child{
	border-width:0px 0px 1px 0px;
}.CSSTableGenerator tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.CSSTableGenerator tr:first-child td{
		background:-o-linear-gradient(bottom, #005fbf 5%, #003f7f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #005fbf), color-stop(1, #003f7f) );
	background:-moz-linear-gradient( center top, #005fbf 5%, #003f7f 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#005fbf", endColorstr="#003f7f");	background: -o-linear-gradient(top,#005fbf,003f7f);

	background-color:#005fbf;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}
.CSSTableGenerator tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #005fbf 5%, #003f7f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #005fbf), color-stop(1, #003f7f) );
	background:-moz-linear-gradient( center top, #005fbf 5%, #003f7f 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#005fbf", endColorstr="#003f7f");	background: -o-linear-gradient(top,#005fbf,003f7f);

	background-color:#005fbf;
}
.CSSTableGenerator tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.CSSTableGenerator tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}



#pagination-flickr li{
border:0; margin:0; padding:0;
font-size:11px;
list-style:none;
}
#pagination-flickr a{
border:solid 1px #DDDDDD;
margin-right:2px;
}
#pagination-flickr .previous-off,
#pagination-flickr .next-off {
color:#666666;
display:block;
float:left;
font-weight:bold;
padding:3px 4px;
}
#pagination-flickr .next a,
#pagination-flickr .previous a {
font-weight:bold;
border:solid 1px #FFFFFF;
}
#pagination-flickr .active{
color:#ff0084;
font-weight:bold;
display:block;
float:left;
padding:4px 6px;
}
#pagination-flickr a:link,
#pagination-flickr a:visited {
color:#0063e3;
display:block;
float:left;
padding:3px 6px;
text-decoration:none;
}
#pagination-flickr a:hover{
border:solid 1px #666666;
}
</style>				  
                  </div>
			 </div>
			
       