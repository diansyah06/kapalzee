
<?php

$kont=$_POST['objek_array'];
$nama=$_POST['textfield3'];
if ((isset($kont)) and ($kont!="")  ){

$pieces = explode(",", $kont);
$pieces = array_unique($pieces);

       $kontrak->insert_linker($nama);
	   $last_id= $kontrak->lastInsertId();
	   foreach ($pieces as $piece) {

	   $kontrak->update_kontrak_linker( $last_id,$piece);
		}


}



?>
<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();
 setDatePicker('date-picker');

        });
</script>

<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/kontrak-po.js" type="text/javascript"></script>


<script>
function suggest(inputString,code){
		if(inputString.length == 0) {
			$('#suggestions').fadeOut();
		} else {
		$('#country').addClass('load');
			$.post("kontrak/sugest_linker.php", {queryString: ""+inputString+"", code : code}, function(data){
				if(data.length >0) {
					$('#suggestions').fadeIn();
					$('#suggestionsList').html(data);
					$('#country').removeClass('load');
				}
			});
		}
	}

	function fill(thisValue , nilai2 ,nilaii ) {
	if (typeof thisValue != 'undefined') {
  // ..

		//document.getElementById('textfield3').value=thisValue;
		
		append(thisValue,nilaii);
		$("#suggestions").fadeOut(400);
		
	}else {
	document.getElementById('textfield2').value='';
		
		
		setTimeout("$('#suggestions').fadeOut();", 600);
		}
	
	}
	
	
	 function append(thisValue,nilaii)
         {
            var cb = document.createElement( "input" );
            cb.type = "checkbox";
            cb.id = "id";
            cb.value = nilaii ;
			cb.className ="fancy-checkbox";
            cb.checked = true;
			cb.onclick = function (e)
		{
			test();
			 this.parentElement.removeChild(this);
			 text.parentNode.removeChild(text);
			return true;
		}
		

            var text = document.createTextNode( thisValue  );
			var newP = document.createElement("p");
			document.getElementById( 'append' ).appendChild( newP );
            document.getElementById( 'append' ).appendChild( text );
            document.getElementById( 'append' ).appendChild( cb );
			var datass = document.getElementById("objek_array").value;
			
			if (datass.length > 0 ) {
         	document.getElementById('objek_array').value=document.getElementById("objek_array").value + ',' + nilaii;
			}else {
			document.getElementById('objek_array').value=document.getElementById("objek_array").value + nilaii;
			}
		 }
	function value_cekbook()
		{
		
		// returns array of checked checkboxes with 'name' in 'form_id'
    var form = document.getElementById('append');
    var inputs = form.getElementsByTagName("input");
    var values = [];
    for (var i = 0; i < inputs.length; ++i) {
        if (inputs[i].type === "checkbox" && 
            inputs[i].name === name &&
            inputs[i].checked) 
        {
            values.push(inputs[i].value);
			
			
        }
    }
    return values;
		
		
		}

function test()
{
document.getElementById('objek_array').value='';
nilai=value_cekbook();
document.getElementById('objek_array').value=nilai;



}	









</script>

<div class="box round first">
                <h2>
                    Create Linker Project</h2>
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

<form id="form1" name="form1" method="post" action="panel.php?module=ed_kon&point=3&id=<?php echo $_GET[id] ; ?>">
  <table class="form">
    <tr>
      <td><label>Name</label></td>
      <td><label>
	  <input type="text" name="textfield3" />
      </label>  </td>
    </tr>
    <tr>
      <td><label>Project Name</label></td>
      <td><label><input type="text" name="textfield2" id="textfield2" class="country" onkeyup="suggest(this.value,<?php echo intval($_GET[id]);?>);" onblur="fill();"  autocomplete="off" />
		<div class="suggestionsBox" id="suggestions" style="display: none;">
      </label><div class="suggestionList" id="suggestionsList"> &nbsp; </div></label></td>
    </tr>
    <tr>
      <td><label></label></td>
      <td><div id="append" name="append"></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="Submit" value="Submit" />
      </label></td>
    </tr>
   <input name="objek_array"  id="objek_array" type="hidden"  />
     <td>&nbsp;</td>
    </tr>
  </table>
</form>

</div>
</div>



					<div class="box round">
                      <form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label>
                        <input name="radiobutton" type="radio" value="radiobutton" onclick="fung_load_planb();" />
                        Arsip Plan</label>
                                            <label>
                                            <input name="radiobutton" type="radio" value="radiobutton" checked="checked"  onclick="window.location.reload();"/>
                                            Current Plan</label>
                      </form>
					
                <div id="deskripsi" class="deskripsi" >
				 <p >
				 
	<?php
	
	$kontraks=$kontrak->get_kontrak();
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Id Kontrak</th>
											<th>Nama </th>
											<th>Location</th>
											<th>Status</th>
											<th>Start Date</th>
											<th>Due Date</th>
											<th>Finish</th>
											<th>Link</th>
											
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($kontraks as $kontrak) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td ><a href='panel.php?module=ed_kon&point=2&id=". $kontrak['id']. "'>". $kontrak['id_kontrak'].  " </a></td>
									<td >". $kontrak['nama']. "</td>
									<td>" . $kontrak['lokasi'] . "</td>
									<td>" . $kontrak['status'] ."</td>
									<td>". $kontrak['dates'] ."</td>
									<td>". $kontrak['due_date']. "</td>
									<td>". $kontrak['finish']. "</td>
									<td>" . $kontrak['linker'] . "</td>
									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table><hr>";
	
	
			 
	?>			 
	
				</div>
</div>			

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