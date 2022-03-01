function fung_changeprofile(){
	
	var name_element = document.getElementById('sapii') ;
	var jabatan  = name_element.value;
	var name_element =  document.getElementById('textfield3')  ;
	var alamat  = name_element.value;
	var name_element =  document.getElementById('textfield4') ;
	var email  = name_element.value;
	var name_element = document.getElementById('textfield5') ;
	var ym  = name_element.value;
	var name_element = document.getElementById('textfield6') ;
	var fb  = name_element.value;
	var name_element = document.getElementById('textfield7') ;
	var handphone  = name_element.value;
	var name_element = document.getElementById('textfield8') ;
	var tujuan  = name_element.value;
	var name_element = document.getElementById('select3') ;
	var edukasi  = name_element.value;
	var pekerjaan  = tinyMCE.get('textarea').getContent();
	
	
	var name_element = document.getElementById('textfield') ;
	var dpn  = name_element.value;
	
	var name_element = document.getElementById('textfield11') ;
	var blkng  = name_element.value;


	var code = code ;
	var modul= "profil";
	var act = "add";
	
	$.post("people/people_proc.php", { act: act , modul: modul, code:code , jabatan:jabatan, alamat:alamat , email:email , ym:ym , fb:fb , handphone:handphone ,tujuan :tujuan , edukasi:edukasi , pekerjaan:pekerjaan ,dpn:dpn , blkng:blkng } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_add_edukasi(tipe){
	
	if (tipe == 1) {
			var name_element =  document.getElementById('textfield9')  ;
			var edukasi  = name_element.value;
			var name_element =  document.getElementById('select')  ;
			var awal  = name_element.value;
			var name_element =  document.getElementById('select2')  ;
			var akhir  = name_element.value;
			document.getElementById('textfield9').value='';
	} else if  (tipe == 2){
			var name_element =  document.getElementById('textfield92')  ;
			var edukasi  = name_element.value;
			var name_element =  document.getElementById('select4')  ;
			var awal  = name_element.value;
			var name_element =  document.getElementById('select4i')  ;
			var akhir  = name_element.value;
			document.getElementById('textfield92').value='';
	} else if (tipe == 3){
			var name_element =  document.getElementById('textfield93')  ;
			var edukasi  = name_element.value; 
			var name_element =  document.getElementById('select5')  ;
			var awal  = name_element.value;
			var name_element =  document.getElementById('select5i')  ;
			var akhir  = name_element.value;
			document.getElementById('textfield93').value='';
	
	} else if (tipe == 4){
			var name_element =  document.getElementById('textfield10')  ;
			var edukasi  = name_element.value; 
			var name_element =  document.getElementById('select5')  ;
			var awal  = name_element.value;
			var name_element =  document.getElementById('select5i')  ;
			var akhir  = name_element.value;
			document.getElementById('textfield10').value='';
	}
	
	

	
		var tipe =tipe ;
	 



	var modul= "profil";
	var act = "add_edukasi";
	
	$.post("people/people_proc.php", { act: act , modul: modul, edukasi:edukasi , awal:awal , akhir:akhir , tipe:tipe  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_dell_edu(id){
	var modul= "del_edu";
	var act = "del";
	
	$.post("people/people_proc.php", { act: act , modul: modul, id:id  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

	
}



function fung_add_wisdom(){
	

var name_element =  document.getElementById('Description')  ;
var isi  = name_element.value;

document.getElementById('Description').value='';


	var modul= "wisdom";
	var act = "add";
	
	$.post("people/people_proc.php", { act: act , modul: modul, isi:isi  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_add_email_integarasi(){
	
	var name_element =  document.getElementById('textfield12')  ;
	var username  = name_element.value;
	var name_element =  document.getElementById('textfield13')  ;
	var passwords  = name_element.value;
	
	
	var modul= "profil";
	var act = "add_email_integrasi";
	
	$.post("people/people_proc.php", { act: act , modul: modul, username:username , passwords:passwords } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_dell_email_integarasi(){
	
	
	var modul= "profil";
	var act = "dell_email_integrasi";
	
	$.post("people/people_proc.php", { act: act , modul: modul } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_add_OGS_integarasi(){
	
	var name_element =  document.getElementById('textfield14')  ;
	var username  = name_element.value;
	var name_element =  document.getElementById('textfield15')  ;
	var passwords  = name_element.value;
	
	
	var modul= "profil";
	var act = "add_ogs_integrasi";
	
	$.post("people/people_proc.php", { act: act , modul: modul, username:username , passwords:passwords } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_dell_OGS_integarasi(){
	
	
	var modul= "profil";
	var act = "dell_ogs_integrasi";
	
	$.post("people/people_proc.php", { act: act , modul: modul } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}