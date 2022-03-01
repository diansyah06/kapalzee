<?php

if (isset($_POST['textfield'])and ($_POST['textfield']!= "" ) ){

//get var from post

$judul = $_POST['textfield'] ;
$tipe = $_POST['tipe'] ;
$tahun = $_POST['tahun'] ;
$desk = $_POST['textarea'] ;


if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_otherrules (tipe, nama, tahun, desk ) VALUES (?, ?, ?, ?)")) {    
		   $insert_stmt->bind_param('ssis',$tipe, $judul , $tahun , $desk   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}



} else {}



?>
<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>
<script type="text/javascript" src="js/table/table.js"></script>
<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="css/themes/base/custom.css" rel="stylesheet" type="text/css" />
<div class="box round first">
                <h2>
                    Description</h2>
                <div class="block">
                    <!-- paragraphs -->
                    <p class="start">
                        <img src="img/horizontal.jpg" alt="Ginger" class="right" />This is the page which contain the list of another convention/ international standard which related with BKI Regulation. The other references listed here will automatically displayed into the Page 7 of your project [Characteristick of Technical Paper],which you need to select the reference related into your project. </p>
                    <p>Some times you cannot find the references related into your project in that list. If it so, please fill in the entry of [Create New List other reference]. The title shall written in &quot;Nama&quot; box, while &quot;type&quot; box provide 3 choices such as Rules, Convention and International Standard. &quot;Description&quot; box is where do you put the description and overview of the new reference. </p>
                    <p>If there's any misplaced/funny names go ask defri. I don't really care about this</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
  </div>
</div>

            <div class="box round">
                <h2>
                    Create New List Other reference </h2>
                <div class="block">
                    <p class="start">
<form  method="post" enctype="multipart/form-data" name="form1" action="panel.php?module=cliterature">					

<table class="form">
  <tr>
    <td ><label>Nama</label></td>
    <td ><label>
      <input type="text" name="textfield"  class="medium" />
    </label></td>
  </tr>
  <tr>
    <td><label>Type</label></td>
    <td><label>
      <select name="tipe">
        <option>Rules</option>
        <option>International Standart</option>
        <option>Convention</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <td><label>Tahun</label></td>
    <td><label>
      <select name="tahun">
	  <?php
		for ($i = 1980; $i <= 2015; $i++) {
			echo    "<option>" . $i . "</option>" ;
		}

	  ?>

      </select>
    </label></td>
  </tr>
  <tr>
    <td><label>Description</label></td>
    <td><label>
      <textarea id="textarea" name="textarea" rows="5" cols="43"></textarea>
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="Submit" value="Submit"  onClick="formSubmit()"/>
    </label></td>
  </tr>
</table>
</form>
</p>
</div>
</div>
	 <div class="box round">
                <h2>
          			List Technical Paper </h2>
                <div class="block">
                   <?php 



$saringr= "%" . $_POST['search_query'] ."%" ;
$saring= $_POST['saring'] ;




if ( $saring != 0 ) { $dimana= "where nama like ? and  Tipe = ? " ;} else { $dimana= "where nama like ?"  ;}

//Load list rule.........
	if ($load_rulest = $mysqli->prepare("SELECT id, tipe, nama , tahun , desk  FROM rm_otherrules " .$dimana)) {   
	   // Execute the prepared query.
		  
		   if ( $saring != 0 ) { 
			 	  $load_rulest->bind_param('ss',$saringr, $saring); // Bind "$id_rules" to parameter.
			   }else {  $load_rulest->bind_param('s', $saringr);  }// Bila semua di tampilkan
			   
		   $load_rulest->execute();
		   $load_rulest->bind_result($id_rules,$tipe,$Rules,$part,$volume );
		   
		    echo "<table class='data display datatable' id='example'>
					<thead>
						<tr>
							<th>Unix ID</th>
							<th>Nama Technical Paper</th>
							<th>Tipe</th>
							<th>Tahun</th>
							<th>Desk</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>";

		  	while($load_rulest->fetch()){

/*if lenstr($volume>15 ) {$volume=}*/					 /*jika deskripsi panjang persingkat*/
				echo "<tr class='odd gradeX'>
					<td>$id_rules</td>
					<td>$Rules</td>
					<td>$tipe</td>
					<td>$part</td>
					<td>$volume</td>
					<td> | <a href=./rules_sup/dell_oth_lite.php?id=$id_rules>Hapus</a></td></tr>";
			}
	    	echo "</tbody></table>" ;

		   		
	}
//End Load Part.........

?>

					</div>
					</div>
			