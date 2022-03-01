function load_managing_arsip(){
	
	
var modul= "load_managing_arsip";
	
$.post("rules/show_man_monitor_rule.php", { modul: modul } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	



}

function load_managing_waiting(){
	
	
	
	var modul= "load_managing_waiting";	
$.post("rules/show_man_monitor_rule.php", {  modul: modul } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	



}


function load_managing_close(id_cek){
	
var id_cek=id_cek;	


	var modul= "load_managing_close";	
$.post("rules/show_man_monitor_rule.php", {  modul: modul , id_cek:id_cek } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	

}

function load_managing_reopen(id_cek){
	
var id_cek=id_cek;	


	var modul= "load_managing_reopen";	
$.post("rules/show_man_monitor_rule.php", {  modul: modul , id_cek:id_cek } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	

}