function getRequest(nameClass,modul,page,strurl){
	
	$.get("php2/" + page + ".php" + strurl, {modul:modul} , function(html) {
			$('.' + nameClass ).html(html);
			$("." + nameClass).hide();
			$("." + nameClass).fadeIn(400);});
	
}
function PosttRequest(nameClass,modul,page,stringCommand){
	
	$.post( page + ".php", {modul:modul,stringCommand:stringCommand} , function(html) {
			$('.' + nameClass ).html(html);
			$("." + nameClass).hide();
			$("." + nameClass).fadeIn(400);});
	
}
function FuncAjaxRequestt(page , nameClass,modul,stringCommand,richtext1,richtext2){
	
	$.post(page, {modul:modul, stringCommand:stringCommand,richtext1:richtext1,richtext2:richtext2} , function(html) {
			$('.' + nameClass ).html(html);
			$("." + nameClass).hide();
			$("." + nameClass).fadeIn(400);});
	
}
function getInputpage(code){
	var    strurl = "?idproj=" + code ;
	getRequest("isicommneting"," ","input_comment",strurl);	
	
}
function getInsertdrawing(code){
	var act='refresh';
	var strurl = act + "#" + code + "#" ;
		//getRequest("isiinputdrawing"," ","insertDrawing",strurl);	
		PosttRequest("isiinputdrawing","drawing","process-ogs",strurl);	
}

function refreshmoderation(id){
	var act='refresh';
	var strpost= act + "#" + id + "#" ;
	PosttRequest("moderation","moderation","process-ogs",strpost);
	
	setTimeout(function(){ refreshlistmoderationrequestdownload(id); }, 1000);
}

function refreshcommentlist(id){
	var act='refresh';
	var strpost= act + "#" + id + "#" ;
	PosttRequest("isicommneting","commenting","process-ogs",strpost);
}

function updatePosuser(pos,user,idpro){
var act='change';
var strpost= act + "#" + pos + "#"  + user + "#"  + idpro;	
PosttRequest("teamlist","team","process-ogs",strpost);	
}
function Delmembersuser(user,idpro){
var act='dell';
var strpost= act  + "#"  + user + "#"  + idpro;	
if (confirm('Are you sure you want to dell ?')) {		
PosttRequest("teamlist","team","process-ogs",strpost);	
}
}
function Addmembersuser(idpro){
var act='add';
var user = document.getElementById('teamtabulasi').value;

var strpost= act  + "#"  + user + "#"  + idpro;	
PosttRequest("teamlist","team","process-ogs",strpost);	
}

