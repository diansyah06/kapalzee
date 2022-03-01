 <?php

$alamat="data/";
$id_ko=intval($_GET['id']);
$judul=$_POST['textfield'];
$no_gam=$_POST['textfield2'];
$no_gam1=$_POST['textfield3'];
$update_exist=$_POST['exist'];
$tipee=$_POST['select'];
$revisi=$_POST['select2'];
date_default_timezone_set('Asia/Bangkok');
$current_date = Date("Y-m-d\ H:i:s\ "); 
$tanggal_saiki = $current_date ;
$no_edrw=$_POST['no_edrawing'];


$alamat=$alamat . $id_ko  ;

if(!is_dir($alamat)){
	   mkdir($alamat, 0700);
 }

$random_digit=rand(0000,9999);
$namabaru = $random_digit. "_" .  $no_gam1 . "_" . $no_gam . _ . date("Y-m-d") . ".pdf" ;

$alamat = $alamat . "/" ; //generate the destination path

if ($no_edrw==0 ) {

if($_FILES['upload']['tmp_name']) {
    $upload = new Upload();
    $upload->SetFileName($namabaru);
    $upload->SetTempName($_FILES['upload']['tmp_name']);
    $upload->SetUploadDirectory("$alamat"); //Upload directory, this should be writable
    $upload->SetValidExtensions(array('pdf')); //Extensions that are allowed if none are set all extensions will be allowed.
    //$upload->SetEmail("Sidewinder@codecall.net"); //If this is set, an email will be sent each time a file is uploaded.
    //$upload->SetIsImage(true); //If this is set to be true, you can make use of the MaximumWidth and MaximumHeight functions.
    //$upload->SetMaximumWidth(60); // Maximum width of images
    //$upload->SetMaximumHeight(400); //Maximum height of images
    //$upload->SetMaximumFileSize(300000); //Maximum file size in bytes, if this is not set, the value in your php.ini file will be the maximum value
	if  ($update_exist==0){  
		$kon=$drawing->cek_double_drawing($no_gam);
		
		if ($kon==false){
			if ($upload->UploadFile()==true){
			$alamat=$alamat  . $namabaru ;
			$drawing->insert_data_gambar($id_ko,$judul, $tipee, $tanggal_saiki , $alamat,$no_gam);//insert data
			$thelast = $drawing->lastInsertId();
			$drawing->insert_data_sub_gambar($thelast, $id_ko, $tanggal_saiki, $revisi , $alamat); //insert 
			
			}else {
			echo "<script> alert('fail to upload drawing ')</script>";
			}
		} else {
		echo "<script> alert('fail, Seem Drawing already exist, Please dont make double input')</script>" ;
		}
	}else {
		if ($upload->UploadFile()==true){
		$alamat=$alamat  .$namabaru ;
		$id_ko=intval ($id_ko);
		
		$id_gambars=$drawing->get_id_from_no_gambar($no_gam1,$id_ko);
		foreach ($id_gambars as $id_gambar) {
			$id_gam=$id_gambar[id];
		}
		
		$drawing->insert_data_sub_gambar($id_gam, $id_ko, $tanggal_saiki, $revisi , $alamat); //insert
	
	
		}
	
	}
}

} else {

 // jika ga ada gambar
	if  ($update_exist==0){  
		$kon=$drawing->cek_double_drawing($no_gam);
		
		if ($kon==false){
			$alamat= "none" ;
			$drawing->insert_data_gambar($id_ko,$judul, $tipee, $tanggal_saiki , $alamat,$no_gam);//insert data
			$thelast = $drawing->lastInsertId();
			$drawing->insert_data_sub_gambar($thelast, $id_ko, $tanggal_saiki, $revisi , $alamat); //insert 
			
			
		} else {
		echo "<script> alert('fail, Seem Drawing already exist, Please dont make double input')</script>" ;
		}
	}else {
		
		$alamat= "none" ;
		$id_ko=intval ($id_ko);
		
		$id_gambars=$drawing->get_id_from_no_gambar($no_gam1,$id_ko);
		foreach ($id_gambars as $id_gambar) {
			$id_gam=$id_gambar[id];
		}
		
		$drawing->insert_data_sub_gambar($id_gam, $id_ko, $tanggal_saiki, $revisi , $alamat); //insert
	
	
		
	
	}

		
}

?> 
<script type="text/javascript">

        $(document).ready(function () {

			histor();

            $('.datatable').dataTable();
			

function suggestogs(inputString,code){
		if(inputString.length == 0) {
			$('#suggestions').fadeOut();
		} else {
		$('#country').addClass('load');
		var point= 1 ;
			$.post("kontrak/autosuggest_draw.php", {queryString: ""+inputString+"", code : code, point:point}, function(data){
				if(data.length >0) {
					$('#suggestions').fadeIn();
					$('#suggestionsList').html(data);
					$('#country').removeClass('load');
				}
			});
		}
	}

	function fillo(thisValue,nilai2,nilaii) {
	if (thisValue != 'undefined') {
		document.getElementById('textfield3').value=thisValue;
		document.getElementById('textfield').value=nilai2;
		fung_load_rev(nilaii);
		
		setTimeout("$('#suggestions').fadeOut();", 600);
	}else {
	document.getElementById('textfield3').value='';
		document.getElementById('textfield').value='';
		
		setTimeout("$('#suggestions').fadeOut();", 600);
		}
	
	}
	
	
	function fung_load_rev(code){
	
	var drawing_id = code;


	
	$.post("kontrak/load_revisi.php", { drawing_id: drawing_id } , function(html) {
			$('.rev').html(html);
			$(".rev").hide();
			$(".rev").fadeIn(400);});

}
 
 
 function histor() {


$("#button").toggle(function() {
        $(this).text('Hide History');
    }, function() {
        $(this).text('show history');
    }).click(function(){
        $("#hidden_content").slideToggle("slow");
    });
	

}
        });
