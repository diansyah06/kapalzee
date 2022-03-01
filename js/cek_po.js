function fung_add(code){
	var name_element = document.getElementById('nama');
	var id_user = name_element.value;
	var code = code ;
	var name_element = document.getElementById('date-picker');
	var tanggal = name_element.value;
	var tanggal = name_element.value;
	var modul= "team";
	var act = "add";
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, id_pegawai:id_user , code:code , tanggal:tanggal } , function(html) {
			$('.team').html(html);
			$(".team").hide();
			$(".team").fadeIn(400);});

}

function fung_add_sekert(code){
	var name_element = document.getElementById('nama2');
	var id_user = name_element.value;
	var code = code ;
	var name_element = document.getElementById('date-picker');
	var tanggal = name_element.value;
	var modul= "team_sekert";
	var act = "add";
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, id_pegawai:id_user , code:code , tanggal:tanggal } , function(html) {
			$('.team').html(html);
			$(".team").hide();
			$(".team").fadeIn(400);});

}

function fung_del(user){
	var id_team= user ;
	var modul= "team";
	var act = "del";
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, id_team : id_team} , function(html) {
			$('.asdasd').html(html);});

}


function fung_add_log_rules(code,pointke){

	var name_element = document.getElementById('section');
	var section = name_element.value;
	var name_element = document.getElementById('sub_sec');
	var sub_sec = name_element.value;
	var name_element = document.getElementById('origin');
	var origin = name_element.value;
		var name_element = document.getElementById('changes');
	var changes = name_element.value;
		var name_element = document.getElementById('objek');
	var objek = name_element.value;
		var name_element = document.getElementById('argumen');
	var argumen = name_element.value;
	
	
	
	var code = code ;
	var modul= "log_rules";
	var act = "add";
	var pointke = pointke;
	var name_element = document.getElementById('date-picker2');
	var tang_cek = name_element.value;
	
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul , code: code , pointke: pointke , tang_cek:tang_cek, section:section, sub_sec:sub_sec, origin:origin, changes:changes, objek:objek, argumen:argumen } , function(html) {
			$('.deskripsilog').html(html);
			$(".deskripsilog").hide();
			$(".deskripsilog").fadeIn(400);});
	

	document.getElementById('section').value=''
	document.getElementById('sub_sec').value=''
	document.getElementById('origin').value=''
	document.getElementById('changes').value=''
	document.getElementById('objek').value=''
	document.getElementById('argumen').value=''
	
	
	
}

function fung_del_log_rules(code,pointke,id_logs){

	
	var id_log = id_logs;
	
	
	
	var code = code ;
	var modul= "log_rules";
	var act = "dell";
	var pointke = pointke;

	
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul , code: code , pointke: pointke , id_log:id_log } , function(html) {
			$('.deskripsilog').html(html);
			$(".deskripsilog").hide();
			$(".deskripsilog").fadeIn(400);});
	

}


function fung_add_desk(code,pointke){
	var name_element = document.getElementById('Description');
	var deskripsi = name_element.value;
	var code = code ;
	var modul= "descr_team";
	var act = "add";
	var pointke = pointke;
	var name_element = document.getElementById('date-picker2');
	var tang_cek = name_element.value;
	
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, deskripsi:deskripsi , code:code , pointke:pointke , tang_cek:tang_cek } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});
	 document.getElementById('Description').value='';

}

function fung_del_desk(id,code,pointke){
	var name_element = document.getElementById('Description');
	var deskripsi = name_element.value;
	var code = code;
	var modul= "descr_team";
	var act = "del";
	var pointke = pointke ;
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, id:id , code:code , pointke:pointke } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}
/*End cek point 2*/
/*cek point 3 other*/

function fung_add_ref_other(code,pointke){
	var name_element = document.getElementById('Description');
	var deskripsi = tinyMCE.get('Description').getContent();
	var code = code ;
	var modul= "descr_kind";
	var act = "add";
	var pointke = pointke;
	var name_element = document.getElementById('date-picker');
	var tang_cek = name_element.value;
	
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, deskripsi:deskripsi , code:code , pointke:pointke , tang_cek:tang_cek } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});
	
	 tinyMCE.get('Description').setContent('');

}

function fung_del_ref_other(code,pointke){
	var name_element = document.getElementById('Description');
	var deskripsi = name_element.value;
	var code = code;
	var modul= "descr_kind";
	var act = "del";
	var pointke = pointke ;
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul,  code:code , pointke:pointke } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}

/*end cek point 3 other*/
/*cek in lock */