//special buat commenting
function suggestgambarcomment(inputString,code,point){
		if(inputString.length == 0) {
			$('#suggestionsListcomment').fadeOut();
		} else {
		$('#countryy').addClass('load');
		var name_element = document.getElementById('select');
		var tipe =name_element.value;
			$.post("kontrak/autosuggest_draw.php", {queryString: ""+inputString+"", code : code, point:point, tipe:tipe}, function(data){
				if(data.length >0) {
					$('#suggestionsListcomment').fadeIn();
					$('#suggestionsListcomment').html(data);
					$('#countryy').removeClass('load');
				}
			});
		}
	}

	function fillop(thisValue , nilai2 ,nilaii ) {
	if (typeof thisValue != 'undefined') {
  // ..

		//document.getElementById('textfield3').value=thisValue;
		
		appendcommentdrawa(thisValue,nilaii);
		$("#suggestionsListcomment").fadeOut(400);
		
	}else {
	document.getElementById('textfield3').value='';
		
		
		setTimeout("$('#suggestionsListcomment').fadeOut();", 600);
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

function testingvalue()
{
document.getElementById('objek_array').value='';
nilai=value_cekbook();
document.getElementById('objek_array').value=nilai;



}	


function reset_change_tipe(){

var nilai_obj = document.getElementById("objek_array").value ;


if (nilai_obj.length >0)  {

location.reload(); 

}

}


function openDraw(kon,gam){

window.location = 'read.php?module=read&kon=kon&gam=gam' ;


}
function fung_add_comment(code){

	var name_element = document.getElementById('coment');
	var commnet = name_element.value;
	var code = code ;
	var name_element = document.getElementById('objek_array');
	var gambar = name_element.value;
	var name_element = document.getElementById('select');
	var jenis_gam= name_element.value;
	
	var modul= "commenting";
	var act = "add";
	var strurl = act + "#" + code + "#" + commnet + "#" + gambar + "#" + jenis_gam  + "#";
	
	if ((commnet.length > 0) && (gambar.length > 0 )) {

	PosttRequest("isicommneting",modul,"process-ogs",strurl);	
			
	} else { alert ('Comment or Drawing cant be empty');}	

}


function fung_del_comment(id, code){

	var name_element = document.getElementById('coment');
	var id_coment = id;
	var code = code ;

	
	var modul= "commenting";
	var act = "del";
	
	var strurl = act + "#" + code + "#" + id + "#" ;
if (confirm('Are you sure you want to dell ?')) {		

	PosttRequest("isicommneting",modul,"process-ogs",strurl);			
}			
	

}

function fung_close_comment(id, code){

	var name_element = document.getElementById('coment');
	var id_coment = id;
	var code = code ;
	
	var name_element = document.getElementById('myonoffswitch');
	if  (name_element.checked == true)
	{ var nilai = 0; }
	else
	{var nilai = 1 ;}
	
	var modul= "commenting";
	var act = "close";
	var strurl = act + "#" + code + "#" + id_coment + "#" + nilai + "#" ;
	
	PosttRequest("deskripsi",modul,"process-ogs",strurl);	
/* 	
	$.post("coment/proc_com.php", { act: act , modul: modul, id_coment:id_coment , code:code, nilai:nilai  } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);}); */
			


}

function fung_update_point(id, code,point){

	var name_element = document.getElementById('coment');
	var id_coment = id;
	var code = code ;
	
	var posisi=point;
	var modul= "commenting";
	var act = "update_point";
	var strurl = act + "#" + code + "#" + id + "#" + point + "#" ;
	if (confirm('Your Commnet will be send , and wait for moderasi')) {

		PosttRequest("isicommneting",modul,"process-ogs",strurl);			
} else {
    // Do nothing!
}
	
			
	

}

function fung_moderat_comment(id, code, nilai){

	var name_element = document.getElementById('coment');
	var nilai = nilai ;
	var id_coment = id;
	var code = code ;

	
	var modul= "moderation";
	var act = "update";
	var strurl = act + "#" + code + "#" + id + "#" + nilai + "#" ;	
	PosttRequest("moderation",modul,"process-ogs",strurl);		
	

}

function fung_del_gambar_rev(code,id_gamb,id_gam_induk){
	
	var id_gamb = id_gamb;
	var id_gam_induk =id_gam_induk;
	var code = code ;
	var modul= "drawing";
	var act = "del_rev";
	var strurl = act + "#" + code + "#" + id_gamb + "#" + id_gam_induk + "#" ;	
	
if (confirm('Are you sure , del the Revision')) {

	PosttRequest("project",modul,"process-ogs",strurl);			
} else {
    // Do nothing!
}

}

function fung_del_gambar(code,id_gamb){
	
	var id_gamb = id_gamb;
	var code = code ;
	var modul= "drawing";
	var act = "delall";
	
	var strurl = act + "#" + code + "#" + id_gamb + "#"  ;	
		
if (confirm('Are you sure , del the drawing and all Revision')) {
	PosttRequest("isiinputdrawing",modul,"process-ogs",strurl);	

} else {
    // Do nothing!
}

}

function fung_add_replay(code,id_koment){
	var name_element = document.getElementById('coment');
	var commnet = name_element.value;
	var code = code ;
	var id_koment=id_koment;
	var name_element = document.getElementById('select');
	var pengirim = name_element.value;
	
	document.getElementById('coment').value=''
	
	var modul= "commenting";
	var act = "addreplay";
	var strurl = act + "#" + code + "#" + id_koment + "#" + commnet + "#" + pengirim + "#" ;	
	
	if (commnet.length > 0) {	
	PosttRequest("deskripsi",modul,"process-ogs",strurl);	
	
/* 	$.post("coment/proc_com.php", { act: act , modul: modul, commnet:commnet , code:code , id_koment:id_koment,  pengirim:pengirim} , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);}); */
			
	}else { alert ('Replay cant be empty');}		

}

function fung_del_replay(code,id_koment,comment,id){
	var name_element = document.getElementById('coment');
	var commnet = comment;
	var code = code ;
	var id_koment=id_koment;
	var id=id;
	var name_element = document.getElementById('select');
	var pengirim = name_element.value;
	
	document.getElementById('coment').value=''
	
	var modul= "commenting";
	var act = "delreplay";
	var strurl = act + "#" + code + "#" + id_koment + "#" + commnet + "#" + pengirim + "#" + id + "#" ;
	
	if (confirm('Are you sure you want to dell ?')) {		
	
	PosttRequest("deskripsi",modul,"process-ogs",strurl);	
	
	}
	
/* 	$.post("coment/proc_com.php", { act: act , modul: modul, commnet:commnet , code:code , id_komentid_koment:id_koment,id:id} , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);}); */
			
		

}


function fung_update_commnet(code){
	var name_element = document.getElementById('upcoment');
	var commnet = name_element.value;
	var code = code ;
	var name_element = document.getElementById('update_obj');
	var id_koment = name_element.value;

	
	var modul= "commenting";
	var act = "update";
	var strurl = act + "#" + code + "#" + id_koment + "#" + commnet + "#" ;	

	PosttRequest("isicommneting",modul,"process-ogs",strurl);				
	

}

function popup() {

		$( "#editComent" ).dialog({

				autoOpen: true,
				height: 250,
				width: 500,
				show: "blind",
				hide: "fadeout"

		});
	}

	function show_update(id_coment,com_num){

		document.getElementById('update_obj').value='';
		document.getElementById('upcoment').value='';
		//popup();
		document.getElementById('update_obj').value=id_coment;
		document.getElementById('comnumber').value=com_num;
		
}

function Cserial(sInput){

var str = sInput ;
var str_array = str.split(',');	
var str_compilation="" ;

for(var i = 0; i < str_array.length; i++) {

   str_compilation = str_compilation  + str_array[i] + "#"
  
}
return 	str_compilation ;
	
}

function refreshuploadbulk(){
	var modul= "uploadbluck";
	var act = "refresh";
	var strurl = act + "#" ;	
	
	PosttRequest("refreshgalery",modul,"process-ogs",strurl);	
}
function refresheditbulk(){
	var modul= "uploadbluck";
	var act = "refreshedit";
	var strurl = act + "#" ;	
	
	PosttRequest("editing",modul,"process-ogs",strurl);	
	uncheckAll();
}
function refreshmoderationbulk(){
	var modul= "uploadbluck";
	var act = "refreshmoderation";
	var strurl = act + "#" ;	
	
	PosttRequest("moderation",modul,"process-ogs",strurl);
	uncheckAll();	
}
function deleditupload(id){
	var modul= "uploadbluck";
	var act = "delleditupload";
	var strurl = act + "#" + id + "#";	
	
	PosttRequest("editing",modul,"process-ogs",strurl);	
}
function delmodupload(id){
	var modul= "uploadbluck";
	var act = "delleditupload";
	var strurl = act + "#" + id + "#";	
	
	PosttRequest("moderation",modul,"process-ogs",strurl);	
}
function delupload(id){
	var modul= "uploadbluck";
	var act = "delupload";
	var strurl = act + "#" + id + "#";	
	
	PosttRequest("refreshgalery",modul,"process-ogs",strurl);	
}

function addcostproject(idKegiatan){
	
var nameCost=document.getElementById('nameCost').value;
var nilaicostRupiah=document.getElementById('jmlcostrupiah').value;
var nilaicost= document.getElementById('jmlcost').value;
var currency= document.getElementById('form-field-select-1').value;
var totaldana=document.getElementById('totalcost').value;
var InvestorEvent= getValueRadio('optionsRadios');
var idKegiatan= idKegiatan;
var realization = document.getElementById('realization').value;

var kurs= document.getElementById('invet_kurs').value; 
var descriptionCost= $("#form-field-22433").val();

	var stringCommand= "add#" + nameCost  + "#" + nilaicost  + "#" + currency  + "#" + kurs  + "#" + nilaicostRupiah  + "#" + InvestorEvent  + "#" + idKegiatan  + "#" + totaldana + "#" + realization + "#";
	var page="process-ogs.php";
	
	if (nameCost != ""){		
		

		FuncAjaxRequestt(page,"listpengeluaran","cost",stringCommand,descriptionCost," ");	
		//clearFrom();	
	}else {
		alert("Please fill the blank field");
		}
}
function getValueRadio(nameRadio){
	var radios = document.getElementsByName(nameRadio);

	for (var i = 0, length = radios.length; i < length; i++) {
    if (radios[i].checked) {
        // do whatever you want with the checked radio
        //alert(radios[i].value);
		return radios[i].value ;
        // only one radio can be logically checked, don't check the rest
        break;
    }
	}
}

function delcost(id,idproject,type){
	var modul= "cost";
	var act = "del";
	var strurl = act + "#" + idproject + "#" + id  + "#" + type + "#" ;	
	
	PosttRequest("listpengeluaran",modul,"process-ogs",strurl);	
}
function refreshincome(idproject){
	var modul= "cost";
	var act = "refreshincome";
	var strurl = act + "#" + idproject + "#"  ;	
	
	PosttRequest("listpengeluaran",modul,"process-ogs",strurl);	
}
function refreshcost(idproject){
	var modul= "cost";
	var act = "refreshcost";
	var strurl = act + "#" + idproject + "#"  ;	
	
	PosttRequest("listpengeluaran",modul,"process-ogs",strurl);	
}

function calcTotaldana(){
	
	var nilairupiah=document.getElementById('jmlcostrupiah').value; 
	var nilaivalutaAsing=document.getElementById('jmlcost').value; 
	var kurs=document.getElementById('invet_kurs').value; 
	
	document.getElementById('totalcost').value= (nilaivalutaAsing * kurs) + Number(nilairupiah) ;
	
}

function addClientProject(){
	
	var nickuser=document.getElementById('nickuser').value; 
	var aka=document.getElementById('aka').value; 
	var email=document.getElementById('emailll').value; 
	var pass=document.getElementById('pass').value; 
        pass= hex_sha512(pass);

     var tlp=document.getElementById('telp').value; 
    var company=document.getElementById('company').value; 
    var hp=document.getElementById('hp').value;   
	
	var modul= "client";
	var act = "add";
	var strurl = act  + "#" + nickuser + "#" + aka + "#" + email + "#" + pass + "#" + tlp + "#"+ company + "#"+ hp + "#" ;	
	
	PosttRequest("project",modul,"process-ogs",strurl);		
}

function dellClientProject(id){


	var modul= "client";
	var act = "del";
	
	var strurl = act  + "#" + id + "#" ;
if (confirm('Are you sure you want to dell ?')) {		

	PosttRequest("project",modul,"process-ogs",strurl);			
}			
}
function ResetClientProject(id){


	var modul= "client";
	var act = "reset";
	
	
if (confirm('Are you sure you want to reset password ?')) {

	var person = prompt("Please enter your new passwords", "");
	if (person != null) {
		person= hex_sha512(person);
		var strurl = act  + "#" + id + "#" + person + "#";
		PosttRequest("project",modul,"process-ogs",strurl);		
	}
	

		
}			
}
function lockClientProject(id,nilai){


	var modul= "client";
	var act = "lock";
	
	var strurl = act  + "#" + id + "#" + nilai + "#" ;
if (confirm('Are you sure you want to lock ?')) {		

	PosttRequest("project",modul,"process-ogs",strurl);			
}			
}
function refreshClientProject(){
	

	var modul= "client";
	var act = "refresh";
	var strurl = act  + "#" ;	
	
	PosttRequest("project",modul,"process-ogs",strurl);		
}

function updateClientProject(id){
	
	var nickuser=document.getElementById('nickuser').value; 
	var aka=document.getElementById('aka').value; 
	var email=document.getElementById('emailll').value; 

	
	var modul= "client";
	var act = "update";
	var strurl = act  + "#" + nickuser + "#" + aka + "#" + email + "#" + id + "#" ;	
	
	PosttRequest("projectlist",modul,"process-ogs",strurl);		
}
//END commneting

function addClientassosiated(id){

	var idproject=document.getElementById('team').value; 
	var modul= "client";
	var act = "addassosiation";
	
	var strurl = act  + "#" + id + "#" + idproject + "#";
	

	PosttRequest("projectlist",modul,"process-ogs",strurl);			
			
}
function dellClientassosiated(idclient,id){


	var modul= "client";
	var act = "dellassosiation";
	
	var strurl = act  + "#" + idclient + "#" + id + "#" ;
	
if (confirm('Are you sure you want to dell ?')) {	
	PosttRequest("projectlist",modul,"process-ogs",strurl);

}	
			
}
function refreshassosiation(idclient){


	var modul= "client";
	var act = "refreshassosiation";
	
	var strurl = act  + "#" + idclient + "#" ;
	

	PosttRequest("projectlist",modul,"process-ogs",strurl);
	
			
}
function refreshfaq(){
	var modul= "faq";
	var act = "refresh";
	var strurl = act  + "#" ;	
	
	PosttRequest("project",modul,"process-ogs",strurl);			
}

function addfaq(){
	
	var subject=document.getElementById('subject').value; 
	var descr=document.getElementById('descr').value; 

	var modul= "faq";
	var act = "add";
	var strurl = act  + "#" + subject + "#" + descr + "#" ;	
	
	PosttRequest("project",modul,"process-ogs",strurl);		
}

function dellfaq(id){


	var modul= "faq";
	var act = "dell";
	
	var strurl = act  + "#" + id + "#" ;
	
if (confirm('Are you sure you want to dell ?')) {	
	PosttRequest("project",modul,"process-ogs",strurl);

}	
			
}
function dellTechnical(id,idkon){


	var modul= "technical";
	var act = "dell";
	
	var strurl = act  + "#" + id + "#" + idkon + "#" ;
	
if (confirm('Are you sure you want to dell ?')) {	
	PosttRequest("isitechnical",modul,"process-ogs",strurl);

}	
			
}
function refrestechnical(idkon){
	var modul= "technical";
	var act = "refresh";
	var strurl = act  + "#" + idkon + "#" ;	
	
	PosttRequest("isitechnical",modul,"process-ogs",strurl);				
}

function AnswerTechnical(id,idkon){
	
var answer = prompt("Please enter your answer", "");
if (answer != null) {

	var modul= "technical";
	var act = "update";
	var strurl = act  + "#" + id + "#" + idkon + "#" + answer + "#" ;	
	
	PosttRequest("isitechnical",modul,"process-ogs",strurl);
}	
}
function changegambarload(idkon){
	var modul= "downloadreq";
	var act = "refreshlistgambar";
	var type=document.getElementById("changegambarload").value;
	var strurl = act  + "#" + idkon + "#" + type +"#" ;	
	
	PosttRequest("listdrawing",modul,"process-ogs",strurl);				
}
function requestdownload(id,id_kon,drawingno){
	var modul= "downloadreq";
	var act = "add";
	
	var strurl = act  + "#" + id_kon + "#" + id +"#" + drawingno + "#" ;	
	
	PosttRequest("ididownloadrequest",modul,"process-ogs",strurl);				
}
function refreshrequestdownload(id_kon){
	var modul= "downloadreq";
	var act = "refreshrequestdownload";
	
	var strurl = act  + "#" + id_kon + "#"  ;	
	
	PosttRequest("ididownloadrequest",modul,"process-ogs",strurl);				
}
function refreshlistmoderationrequestdownload(id_kon){
	var modul= "downloadreq";
	var act = "refreshrequestmoderationdownload";
	
	var strurl = act  + "#" + id_kon + "#"  ;	
	
	PosttRequest("moderationdrawing",modul,"process-ogs",strurl);
setTimeout(function(){ refreshstampmoderation(id_kon); }, 1000);	
}
function moderationdownload(id,id_kon,nilai){
	var modul= "downloadreq";
	var act = "moderationDownload";

	var strurl = act  + "#" + id_kon + "#" + nilai + "#" + id + "#"   ;	
	
	PosttRequest("moderationdrawing",modul,"process-ogs",strurl);				
}



//buat baru

function suggestgambar(inputString,code){
		if(inputString.length == 0) {
			$('#suggestionsListgambar').fadeOut();
		} else {
		var tipe=document.getElementById("tipegambarstamp").value;
		var point=3;	
		
		$('#countryyrrttt').addClass('load');
		var name_element = document.getElementById('select');

			$.post("kontrak/autosuggest_draw.php", {queryString: ""+inputString+"", code : code, tipe:tipe,point:point}, function(data){
				if(data.length >0) {
					$('#suggestionsListgambar').fadeIn();
					$('#suggestionsListgambar').html(data);
					$('#countryy').removeClass('load');
				}
			});
		}
	}
	
	function fillopopopo(thisValue , nilai2 ,nilaii ) {
	if (typeof thisValue != 'undefined') {

		
		document.getElementById('textfielddrawingnumber').value=thisValue;
		document.getElementById('judulstamp').value=nilai2;
		document.getElementById('no_edrawinggg').value=nilaii;
		
		$("#suggestionsListgambar").fadeOut(400);
		
	}else {
	document.getElementById('judulstamp').value='';
	document.getElementById('no_edrawinggg').value=0;
		
		
		setTimeout("$('#suggestionsListgambar').fadeOut();", 600);
		}
	
	}

function addStamp(code){
	
	var modul= "uploadstamp";
	var act = "add";
	var idgambar = document.getElementById('no_edrawinggg').value;
	var namagambar = document.getElementById('judulstamp').value;
	
	if(idgambar !=0){
	
	var strurl = act  + "#" + code + "#" + idgambar + "#" + namagambar + "#";
	PosttRequest("isiuploadstamp",modul,"process-ogs",strurl);
	}
}

function refreshstamp(id){
	var modul= "uploadstamp";
	var act = "refressh";
	
	var strurl = act  + "#" + id + "#";
PosttRequest("isiuploadstamp",modul,"process-ogs",strurl);
			
}

function dellStampupload(id,idkon){
	var modul= "uploadstamp";
	var act = "dell";
	
	var strurl = act  + "#" + idkon + "#" + id + "#" ;
	
if (confirm('Are you sure you want to dell ?')) {	
	PosttRequest("isiuploadstamp",modul,"process-ogs",strurl);

}	
			
}
function dellStampuploadmnager(id,idkon){
	var modul= "uploadstamp";
	var act = "dellmode";
	
	var strurl = act  + "#" + idkon + "#" + id + "#" ;
	
if (confirm('Are you sure you want to dell ?')) {	
	PosttRequest("moderationstamp",modul,"process-ogs",strurl);

}	
			
}
function refreshstampmoderation(id){
	var modul= "uploadstamp";
	var act = "refreshmoderation";
	var tipe  =$("input[name='refreshStampRadio']:checked").val();


	var strurl = act  + "#" + id + "#" + tipe + "#";
	//alert(strurl);
PosttRequest("moderationstamp",modul,"process-ogs",strurl);
			
}

function reviewStamp(id,idkon){
	var modul= "uploadstamp";
	var act = "moderationStamp";
	var strurl = act  + "#" + idkon  + "#" + id + "#";
PosttRequest("moderationstamp",modul,"process-ogs",strurl);
			
}
function updateproject(idkon){
	var modul= "updateproject";
	var act = "updateprojectt";
	
	var param_notation = document.getElementById('param_notation').value;  
	var param_ofreg = document.getElementById('param_ofreg').value; 
	var param_callsign= document.getElementById('param_callsign').value; 
	var param_flagname= document.getElementById('param_flagname').value; 
	var param_port= document.getElementById('param_port').value; 
	var param_datereg= document.getElementById('param_datereg').value; 
	var param_kelllaying= document.getElementById('param_kelllaying').value; 
	var param_delivery= document.getElementById('param_delivery').value; 
	var param_solas= document.getElementById('param_solas').value; 
	var param_marpol= document.getElementById('param_marpol').value; 
	var param_ibc= document.getElementById('param_ibc').value; 
	var param_ism= document.getElementById('param_ism').value; 
	var param_Ddwt= document.getElementById('param_Ddwt').value; 
	var param_lpp= document.getElementById('param_lpp').value; 
	var param_b= document.getElementById('param_b').value; 
	var param_depth= document.getElementById('param_depth').value; 
	var param_fp= document.getElementById('param_fp').value; 
	var param_loading= document.getElementById('param_loading').value; 
	var param_stability= document.getElementById('param_stability').value; 

	var strurl = act  + "#" + idkon  + "#" +  param_notation + "#" + param_ofreg + "#" + param_callsign + "#" + param_flagname + "#" + param_port + "#" + param_datereg + "#" + param_kelllaying + "#" + param_delivery + "#" + param_solas + "#" + param_marpol + "#" + param_ibc + "#" + param_ism + "#" + param_Ddwt + "#"  + param_lpp + "#" + param_b + "#" + param_depth + "#" + param_fp + "#" + param_loading + "#" + param_stability + "#";
	
	PosttRequest("updateprojectt",modul,"process-ogs",strurl);	
}

function addtype1(idkon){
	var modul= "updateproject";
	var act = 1;
	
	var prevname_param1= document.getElementById('prevname_param1').value; 
	var prevname_param2= document.getElementById('prevname_param2').value; 
	var prevname_param3= document.getElementById('prevname_param3').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#" ;
	//alert(strurl);
	PosttRequest("previousname",modul,"process-ogs",strurl);	
}
function addtype2(idkon){
	var modul= "updateproject";
	var act = 2;
	
	var prevname_param1= document.getElementById('prevflag_param1').value; 
	var prevname_param2= document.getElementById('prevflag_param2').value; 
	var prevname_param3= document.getElementById('prevflag_param3').value; 
	var prevname_param4= document.getElementById('prevflag_param4').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#"+ prevname_param4 + "#" ;
	//alert(strurl);
	PosttRequest("previousflag",modul,"process-ogs",strurl);	
}
function addtype3(idkon){
	var modul= "updateproject";
	var act = 3;
	
	var prevname_param1= document.getElementById('state_param1').value; 
	var prevname_param2= document.getElementById('state_param2').value; 
	var prevname_param3= document.getElementById('state_param3').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#" ;
	//alert(strurl);
	PosttRequest("stateinformation",modul,"process-ogs",strurl);	
}
function addtype4(idkon){
	var modul= "updateproject";
	var act = 4;
	
	var prevname_param1= document.getElementById('anchor_param1').value; 
	var prevname_param2= document.getElementById('anchor_param2').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#"  ;
	//alert(strurl);
	PosttRequest("anchoeequipment",modul,"process-ogs",strurl);	
}
function addtype5(idkon){
	var modul= "updateproject";
	var act = 5;
	
	var prevname_param1= document.getElementById('other_param1').value; 
	var prevname_param2= document.getElementById('other_param2').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#"  ;
	//alert(strurl);
	PosttRequest("otherinfo",modul,"process-ogs",strurl);	
}
function addtype6(idkon){
	var modul= "updateproject";
	var act = 6;
	
	var prevname_param1= document.getElementById('tonnage_param1').value; 
	var prevname_param2= document.getElementById('tonnage_param2').value; 
	var prevname_param3= document.getElementById('tonnage_param3').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#" ;
	//alert(strurl);
	PosttRequest("tonagee",modul,"process-ogs",strurl);	
}
function addtype7(idkon){
	var modul= "updateproject";
	var act = 7;
	
	var prevname_param1= document.getElementById('builder_param1').value; 
	var prevname_param2= document.getElementById('builder_param2').value; 
	var prevname_param3= document.getElementById('builder_param3').value; 
	var prevname_param4= document.getElementById('builder_param4').value; 
	var prevname_param5= document.getElementById('builder_param5').value; 
	var prevname_param6= document.getElementById('builder_param6').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#"+ prevname_param4 + "#" + prevname_param5 + "#" + prevname_param6 + "#" ;
	//alert(strurl);
	PosttRequest("builder",modul,"process-ogs",strurl);	
}
function addtype8(idkon){
	var modul= "updateproject";
	var act = 8;
	
	var prevname_param1= document.getElementById('iacs_param1').value; 


	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#"  ;
	//alert(strurl);
	PosttRequest("iacsunified",modul,"process-ogs",strurl);	
}
function addtype9(idkon){
	var modul= "updateproject";
	var act = 9;
	
	var prevname_param1= document.getElementById('imo_param1').value; 


	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#"  ;
	//alert(strurl);
	PosttRequest("imorequirement",modul,"process-ogs",strurl);	
}

function addtype10(idkon){
	var modul= "updateproject";
	var act = 10;
	
	var prevname_param1= document.getElementById('freeoard_param1').value; 
	var prevname_param2= document.getElementById('freeoard_param2').value; 
	var prevname_param3= document.getElementById('freeoard_param3').value; 
	var prevname_param4= document.getElementById('freeoard_param4').value; 
	var prevname_param5= document.getElementById('freeoard_param5').value; 


	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#"+ prevname_param4 + "#" + prevname_param5 + "#"  ;
	//alert(strurl);
	PosttRequest("freeboardassigment",modul,"process-ogs",strurl);	
}
function addtype11(idkon){
	var modul= "updateproject";
	var act = 11;
	
	var prevname_param1= document.getElementById('material_param1').value; 
	var prevname_param2= document.getElementById('material_param2').value; 
	var prevname_param3= document.getElementById('material_param3').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#" ;
	//alert(strurl);
	PosttRequest("material",modul,"process-ogs",strurl);	
}
function addtype12(idkon){
	var modul= "updateproject";
	var act = 12;
	
	var prevname_param1= document.getElementById('stifener_param1').value; 
	var prevname_param2= document.getElementById('stifener_param2').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#"  ;
	//alert(strurl);
	PosttRequest("styfennersystem",modul,"process-ogs",strurl);	
}
function addtype13(idkon){
	var modul= "updateproject";
	var act = 13;
	
	var prevname_param1= document.getElementById('bulkhead_param1').value; 
	var prevname_param2= document.getElementById('bulkhead_param2').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#"  ;
	//alert(strurl);
	PosttRequest("bulkheadsystem",modul,"process-ogs",strurl);	
}
function addtype14(idkon){
	var modul= "updateproject";
	var act = 14;
	
	var prevname_param1= document.getElementById('tank_param1').value; 
	var prevname_param2= document.getElementById('tank_param2').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#"  ;
	//alert(strurl);
	PosttRequest("tanki",modul,"process-ogs",strurl);	
}
function addtype15(idkon){
	var modul= "updateproject";
	var act = 15;
	
	var prevname_param1= document.getElementById('mainprop_param1').value; 
	var prevname_param2= document.getElementById('mainprop_param2').value; 
	var prevname_param3= document.getElementById('mainprop_param3').value; 
	var prevname_param4= document.getElementById('mainprop_param4').value; 
	var prevname_param5= document.getElementById('mainprop_param5').value; 


	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#"+ prevname_param4 + "#" + prevname_param5 + "#"  ;
	//alert(strurl);
	PosttRequest("maipropulsion",modul,"process-ogs",strurl);	
}
function addtype16(idkon){
	var modul= "updateproject";
	var act = 16;
	
	var prevname_param1= document.getElementById('propulsor_param1').value; 
	var prevname_param2= document.getElementById('propulsor_param2').value; 
	var prevname_param3= document.getElementById('propulsor_param3').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#" ;
	//alert(strurl);
	PosttRequest("propulsor",modul,"process-ogs",strurl);	
}
function addtype17(idkon){
	var modul= "updateproject";
	var act = 17;
	
	var prevname_param1= document.getElementById('shafting_param1').value; 
	var prevname_param2= document.getElementById('shafting_param2').value; 
	var prevname_param3= document.getElementById('shafting_param3').value; 
	var prevname_param4= document.getElementById('shafting_param4').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#"+ prevname_param4 + "#" ;
	//alert(strurl);
	PosttRequest("shafting",modul,"process-ogs",strurl);	
}
function addtype18(idkon){
	var modul= "updateproject";
	var act = 18;
	
	var prevname_param1= document.getElementById('piping_param1').value; 


	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#"  ;
	//alert(strurl);
	PosttRequest("pipingsystem",modul,"process-ogs",strurl);	
}
function addtype19(idkon){
	var modul= "updateproject";
	var act = 19;
	
	var prevname_param1= document.getElementById('powerdist_param1').value; 
	var prevname_param2= document.getElementById('powerdist_param2').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#"  ;
	//alert(strurl);
	PosttRequest("mainpower",modul,"process-ogs",strurl);	
}
function addtype20(idkon){
	var modul= "updateproject";
	var act = 20;
	
	var prevname_param1= document.getElementById('capacity_param1').value; 
	var prevname_param2= document.getElementById('capacity_param2').value; 
	var prevname_param3= document.getElementById('capacity_param3').value; 

	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#" ;
	//alert(strurl);
	PosttRequest("capacitytank",modul,"process-ogs",strurl);	
}
function addtype21(idkon){
	var modul= "updateproject";
	var act = 21;
	
	var prevname_param1= document.getElementById('liftingeq_param1').value; 
	var prevname_param2= document.getElementById('liftingeq_param2').value; 
	var prevname_param3= document.getElementById('liftingeq_param3').value; 
	var prevname_param4= document.getElementById('liftingeq_param4').value; 
	var prevname_param5= document.getElementById('liftingeq_param5').value; 


	var strurl = act  + "#" + idkon  + "#" + prevname_param1 + "#" + prevname_param2 + "#" + prevname_param3 + "#"+ prevname_param4 + "#" + prevname_param5 + "#"  ;
	//alert(strurl);
	PosttRequest("liftingequipment",modul,"process-ogs",strurl);	
}

function dellGeneraldata(idkon,id,tipe,kelass){
	var modul= "updateproject";
	var act = "dell";

	var strurl = act  + "#" + idkon  + "#" + id + "#" + tipe + "#" ;
	//alert(strurl);
	if (confirm('Are you sure you want to dell ?')) {	
	PosttRequest(kelass,modul,"process-ogs",strurl);	
	}
}

function RefreshGeneraldata(idkon){
	
	setTimeout(function(){ RefreshPerjenis(idkon,1,"previousname"); }, 1050);
	setTimeout(function(){ RefreshPerjenis(idkon,2,"previousflag"); }, 1100);
	setTimeout(function(){ RefreshPerjenis(idkon,3,"stateinformation"); }, 1150);
	setTimeout(function(){ RefreshPerjenis(idkon,4,"anchoeequipment"); }, 1200);
	setTimeout(function(){ RefreshPerjenis(idkon,5,"otherinfo"); }, 1250);
	setTimeout(function(){ RefreshPerjenis(idkon,6,"tonagee"); }, 1300);
	setTimeout(function(){ RefreshPerjenis(idkon,7,"builder"); }, 1350);
	setTimeout(function(){ RefreshPerjenis(idkon,8,"iacsunified"); }, 1400);
	setTimeout(function(){ RefreshPerjenis(idkon,9,"imorequirement"); }, 1450);
	setTimeout(function(){ RefreshPerjenis(idkon,10,"freeboardassigment"); }, 1500);
	setTimeout(function(){ RefreshPerjenis(idkon,11,"material"); }, 1550);
	setTimeout(function(){ RefreshPerjenis(idkon,12,"styfennersystem"); }, 1600);
	setTimeout(function(){ RefreshPerjenis(idkon,13,"bulkheadsystem"); }, 1650);
	setTimeout(function(){ RefreshPerjenis(idkon,14,"tanki"); }, 1700);
	setTimeout(function(){ RefreshPerjenis(idkon,15,"maipropulsion"); }, 1750);
	setTimeout(function(){ RefreshPerjenis(idkon,16,"propulsor"); }, 1800);
	setTimeout(function(){ RefreshPerjenis(idkon,17,"shafting"); }, 1850);
	setTimeout(function(){ RefreshPerjenis(idkon,18,"pipingsystem"); }, 1900);
	setTimeout(function(){ RefreshPerjenis(idkon,19,"mainpower"); }, 1950);
	setTimeout(function(){ RefreshPerjenis(idkon,20,"capacitytank"); }, 2000);
	setTimeout(function(){ RefreshPerjenis(idkon,21,"liftingequipment"); }, 2050);
}

function RefreshPerjenis(idkon,tipe,kelass){
	
	var modul= "updateproject";
	var act = "refreshall";
	var strurl = act  + "#" + idkon  + "#" + kelass + "#" + tipe + "#" ;
	
	PosttRequest(kelass,modul,"process-ogs",strurl);	
}
function setEditdraw(dranum,dratitle,tipee,id){
	var tipe= tipee - 1;
	document.getElementById('drawnumberedit').value=dranum;
	document.getElementById('iddrawedit').value=id;
	document.getElementById('titledrawedit').value=dratitle;
	document.teenageMutant.typeeditdraw[tipe].checked=true;
		
}
function setEditdrawproperty(dranum,dratitle,tipee,id,nill){

	document.getElementById('prop_drawnumberedit').value=dranum;
	document.getElementById('idPropdraw').value=id;
	document.getElementById('prop_titledrawedit').value=dratitle;
	document.getElementById('enginnerfiled').value=nill;
	document.teenageMutanttt.prop_typeeditdraw[tipee].checked=true;

		
}
function savechangedrwaproperty(idkon){
	
	var modul= "updateproject";
	var act = "editproperty";
	
	var drawnumber= document.getElementById('drawnumberedit').value;
	var iddraw=document.getElementById('iddrawedit').value;
	var title=document.getElementById('titledrawedit').value;
	var radios = document.getElementsByName('typeeditdraw');

	for (var i = 0, length = radios.length; i < length; i++) {
		if (radios[i].checked) {
			// do whatever you want with the checked radio
			tipe=(radios[i].value);

			// only one radio can be logically checked, don't check the rest
			break;
		}
	}	
	
	var strurl = act  + "#" + idkon  + "#" + iddraw + "#" + drawnumber + "#"+ title +  "#"+ tipe + "#" ;
	
	PosttRequest("isiinputdrawing","drawing","process-ogs",strurl);	
}
function projectdone(idkon){
	

	var checked=true;
	var elements = document.getElementsByName("projectchecklist[]");
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {

		}else{
			checked = false;
			break;
			
		}
	}

	
	if (checked == false){
		alert('harus dicnetang kabeh broww');
	}else{
		modul="updateproject";
		act="updatestatusdone" ;
		nilai=1; 
		person="ok";

		var strurl = act  + "#" + idkon + "#" + person + "#"+ nilai + "#";			
		PosttRequest("project1",modul,"process-ogs",strurl);
	}
	
	
}
function projectundone(idkon){
	
	var person = prompt("Please enter the reason", "");
	if (person != null) {
		
		modul="updateproject";
		act="updatestatusdone" ;
		nilai=2; 		
		var strurl = act  + "#" + idkon  + "#" + person + "#"+ nilai + "#";
		PosttRequest("project1",modul,"process-ogs",strurl);		
	}
}

function generatedTable(indx){
	var namtable = "#sample_" + indx ; 
	
	      var oTable = $(namtable).dataTable({
            "aoColumnDefs": [{
                "aTargets": [0]
            }],
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Rows",
                "sSearch": "",
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },
            "aLengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10,
        });
        $(namtable + '_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        // modify table search input
        $(namtable + '_wrapper .dataTables_length select').addClass("m-wrap small");
        // modify table per page dropdown
        $(namtable + '_wrapper .dataTables_length select').select2();
        // initialzie select2 dropdown
        $(namtable + '_column_toggler input[type="checkbox"]').change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
}

function changetipeObject(){

	var type=document.getElementById("tipe").value;

	if (type==1){
		
		alert("satu");
	}else if(type==2){
		alert("dua");
	}
	else if(type==3){
		alert("3");
	}
	else if(type==4){
		alert("4");
	}
	else if(type==5){
		alert("5");
	}
	
}




	