</script>

<script src="js/kontrak-po.js" type="text/javascript"></script>


<script>

	
	

</script>

<div class="box round first">
                <h2>
                    Input Drawing For project</h2>
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

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table  class="form">
    <tr>
      <td><label>Existing drawing </label></td>
      <td><label>
        <input type="checkbox" id="checkbox"name="checkbox" value="checkbox" onchange="terms();" />
        Check if Exist
      </label></td>
    </tr>
    <tr>
      <td><label>Title</label></td>
      <td><label>
        <input type="text" id="textfield" name="textfield" class="medium" />
       
      </label></td>
    </tr>
    <tr>
      <td><label>Drawing Number</label> </td>
      <td><label>
        <input type="text" name="textfield2" id="textfield2" />
		 <input type="text" name="textfield3" id="textfield3"style="display:none" class="country" onkeyup="suggest(this.value,<?php echo intval($_GET[id]);?>);" onblur="fill();"  autocomplete="off"/>
		<div class="suggestionsBox" id="suggestions" style="display: none;"> 
        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
      </label></td>
    </tr>
    <tr>
      <td><label>Type</label></td>
      <td><label>
        <select name="select" required>
		<option> </option>
		<?php 
		$tipe_gambars=$drawing->get_tipe_gambar();
		foreach ($tipe_gambars as $tipe_gambar) {
		$x=$tipe_gambar['id'];
		$tipe_gam[$x]=$tipe_gambar['nama'];
		
		echo "<option value='". $tipe_gambar['id'] . "'>" . $tipe_gambar['nama'] . "</option>" ; $n++; }?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><label>Revisi</label></td>
      <td><label>
        <select name="select2" required>
		<option> </option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
          <option value="F">F</option>
          <option value="G">G</option>
          <option value="H">H</option>
          <option value="I">I</option>
          <option value="J">J</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><label>Not E-Drawing</label> </td>
      <td><label>
        <input type="checkbox" id= "checkbox2" name="checkbox2" value="checkbox" onclick="no_edraw();" />
        Check if not E-drawing</label></td>
    </tr>
    <tr>
      <td><label> File, PDF </label></td>
      <td><input type="file" name="upload" />
        <input id="exist" name="exist" type="hidden" value="0"  />
        <input id="no_edrawing" name="no_edrawing" type="hidden" value="0" /></td>
    </tr>
    <tr>
      <td><label></label></td>
      <td><div id="rev" class="rev" ></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="Submit" value="Submit" />
      </label></td>
    </tr>
  </table>
</form>
<label>
</label>

  </div>
</div>

					<div class="box round">
                      <form id="form2" name="form2" method="post" action="">
                        <label></label>
                      </form>
					
                <div id="deskripsi" class="deskripsi" >
				 <p >
<?php
	
	$proj_id=intval($_GET['id']);
	$get_draws=$drawing->get_proj_gambar($proj_id);
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Nama </th>
											<th>Tipe Gambar</th>
											<th>Masuk</th>
											<th>Open</th>
											<th>Delete</th>
																						
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($get_draws as $get_draw) {
	$z=$get_draw['tipe'];
	
	$perant=$get_draw[id_kontrak] . "," . $get_draw['id']  ;
	
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td > <a href='panel.php?module=ed_cek&point=1&id=". $proj_id. "&mod=2&draw=$get_draw[id] '>". $get_draw['no_gambar'] . " </a></td>
									<td >". $get_draw['judul'] . " </a></td>
									<td >".  $tipe_gam[$z]. "</td>
									<td>" . $get_draw['tanggal'] . "</td>
									<td>" . "<a href='kontrak/read.php?module=read&kon=$proj_id&gam=$get_draw[id]'" .  "target='_blank'>" . "Open</a> " ."</td>
									<td> <a href='#'  onclick=". "fung_del_gambar(" . $perant ."); > Delete </a> "  . "</td>									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table>";

	
			 
	?>						 
				 
				 
				    <script type="text/javascript">

      
	
	
	
    </script>
				 </div>
</div>			 

<!-- digae auto sugest !-->

<style>
#result {
	height:20px;
	font-size:16px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333;
	padding:5px;
	margin-bottom:10px;
	background-color:#FFFF99;
}
#country{
	padding:3px;
	border:1px #CCC solid;
	font-size:17px;
}
.suggestionsBox {
	position:relative;
	left: 0px;
	

	width: 170px;
	padding:0px;
	background-color: #999999;

}
.suggestionList {
	margin: 0px;
	padding: 0px;
}
.suggestionList ul li {
	list-style:none;
	margin: 0px;
	padding: 6px;
	border-bottom:1px dotted #666;
	cursor: pointer;
}
.suggestionList ul li:hover {
	background-color: #FC3;
	color:#000;
}


.load{
background-image:url(img/loader.gif);
background-position:right;
background-repeat:no-repeat;
}

#suggest {
	position:relative;
}

</style>
<style >
	#hidden_content{display:none;}
	</style>	

