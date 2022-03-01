function fung_computer(idcomputer,act,name,mac,ip){


	var modul= "comreg";
	
	
	$.post("dcm_process.php", { act: act , modul: modul, name:name,mac:mac , ip:ip ,idcomputer:idcomputer } , function(html) {
			$('.listcomputer').html(html);
			$(".listcomputer").hide();
			$(".listcomputer").fadeIn(400);});

}


function addComputer(){

var namess=document.getElementById('namcomputer').value;
var mac= document.getElementById('mac').value;
var ip= document.getElementById('IP').value;


	var act = "add";
	var idcomputer=0 ;
	
	fung_computer(idcomputer,act,namess,mac,ip);
	
}

function refreshSession(){
	var modul= "getActiveSession";
	
	$.post("dcm_process.php", {  modul: modul} , function(html) {
			$('.dccfresh').html(html);
			$(".dccfresh").hide();
			$(".dccfresh").fadeIn(400);});
}
