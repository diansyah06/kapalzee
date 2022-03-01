function load_managing_arsip(){
	
	
var modul= "load_managing_arsip";
	
$.post("rules/proc_sipat.php", { modul: modul } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	



}

function load_managing_waiting(){
	
	
	
	var modul= "load_managing_waiting";	
$.post("rules/proc_sipat.php", {  modul: modul } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	



}


function load_managing_close(id_cek){
	
var id_cek=id_cek;	


	var modul= "load_managing_close_kelengkapan";	
$.post("rules/proc_sipat.php", {  modul: modul , id_cek:id_cek } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	

}

function load_managing_reopen(id_cek){
	
var id_cek=id_cek;	


	var modul= "load_managing_reopen_kelengkapan";	
$.post("rules/proc_sipat.php", {  modul: modul , id_cek:id_cek } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	

}