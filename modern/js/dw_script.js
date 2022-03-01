function userAdddcc(divname){

var nup = document.getElementById("nup").value;
var nama =document.getElementById("usrname").value;
var modul ="adddccUser" ;
var divisi =document.getElementById("divisi").value;

var act = "add";
	$.post("dw_proc.php", {nup:nup, act: act , modul: modul, nama:nama,divisi:divisi} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});

}


function kontrakadd(divname){

var register = document.getElementById("reg").value;
var nokontrak =document.getElementById("nokontrak").value;
var modul ="dckontrak" ;
var projecName =document.getElementById("projectname").value;
var datecontrak =document.getElementById("datecontrak").value;
var act = "add";
	$.post("dw_proc.php", {register:register, act: act , modul: modul, datecontrak:datecontrak,nokontrak:nokontrak,projecName:projecName} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});

}

function registeradd(){

var register = document.getElementById("regi").value;
var namaKapal =document.getElementById("nmkplreg").value;

var LPP =document.getElementById("LPP").value;
var GT =document.getElementById("GT").value;
var thnbangun =document.getElementById("ThBngn").value;
var T =document.getElementById("T").value;

var modul ="register" ;
var act = "add";
	$.post("dw_proc.php", {register:register, act: act , modul: modul, namaKapal:namaKapal,LPP:LPP,GT:GT,thnbangun:thnbangun,T:T} , function(html) {
			$('.register').html(html);
			$('.register').hide();
			$('.register' ).fadeIn(400);});

}
function kontrakgambaradd(){

var nokontrak=document.getElementById("nokontrak").value;
var typedraw=document.getElementById("typedraw").value;
var namdraw=document.getElementById("namdraw").value;

var modul ="kontrakgambar" ;
var act = "add";
	$.post("dw_proc.php", {nokontrak:nokontrak, act: act , modul: modul, typedraw:typedraw,namdraw:namdraw} , function(html) {
			$('.training').html(html);
			$('.training').hide();
			$('.training' ).fadeIn(400);});

}

function posttable(nokontrak){

var act = "refresh";
var modul ="kontrakgambar" ;
	$.post("dw_proc.php", {nokontrak:nokontrak, act: act , modul: modul} , function(html) {
			$('.training').html(html);
			$('.training').hide();
			$('.training' ).fadeIn(400);});
}