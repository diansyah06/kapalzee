function fung_add_kontrak(){
	var name_element = document.getElementById('kontrak');
	var id_kontrak = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('class');
	var class_id = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('name');
	var name = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('tipe');
	var tipe = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('lokasi');
	var location = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('pembuat');
	var builder = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('pengirim');
	var submited = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('date-picker');
	var due_date = name_element.value;
	name_element.value='';
	

	var modul= "kontrak";
	var act = "add";
	
	$.post("kontrak/proc-kontr.php", { act: act , modul: modul, id_kontrak:id_kontrak , class_id:class_id , name:name, tipe:tipe , location:location, builder:builder, submited:submited, due_date:due_date} , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}

function fung_edit_kontrak(id_kon){
	var id_kon=id_kon;
	var name_element = document.getElementById('kontrak');
	var id_kontrak = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('class');
	var class_id = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('name');
	var name = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('tipe');
	var tipe = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('lokasi');
	var location = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('pembuat');
	var builder = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('pengirim');
	var submited = name_element.value;
	name_element.value='';
	
	var name_element = document.getElementById('date-picker');
	var due_date = name_element.value;
	name_element.value='';
	

	var modul= "kontrak";
	var act = "edit";
	
	$.post("kontrak/proc-kontr.php", { act: act , modul: modul, id_kontrak:id_kontrak , class_id:class_id , name:name, tipe:tipe , location:location, builder:builder, submited:submited, due_date:due_date, id_kon:id_kon} , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}





function terms() {
       var checked = document.getElementById('checkbox').checked;
       if (checked==false)
        {
         document.getElementById('exist').value='0';
		 
		 document.getElementById('textfield').disabled=false;
		 document.getElementById('textfield3').style.display = 'none'
		 document.getElementById('textfield2').style.display = 'block'
		 
        }
       else
        {
		document.getElementById('exist').value='1';
		document.getElementById('textfield').disabled=true;
		document.getElementById('textfield3').style.display = 'block'
		document.getElementById('textfield2').style.display = 'none'
        }
    }
	
	function no_edraw() {
       var checked = document.getElementById('checkbox2').checked;
       if (checked==false)
        {
         document.getElementById('no_edrawing').value='0';
		 
        }
       else
        {
        document.getElementById('no_edrawing').value='1';

        }
    }
	
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

$("#historri").click(function(){
        $("#hidden_content").slideToggle("slow");
    });
	

}	