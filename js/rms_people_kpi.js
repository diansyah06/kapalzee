function load_data (bulan,tahun) {


	var modul= "diary";
	var act = "show";
	
	$.post("people/people_proc.php", { act: act , modul: modul, bulan:bulan , tahun:tahun  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function load_datass (bulan,tahun,user) {


	var modul= "diary";
	var act = "show";
	
	$.post("people/people_proc.php", { act: act , modul: modul, bulan:bulan , tahun:tahun ,user:user } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}


function delt (id_diary) {



	var modul= "diary";
	var act = "delete";
	
	$.post("people/people_proc.php", { act: act , modul: modul, id_diary:id_diary  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function close_pro () {

	var name_element = document.getElementById('date-picker3');
	var tanggal = name_element.value;
	
	var name_element = document.getElementById('id_diar');
	var id_diary = name_element.value;
	
	var modul= "diary";
	var act = "close";
	
	$.post("people/people_proc.php", { act: act , modul: modul, tanggal:tanggal, id_diary:id_diary   } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function show_update(id_coment){

	document.getElementById('id_diar').value='';
		popup();
document.getElementById('id_diar').value=id_coment;
		
}


function popup() {

		$( "#dialog" ).dialog({

				autoOpen: true,
				height: 180,
				width: 350,
				show: "blind",
				hide: "fadeout"

		});
	}