function fung_lock(code,pointke){
	
	var code = code ;
	var modul= "lock";
	var act = "clik";
	var pointke = pointke;
	var name_element = document.getElementById('myonoffswitch');
	if  (name_element.checked == true)
	{ var nilai = 0; }
	else
	{var nilai = 1 ;}
	

	
	
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, code:code , pointke:pointke , nilai:nilai  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

/*dell file administrasi */

function fung_del_adminis(code,pointke,alamat){
	
	var code = code ;
	var modul= "adminis";
	var act = "del";
	var pointke = pointke;
	var alamat = alamat ;
	
	$.post("rules/ajax_proc.php", {  act: act , modul: modul, code:code , pointke:pointke ,alamat:alamat } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_del_publish(id,code,pointke,alamat){
	
	var code = code ;
	var modul= "uploadpublis";
	var act = "del";
	var pointke = pointke;
	var alamat = alamat ;
	
	$.post("rules/ajax_proc.php", { id:id , act: act , modul: modul, code:code , pointke:pointke ,alamat:alamat } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

/*dell file publikasi */

/*del master */

function fung_del_master(id,code){
	
	var code = code ;
	var modul= "delmaster";
	var act = "del";

	
	$.post("rules/ajax_proc.php", { id:id , act: act , modul: modul, code:code  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

/* Add rules karakteristik */

function fung_add_char(code){
	
	var code = code ;
	var gol = 1 ;
	var modul= "addchar";
	var act = "add";
	var name_element = document.getElementById('idrules');
	var id = name_element.value;
	var nama = name_element.options[name_element.selectedIndex].text;
	var name_element = document.getElementById('tahun');
	var tahun = name_element.value;
	var name_element = document.getElementById('Description');
	var deskripsi = name_element.value;
	document.getElementById('Description').value='';
	
	$.post("rules/ajax_proc.php", { id:id , tahun:tahun , deskripsi:deskripsi ,  act: act , modul: modul, code:code , gol:gol , nama:nama } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_add_char2(code){
	
	var code = code ;
	var gol = 2 ;
	var modul= "addchar";
	var act = "add";
	var name_element = document.getElementById('literatur');
	var id = name_element.value;
	var nama = name_element.options[name_element.selectedIndex].text;
	var name_element = document.getElementById('tahun2');
	var tahun = name_element.value;
	var name_element = document.getElementById('Description2');
	var deskripsi = name_element.value;
	document.getElementById('Description2').value='';
	document.getElementById('literatur').value='';
	
	$.post("rules/ajax_proc.php", { id:id , tahun:tahun , deskripsi:deskripsi ,  act: act , modul: modul, code:code , gol:gol , nama:nama } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_del_char(id,code){
	
	var code = code ;
	var modul= "addchar";
	var act = "del";
	var id = id;

	
	$.post("rules/ajax_proc.php", { id:id ,  act: act , modul: modul, code:code  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}


/*fungsi add Kamus */

function fung_add_kamus(){
	

	var modul= "kamus";
	var act = "add";
	var name_element = document.getElementById('indonesia');
	var indonesia = name_element.value;
	var name_element = document.getElementById('english');
	var english = name_element.value;


	
	$.post("rules_sup/sup_proc.php", { act: act , modul: modul, indonesia:indonesia , english:english  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_del_kamus(id){
	

	var modul= "kamus";
	var act = "del";
	var id  =id ;
	

	
	$.post("rules_sup/sup_proc.php", { act: act , modul: modul , id:id } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}


function fung_add_scope(code){
	

	var modul= "addscope";
	var act = "add";
	var code =code ;
	
	var name_element = document.getElementById('date-picker');
	var intoforce = name_element.value;
	
	var name_element = document.getElementById('panjang');
	var panjang = name_element.value;
	
	var name_element = document.getElementById('hp');
	var hp = name_element.value;
	
	var name_element = document.getElementById('kva');
	var kva = name_element.value;
	
	var name_element = document.getElementById('dwt');
	var dwt = name_element.value;
	
	var name_element = document.getElementById('bahan');
	var bahan = name_element.value;
	
	var name_element = document.getElementById('tipe');
	var tipe = name_element.value;
	
	var name_element = document.getElementById('operasi');
	var operasi = name_element.value;
	
	var name_element = document.getElementById('cargo');
	var cargo = name_element.value;
	
	var name_element = document.getElementById('purpose');
	var purpose = name_element.value;
	
	var name_element = document.getElementById('special');
	var Special = name_element.value;
		var name_element = document.getElementById('Description');
    var describ = tinyMCE.get('Description').getContent();
	
	
	
	
	
	
	$.post("rules/ajax_proc.php", {  act:act , modul:modul, intoforce:intoforce, panjang:panjang, hp:hp, kva:kva, dwt:dwt, bahan:bahan, tipe:tipe, operasi:operasi, cargo:cargo, purpose:purpose, Special:Special, 	describ:describ, code:code   } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});


}

function fung_add_rekomen(code){
	

	var modul= "recomed";
	var act = "add";
	var name_element = document.getElementById('select');
	var rules_pub = name_element.value;
	
	var name_element = document.getElementById('textarea');
	var recomend = name_element.value;
	var code =code ;
	
		document.getElementById('textarea').value=''


	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, rules_pub:rules_pub , recomend:recomend ,code:code } , function(html) {
			$('.rekomendasi').html(html);
			$(".rekomendasi").hide();
			$(".rekomendasi").fadeIn(400);});


}

function fung_dell_rekomen(id,code){
	

	var modul= "recomed";
	var act = "dell";



	
	$.post("rules/ajax_proc.php", { act: act , modul: modul ,id:id ,code:code} , function(html) {
			$('.rekomendasi').html(html);
			$(".rekomendasi").hide();
			$(".rekomendasi").fadeIn(400);});


}


function fung_add_minute_of_meeting(code){

	var name_element = document.getElementById('agenda');
	var agenda = name_element.value;
	
	var name_element = document.getElementById('place');
	var place = name_element.value;
	
	var name_element = document.getElementById('waktu');
	var waktu = name_element.value;
	var name_element = document.getElementById('demo-input-local');
	var kehadiran = name_element.value;
    var name_element = document.getElementById('date-picker2');
	var tanggal = name_element.value;
	
	var code = code ;

	var modul= "minutes";
	var act = "add";
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, agenda:agenda , code:code , tanggal:tanggal, place:place, waktu:waktu , kehadiran:kehadiran} , function(html) {
			$('.minutes').html(html);
			$(".minutes").hide();
			$(".minutes").fadeIn(400);});
			
			
	document.getElementById('agenda').value=''
document.getElementById('place').value=''
document.getElementById('waktu').value=''
document.getElementById('demo-input-local').value=''


}

function fung_dell_minutre(id,code){
	
var code = code ;
	var modul= "minutes";
	var act = "dell";
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul ,id:id ,code:code} , function(html) {
			$('.minutes').html(html);
			$(".minutes").hide();
			$(".minutes").fadeIn(400);});


}

function fung_add_log_rules2(code,pointke,id){

	var name_element = document.getElementById('section');
	var section = name_element.value;
	var name_element = document.getElementById('sub_sec');
	var sub_sec = name_element.value;
	var name_element = document.getElementById('origin');
	var origin = name_element.value;
		var name_element = document.getElementById('changes');
	var changes = name_element.value;
		var name_element = document.getElementById('objek');
	var objek = name_element.value;
		var name_element = document.getElementById('argumen');
	var argumen = name_element.value;
	
	
	
	var code = code ;
	var modul= "log_rules";
	var act = "add";
	var pointke = pointke;
	var name_element = document.getElementById('date-picker2');
	var tang_cek = name_element.value;
	
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul , code: code , pointke: pointke , tang_cek:tang_cek, section:section, sub_sec:sub_sec, origin:origin, changes:changes, objek:objek, argumen:argumen , id:id } , function(html) {
			$('.deskripsilog').html(html);
			$(".deskripsilog").hide();
			$(".deskripsilog").fadeIn(400);});
	

	document.getElementById('section').value=''
	document.getElementById('sub_sec').value=''
	document.getElementById('origin').value=''
	document.getElementById('changes').value=''
	document.getElementById('objek').value=''
	document.getElementById('argumen').value=''
	
	
	
}

function fung_del_log_rules2(code,pointke,id_logs,id_mom){

	
	var id_log = id_logs;
	
	
	
	var code = code ;
	var modul= "log_rules";
	var act = "dell";
	var pointke = pointke;

	
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul , code: code , pointke: pointke , id_log:id_log , id_mom:id_mom} , function(html) {
			$('.deskripsilog').html(html);
			$(".deskripsilog").hide();
			$(".deskripsilog").fadeIn(400);});
	

}

function fung_update_minute_of_meeting(id_mom){

	var name_element = document.getElementById('rapat');
	var hasil_rapat = tinyMCE.get('rapat').getContent();
	
	
	
	
	var modul= "minutes_update_rapat";
	var act = "update_rapat";
	
	$.post("rules/ajax_proc.php", { act: act , modul: modul, hasil_rapat:hasil_rapat , id_mom:id_mom} , function(html) {
			$('.rapat').html(html);
			$(".rapat").hide();
			$(".rapat").fadeIn(400);});


}

