//script training
var taskrefresh=false;
var notifrefresh=false;
function fung_Training(idTraining,act,nameTraining,tipeTraining,scheduleTraining,realization,particpanTraining,locationTraining,descriptionTraining,status,typeEvent){


	var modul= "training";
	
	
	$.post("process.php", {typeEvent:typeEvent, act: act , modul: modul, idTraining:idTraining,nameTraining:nameTraining , tipeTraining:tipeTraining , scheduleTraining:scheduleTraining,realization:realization,particpanTraining:particpanTraining,locationTraining:locationTraining ,descriptionTraining:descriptionTraining,status:status } , function(html) {
			$('.training').html(html);
			$(".training").hide();
			$(".training").fadeIn(400);});

}

function addTraining(){

var nameTraining=document.getElementById('form-field-1').value;
var tipeTraining= document.getElementById('form-field-select-1').value;
var scheduleTraining= document.getElementById('schedule').value;
var realization= document.getElementById('realization').value;
var particpanTraining= "" ;
var locationTraining= document.getElementById('location').value;
var descriptionTraining= $("#pesanndee").val();

//var descriptionTraining= document.getElementById('form-field-22').value;
var typeEvent= document.getElementById('form-field-select-3').value;

var e = document.getElementById("form-field-select-4");	
if (nameTraining != ""){		
for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
		
		particpanTraining= particpanTraining + "," + e.options[i].value  ;
    }
}
	

	var act = "add";
	var idTraining=0 ;
	fung_Training(idTraining,act,nameTraining,tipeTraining,scheduleTraining,realization,particpanTraining,locationTraining,descriptionTraining,0,typeEvent);

	clearFrom();
	}else {
	alert("Please fill the blank field");
	}
	}

function addmeeting(idproj){

var subject=document.getElementById('form-field-1').value;

var scheduleTraining= document.getElementById('schedule').value;

var particpanTraining= "" ;
var locationTraining= document.getElementById('location').value;
var descriptionTraining= $("#pesanndee").val();
var idproj =idproj;



var emailExternal = $('#tags span').map(function(){ 
    return $(this).text(); 
}).get().join(',');


if (subject != ""){		

	

	var act = "add";
	var modul= "meeting";
	
	
	$.post("process.php", {act: act , modul: modul,subject:subject , scheduleTraining:scheduleTraining,idproj:idproj,locationTraining:locationTraining ,descriptionTraining:descriptionTraining,emailExternal:emailExternal } , function(html) {
			$('.mett').html(html);
			$(".mett").hide();
			$(".mett").fadeIn(400);});
			
	clearFrom();
	}else {
	alert("Please fill the blank field");
	}
	}

function dellMeeting (idNumber,idProject){

if (confirm('Are you sure you want to dell ?')) {
var act = "del";
var modul= "meeting";
$.post("process.php", {act: act , modul: modul,id:idNumber,idproj:idProject } , function(html) {
			$('.mett').html(html);
			$(".mett").hide();
			$(".mett").fadeIn(400);});
			
}	
	
}

function delpeople(idproj,idmom,idUserr){
	
	if (confirm('Are you sure you want to dell ?')) {
		var act = "dellpeople";
		var modul= "meeting";
$.post("process.php", {act: act , modul: modul,idproj:idproj,idmom:idmom,idUserr:idUserr } , function(html) {
			$('.document').html(html);
			$(".document").hide();
			$(".document").fadeIn(400);});
			
}
	
}

function addpeopleMeeting(idproj,idmom){
	
var idUserr= document.getElementById('team').value;

		var act = "addpeople";
		var modul= "meeting";
		
$.post("process.php", {act: act , modul: modul,idproj:idproj,idmom:idmom,idUserr:idUserr } , function(html) {
			$('.document').html(html);
			$(".document").hide();
			$(".document").fadeIn(400);});	
	
}

function updateMeeting(idproj,idmom){

var descriptionTraining= $("#pesanndee").val();

		var act = "update";
		var modul= "meeting";	

 $.post("process.php", {act: act , modul: modul,idproj:idproj,idmom:idmom,descriptionTraining:descriptionTraining } , function(html) {
			$('.document').html(html);
			$(".document").hide();
			$(".document").fadeIn(400);});	
			
	
	}	
	
function dellTraining(idTraining){

if (confirm('Are you sure you want to dell ?')) {
var act = "dell";

	fung_Training(idTraining,act,0,0,0,0,0,0,0,0,0);
}
}

function updateStatusTraining(idTraining){


}

//end script training

//start cost

function fung_Cost(idCost,act,nameCost,tanggal,cost,currency,tipeKegiatandd,idKegiatan,realization,descriptionCost,modul){


	

	$.post("process.php", { act: act , modul: modul, idCost:idCost,nameCost:nameCost , tanggal:tanggal , cost:cost,currency:currency,tipeKegiatandd:tipeKegiatandd,idKegiatan:idKegiatan ,realization:realization,descriptionCost:descriptionCost } , function(html) {
			$('.cost').html(html);
			$(".cost").hide();
			$(".cost").fadeIn(400);});

}

function addCost(){

var nameCost=document.getElementById('nameCost').value;
var tanggal= document.getElementById('tanggalan').value;
var nilaicost= document.getElementById('jmlcost').value;
var currency= document.getElementById('form-field-select-1').value;
var tipekegiatanss= document.getElementById('tipekegiatan').value;
var idKegiatan= document.getElementById('idKegiatan').value;
var realization= document.getElementById('realization').value;
var descriptionCost= document.getElementById('form-field-22').value;


	
	var act = "add";
	var modul= "cost";
	var idCost=0 ;
	
	fung_Cost(idCost,act,nameCost,tanggal,nilaicost,currency,tipekegiatanss,idKegiatan,realization,descriptionCost,modul);
}

function dellCost(idCost){

	var act = "dell";
	var modul= "cost";
	
fung_Cost(idCost,act,"","","",0,0,0,0,0,modul);
}

function addCostobj(){

var nameCost=document.getElementById('nameCost').value;
var tanggal= document.getElementById('tanggalan').value;
var nilaicost= document.getElementById('jmlcost').value;
var currency= document.getElementById('form-field-select-1').value;
var tipeKegiatan= document.getElementById('tipekegiatan').value;
var idKegiatan= document.getElementById('idKegiatan').value;
var realization= document.getElementById('realization').value;
var descriptionCost= document.getElementById('form-field-22').value;


	
	var act = "add";
	var modul= "costobj";
	var idCost=0 ;
	fung_Cost(idCost,act,nameCost,tanggal,nilaicost,currency,tipeKegiatan,idKegiatan,realization,descriptionCost,modul);
}


function clearFrom(){

	var elements = document.getElementsByTagName("input");
	for (var ii=0; ii < elements.length; ii++) {
	  if (elements[ii].type == "text") {
		elements[ii].value = "";
	  }
	}
}


//getprojectTrainingdkk

function suggest(inputString,code,point){

var module="queryprojectdll" ;

		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
			jQuery('.suggestionList').fadeOut();
		} else {
		$('#country').addClass('load');

			$.post("sugestProc.php", {queryString: ""+inputString+"" , module:module}, function(data){
				
				if(data.length >0) {
				//alert(data.length);
					jQuery('#suggestions').fadeIn('slow');
					jQuery('.suggestionList').fadeIn('slow');
					jQuery('#suggestionsList').html(data);
					jQuery('#country').removeClass('load');
				}
			});
		}
	}

function suggestproj(inputString,code,point){

var topic=document.getElementById('topicElement').value;

if (topic==3){
var module="queryproject" ;
}else{
var module="queryprojectdll" ;
}

		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
			jQuery('.suggestionList').fadeOut();
		} else {
		$('#country').addClass('load');

			$.post("sugestProc.php", {queryString: ""+inputString+"" , module:module}, function(data){
				
				if(data.length >0) {
				//alert(data.length);
					jQuery('#suggestions').fadeIn('slow');
					jQuery('.suggestionList').fadeIn('slow');
					jQuery('#suggestionsList').html(data);
					jQuery('#country').removeClass('load');
				}
			});
		}
	}	

	function fill(thisValue , nilai2 ,nilaii ) {
	if (typeof thisValue != 'undefined') {
 

		
		append(nilai2,nilaii,thisValue);
		jQuery('.suggestionList').fadeOut('slow');

		
		
		
	}else {
	document.getElementById('textfield3').value='';
		
		
		setTimeout("$('#suggestionList').fadeOut();", 600);
		
		}
	
	}
	
	function append(thisValue,nilaii,tipekegiatan)
         {
		 
		  document.getElementById('idKegiatan').value=nilaii;  
		  document.getElementById('textfield').value=thisValue;
		  document.getElementById('tipekegiatan').value=tipekegiatan;
		  
		  
		  
		 
		 }

//End getprojectTrainingdkk

//start task 

function fung_Task(idTask,act,todo,tipeKegiatan,idKegiatan,description,tanggalan){


	var modul= "task";
	
	$.post("process.php", { act: act , modul: modul, idTask:idTask,todo:todo,tipeKegiatan:tipeKegiatan,idKegiatan:idKegiatan,description:description,tanggalan:tanggalan } , function(html) {
			$('.task').html(html);
			$(".task").hide();
			$(".task").fadeIn(400);});

}

function dellTask(idTask){

if (confirm('Are you sure you want to dell ?')) {
var act = "dell";

fung_Task(idTask,act,0,0,0,0,0);

}

}

function addTask(){

var todo=document.getElementById('todo').value;
var tipeKegiatan= document.getElementById('tipekegiatan').value;
var idKegiatan= document.getElementById('idKegiatan').value;
var description= document.getElementById('form-field-22').value;
var tanggalan= document.getElementById('tanggalan').value;


	var act = "add";
	var idTask=0 ;
	
	fung_Task(idTask,act,todo,tipeKegiatan,idKegiatan,description,tanggalan);

}

function OnclicDoneTask(idTask){


	var act = "oneclickupdate";

var todo='' ;
var tipeKegiatan= ' ';
var idKegiatan= ' ';
var description= ' ';
var tanggalan= ' ';

	fung_Task(idTask,act,todo,tipeKegiatan,idKegiatan,description,tanggalan);
//refreshTask();
if (taskrefresh!=true){
taskrefresh=true;	
setTimeout(function(){refreshTask();},5000)
}
}

function refreshTask(){

var act = "refreshTask";
var modul = "task";

$.post("process.php", { act: act , modul: modul } , function(html) {
			$('.taskrefresh').html(html);
			$(".taskrefresh").hide();
			$(".taskrefresh").fadeIn(400);});
			setTimeout(function(){getTaskNotification();},1500)

taskrefresh=false;			
}


function refreshNotification(){


var act = "refreshNotifi";
var modul = "notification";

if (notifrefresh!=true){
notifrefresh=true;	
$.post("process.php", { act: act , modul: modul } , function(html) {
			$('.refreshnoti').html(html);
			$(".refreshnoti").hide();
			$(".refreshnoti").fadeIn(400);});
			setTimeout(function(){badgeNotif();},1500)

			}
	}		

function badgeNotif(){

var act = "refreshbadgeNotifi";
var modul = "notification";

$.post("process.php", { act: act , modul: modul } , function(html) {
			$('.badgeNotif').html(html);
			$(".badgeNotif").hide();
			$(".badgeNotif").fadeIn(400);});
notifrefresh=false;	
}


function getTaskNotification(){

var act = "getTaskNotification";
var modul = "task";

$.post("process.php", { act: act , modul: modul } , function(html) {
			$('.classNotif').html(html);
			$(".classNotif").hide();
			$(".classNotif").fadeIn(400);});


}

//galery

function galery(idgaleri,act,nama){

var modul= "galery";
	
	$.post("process.php", { act: act , modul: modul, idgaleri:idgaleri,nama:nama } , function(html) {
			$('.refreshgalery').html(html);
			$(".refreshgalery").hide();
			$(".refreshgalery").fadeIn(400);});

}

function Delgalery(idgaleri){

var act ="del";
var nama ="" ;
if (confirm('Are you sure you want to dell ?')) {
galery(idgaleri,act,nama);
}
}

function updateGalery(){
var act ="update";

var idgaleri= document.getElementById('idPicture').value;
var nama= document.getElementById('namaPicture').value;

galery(idgaleri,act,nama);

}

function changeModalGalery(idgaleri,nama){

document.getElementById('namaPicture').value=nama;  
document.getElementById('idPicture').value=idgaleri;  

}


function documentt(iddocument,act,nama){
var modul= "document";
	
	$.post("process.php", { act: act , modul: modul, iddocument:iddocument,nama:nama } , function(html) {
			$('.document').html(html);
			$(".document").hide();
			$(".document").fadeIn(400);});
}

function Deldocument(iddocument){

var act ="del";
var nama ="" ;

documentt(iddocument,act,nama);

}

function updatedocument(){
var act ="update";

var idgaleri= document.getElementById('iddocument').value;
var nama= document.getElementById('namadocument').value;

documentt(idgaleri,act,nama);

}

function changeModalDocument(idgaleri,nama){

document.getElementById('namadocument').value=nama;  
document.getElementById('iddocument').value=idgaleri;  

}



//rulepub start

function rulepublic(tipe,act,alll,ids,status){

var modul= "rules_pub";

$.post("process.php", { tipe: tipe , modul: modul, act:act, alll:alll,ids:ids, status:status } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});

}


function load_rulepub(){
	
	var tipe  =$("input[type=radio]:checked").val();
	
	
	var name_element = document.getElementById('cekall');

    if (name_element.checked == true){
		var alll = "alll" ;
		
		}else { var alll = "noo" ;} 

var act="rules_pub";
var ids=0;	
	
	rulepublic(tipe,act,alll,ids,status) ;

}
function load_rulepub_umum(){
	
	var tipe  =$("input[type=radio]:checked").val();
	
		
	var alll = "noo" ;

	var act= "rules_pub";
	
	rulepublic(tipe,act,alll,ids,status) ;

}
function Update_status(id,status){
	
	var ids=id ;
	var status=status;


	var act= "update_status";
	var tipe=""; 
	var alll="";
	
	rulepublic(tipe,act,alll,ids,status) ;

}

function dell_status(id){
	
	var ids=id ;


	var tipe=""; 
	var alll="";
	var act= "dell_status";
	
	rulepublic(tipe,act,alll,ids,status) ;

}

//rulepub end

//project

function addProject(){


var nokontract=document.getElementById('nokontract').value;
var Builder='';
//var Submited=document.getElementById('Submited').value;

var projectname=document.getElementById('projectname').value;
var classno='';

var start=document.getElementById('start').value;
var due=document.getElementById('due').value;
var tipe='';
var particpanTraining='';
var pm =document.getElementById('leader').value;
var locationv= '';
var Submited= document.getElementById('Submited').value;

/* var e = document.getElementById("team");	
		
for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
		
		particpanTraining= particpanTraining + "," + e.options[i].value  ;
    }
} */

var modul='createproject' ;
var act ='add' ;


$.post("process.php", { projectname: projectname , modul: modul, act:act, classno:classno, start:start ,due:due ,tipe:tipe, particpanTraining:particpanTraining,locationv:locationv,nokontract:nokontract,Builder:Builder,Submited:Submited,pm:pm } , function(html) {
			$('.project').html(html);
			$(".project").hide();
			$(".project").fadeIn(400);});

}


function updateProjectt(idproj){


var projectname=document.getElementById('projectname').value;
var target=document.getElementById('target').value;
var nokontract=document.getElementById('contract').value;
var start=document.getElementById('start').value;
var due=document.getElementById('due').value;
var tipe='';
var classno=document.getElementById('classid').value;
var locationv=document.getElementById('locationproj').value;
var Builder=document.getElementById('builderproj').value;
var Submited=document.getElementById('submiterpro').value;
var kontractlink=document.getElementById('kontractlink').value;
var sistercontract = document.getElementById('sistercontract').value;

var particpanTraining='';
var descriptionTraining= document.getElementById('form-field-22').value;

var e = document.getElementById("team");	
		
for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
		
		particpanTraining= particpanTraining + "," + e.options[i].value  ;
    }
}

var modul='createproject' ;
var act ='update' ;



 $.post("process.php", { projectname: projectname ,idproj:idproj, modul: modul, act:act, target:target,nokontract:nokontract, start:start ,due:due ,tipe:tipe, particpanTraining:particpanTraining,descriptionTraining:descriptionTraining,classno:classno,locationv:locationv,Builder:Builder,Submited:Submited,kontractlink:kontractlink,sistercontract:sistercontract } , function(html) {
			$('.project1').html(html);
			$(".project1").hide();
			$(".project1").fadeIn(400);});

}

function notes_obj(idProject ,  act, pesan,captionmessage, listsubscriber){

var modul='notes_obj' ;

$.post("process.php", { idProject: idProject , modul: modul, act:act, pesan:pesan,captionmessage:captionmessage, listsubscriber:listsubscriber  } , function(html) {
			$('.noteslist').html(html);
			$(".noteslist").hide();
			$(".noteslist").fadeIn(400);});

document.getElementById('listsubscriber').value='';
}

function Addnotes_obj(){

var captionmessage=document.getElementById('captionmessage').value;
var pesan= $("#pesan").val();
var idProject=document.getElementById('idProject').value;
var listsubcriber=document.getElementById('listsubscriber').value;

var act='add' ;

notes_obj(idProject ,  act, pesan,captionmessage, listsubcriber);

document.getElementById('pesan').value='';
document.getElementById('captionmessage').value='';
slideAddnoted();
}

function updatenotes_obj(idProject){

var captionmessage=document.getElementById('captionmessage').value;
var pesan= CKEDITOR.instances.pesannn.getData();


var modul='notes_objPagedetail' ;

var act='update' ;

$.post("process.php", { idProject: idProject , modul: modul, act:act, pesan:pesan,captionmessage:captionmessage } , function(html) {
			$('.messageText').html(html);
			$(".messageText").hide();
			$(".messageText").fadeIn(400);});
			



slideAddnoted();
}

function saveSubscribertemp(){

var particpanTraining='';

var e = document.getElementById("subscriber");	
		
for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
			particpanTraining= particpanTraining + "," + e.options[i].value  ;
		
		
    }
}

document.getElementById('listsubscriber').value=particpanTraining;


}

function updateSubscriber(objctnumber){

var particpanTraining='';

var e = document.getElementById("subscriber");	
		
for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
			particpanTraining= particpanTraining + "," + e.options[i].value  ;
		
		
    }
}


var modul='updateSubscriber' ;
var act='refresh';

$.post("process.php", { objctnumber: objctnumber , modul: modul, act:act, particpanTraining:particpanTraining } , function(html) {
			$('.alistsubscriber').html(html);
			$(".alistsubscriber").hide();
			$(".alistsubscriber").fadeIn(400);});
			




}

function changeclassactiveTab(classname){

$("#" + classname).addClass( "active" );
$("#taboverview").removeClass( "active" );
}

function commentobj(act,objctnumber,message){


var modul='commentobj' ;

$.post("process.php", { objctnumber: objctnumber , modul: modul, act:act, message:message } , function(html) {
			$('.commenting').html(html);
			$(".commenting").hide();
			$(".commenting").fadeIn(400);});
}

function Addcomentobj(objctnumber){

var message=document.getElementById('messageComment').value;

var act='add' ;
if (message!=""){
commentobj(act,objctnumber,message);

document.getElementById('messageComment').value='';
}else{
alert("Please Fill the comment");
}

}

function movetotrash(objectid){



if (confirm('Are you sure you want to save this thing into the database?')) {
var modul='movetotrash' ;
var act='moveTotrash';

    $.post("process.php", { objectid: objectid , modul: modul, act:act } , function(html) {
			$('.messageText').html(html);
			$(".messageText").hide();
			$(".messageText").fadeIn(400);});
} 



}

function setobjectidcomenfile(idobject){

document.getElementById('objectidcomenfile').value=idobject;

}

function updateCommentrevision(objectFile){

var objectid=document.getElementById('objectidcomenfile').value;

var filecommentt=document.getElementById('filecommentt').value;


var modul='updatefile' ;
var act='updatecommentfile';


    $.post("process.php", { objectFile:objectFile ,objectid: objectid , modul: modul, act:act , filecommentt:filecommentt } , function(html) {
			$('.revison').html(html);
			$(".revison").hide();
			$(".revison").fadeIn(400);});
}

function addTaskobj(projectid){


var tasktitle=document.getElementById('tasktitle').value;
var starttask=document.getElementById('starttask').value;
var endtask=document.getElementById('endtask').value;
var asigmentto=document.getElementById('asigmentto').value;
var listsubcriber=document.getElementById('listsubscriber').value;
var pesan= $("#describtask").val();
var modul='taskobj' ;
var act='add';





$.post("process.php", { projectid:projectid ,pesan: pesan , modul: modul, act:act , listsubcriber:listsubcriber , tasktitle:tasktitle ,starttask:starttask,endtask:endtask,asigmentto:asigmentto,  } , function(html) {
			 $('.listTasklist').html(html);
			 $(".listTasklist").hide();
			 $(".listTasklist").fadeIn(400);});

document.getElementById('listsubscriber').value='';
			 
}

function addexpressTaskobj(projectid){


var tasktitle=document.getElementById('ExpresstaskName').value;
var endtask=document.getElementById('Expressdue').value;
var asigmentto=document.getElementById('ExpresAssigmentto').value;


var modul='taskobj' ;
var act='addExpress';




if ((tasktitle !="") && (endtask !="") && (asigmentto!="") ){


$.post("process.php", { projectid:projectid , modul: modul, act:act  , tasktitle:tasktitle ,endtask:endtask,asigmentto:asigmentto } , function(html) {
			 $('.latetask').html(html);
			 $(".latetask").hide();
			 $(".latetask").fadeIn(400);}); 

			 document.getElementById('ExpresstaskName').value='';
			 document.getElementById('Expressdue').value='';

			 }			 

}

function updateprogresstaskobj(objectid){

var modul='taskobj' ;
var act='progress';
var idprogresstask=document.getElementById('idprogresstask').value;

if (isNaN(idprogresstask)) 
  {
    alert("Must input numbers");

  }else {
  
  if ((idprogresstask>0) && (idprogresstask < 101)){

$.post("process.php", { objectid:objectid ,idprogresstask: idprogresstask , modul: modul, act:act } , function(html) {
			 $('.mainwindow').html(html);
			 $(".mainwindow").hide();
			 $(".mainwindow").fadeIn(400);});

		}else {
		
		   alert("Input must be range on 0 to 100");
		
		}

}
		
}


function Showmmessagee(mid){

var act='show' ;

message(act,mid,"",'');

}

function deletedMessage(mid){

var act='deleted' ;

message(act,mid,"",'');
}

function ReplayMessgae(mid){

var act='replay' ;
var body = document.getElementById('textreplay').value;
message(act,mid,body,'');

document.getElementById('textreplay').value='';
}

function ComposesMessage(){

var act='postMessage' ;
var uids = document.getElementById('listsubscriber').value;
var body = document.getElementById('Pesaanan').value;

message(act,0,body,uids);

}

function message(act,mid,body,uids){


var modul='message' ;

$.post("process.php", { mid:mid , modul: modul, act:act,body:body,uids:uids } , function(html) {
			 $('.messagelist').html(html);
			 $(".messagelist").hide();
			 $(".messagelist").fadeIn(400);});


}

function downloadAszip(){

var nama="file.zip";
var act ="assd";
makearship(nama,act);

}

function makearship(nama,act){


    var rows = document.getElementsByName('checkbox[]');
    var selectedRows = [];
	var testring='';
	var jmlcentang = 0 ;


    for (var i = 0, l = rows.length; i < l; i++) {
        if (rows[i].checked) {
            selectedRows.push(rows[i]);
			testring=testring + ',' + rows[i].value;
			jmlcentang=jmlcentang + 1;
        }
    }
	
if 	(jmlcentang > 1 ){
	
	var modul='makearchip' ;

	

 $.post("process.php", { nama:nama , modul: modul, act:act,testring:testring} , function(html) {
			 $('.macamMacam').html(html);
			 $(".macamMacam").hide();
			 $(".macamMacam").fadeIn(400);}); 

	}else {
	
	 alert('select more than 1 file');
	
	}



} 
function writeDocu(act,subscr,idKegiatans,ext,dataFile,iddocument,nama){

var modul= "documentproj";


	
	$.post("process.php", {ext:ext, dataFile:dataFile, idKegiatans:idKegiatans, act: act , modul: modul, iddocument:iddocument,nama:nama ,subscr:subscr} , function(html) {
			$('.document').html(html);
			$(".document").hide();
			$(".document").fadeIn(400);});

}

function WDoc(){
var act= "WriteDocument";
var subscr=document.getElementById('listsubscriber').value;
var idKegiatans=document.getElementById('idKegiatans').value;
var nama = document.getElementById('WordFilename').value;
var dataFile=$("#dataFileDoc").val();
var ext="html";
var iddocument =0;


writeDocu(act,subscr,idKegiatans,ext,dataFile,iddocument,nama);
slideAddDocument();
}

function upDocu(act,ext,dataFile,idKegiatansnnn,idobject,comment){

var modul= "updatefile";
	$.post("process.php", {ext:ext, dataFile:dataFile, idKegiatansnnn:idKegiatansnnn, act: act , modul: modul, idobject:idobject,comment:comment } , function(html) {
			$('.revison').html(html);
			$(".revison").hide();
			$(".revison").fadeIn(400);});

}

function UpdateDocu(){

var act= "updateDocFile";
var ext="html";

var idKegiatansnnn=document.getElementById('idKegiatansnnn').value;
var idobject=document.getElementById('idobject').value;
var comment = prompt("Please leave the comment");
var dataFile= CKEDITOR.instances.datafileword.getData();


if (comment != null) {

upDocu(act,ext,dataFile,idKegiatansnnn,idobject,comment);
}

slideEditDocument();
setTimeout(function(){refreshMessage();},1000)
}

function refreshMessage(){
var idobject=document.getElementById('idobject').value;
var modul= "updatefile";
var act= "refreshMessagetext";
	$.post("process.php", {  act: act , modul: modul, idobject:idobject } , function(html) {
			$('.messageText').html(html);
			$(".messageText").hide();
			$(".messageText").fadeIn(400);});

}

function Slideshow(content){

 var dataContend=unescapeSLIM(content);
	var top = screen.height * 0.1;
	var left = screen.width * 0.1;
	var width = screen.width * 0.8;
	var height = screen.height * 0.8;
	window.slimContent = dataContend ;

	window.open('../plugin/slimey_0.2/slime.html', 'slimePreview', 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height + ',status=no,menubar=no,location=no,toolbar=no,scrollbars=no,directories=no,resizable=yes')



}

function editSlideshow(content){


	var top = screen.height * 0.1;
	var left = screen.width * 0.1;
	var width = screen.width * 0.8;
	var height = screen.height * 0.8;


	window.open('editSlime.php?id=' + content , 'SlideShow Editor', 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height + ',status=no,menubar=no,location=no,toolbar=no,scrollbars=no,directories=no,resizable=yes')



}

function escapeSLIM(rawSLIM) {
	return encodeURIComponent(rawSLIM);
}

/**
 *  unescapes the &, <, >, " and ' characters from an escaped SLIM string
 */
function unescapeSLIM(encodedSLIM) {
	return decodeURIComponent(encodedSLIM);
}

function markNotificationRead(id){
	
	var act='refreshlist';
	var strurl = act + "#" ;
	//alert(strurl);
		//getRequest("isiinputdrawing"," ","insertDrawing",strurl);	
		PosttRequest("nilaibaliknotif","MarknotifReadAll","process",strurl);
			
}

function PosttRequest(nameClass,modul,page,stringCommand){
	
	$.post( page + ".php", {modul:modul,stringCommand:stringCommand} , function(html) {
			$('.' + nameClass ).html(html);
			$("." + nameClass).hide();
			$("." + nameClass).fadeIn(400);});
	
}


function updateProjectquery(idproj){

var vesselname=document.getElementById('vesselname').value;
var bkiid=document.getElementById('bkiid').value;
var bkidesaindid=document.getElementById('bkidesaindid').value;
var imo=document.getElementById('imo').value;
var operationstat=document.getElementById('operationstat').value;
var flag=document.getElementById('flag').value;
var port=document.getElementById('port').value;
var owner=document.getElementById('owner').value;
var manager=document.getElementById('manager').value;
var rulesset=document.getElementById('rulesset').value;
var ruleedision=document.getElementById('ruleedision').value;
var type=document.getElementById('type').value;
var builder=document.getElementById('builder').value;
var hullyard=document.getElementById('hullyard').value;
var outfittingyard=document.getElementById('outfittingyard').value;
var keellaid=document.getElementById('keellaid').value;
var launchdate=document.getElementById('launchdate').value;
var dateofbuild=document.getElementById('dateofbuild').value;
var deliverydate=document.getElementById('deliverydate').value;
var loa=document.getElementById('loa').value;
var lbp=document.getElementById('lbp').value;
var lload=document.getElementById('lload').value;
var bext=document.getElementById('bext').value;
var b=document.getElementById('b').value;
var d=document.getElementById('d').value;
var draught=document.getElementById('draught').value;
var freeboard=document.getElementById('freeboard').value;

var elem = document.getElementsByName('notation-field');
var classnotation = "";
for(i=0; i<elem.length; i++)
{
	classnotation = classnotation + ";" + elem[i].value;
}
classnotation = classnotation.substr(1);

var modul='administratif' ;
var act ='updateProjectquery' ;
var strurl = act + "#" + idproj + "#" + vesselname + "#" + bkiid + "#"+ bkidesaindid + "#"+ imo + "#"+ operationstat + "#"+ flag + "#"+ port + "#"+ owner + "#" + manager + "#"+ rulesset + "#"+ ruleedision + "#" + classnotation + "#" + type + "#"+ builder + "#"+ hullyard + "#"+ outfittingyard + "#" + keellaid + "#" + launchdate + "#"+ dateofbuild + "#"+ deliverydate + "#"+ loa + "#"+ lbp + "#" + lload + "#"+ bext + "#"+ b + "#"+ d + "#"+ draught + "#"+ freeboard + "#";

//alert(classnotation);

PosttRequest("project1",modul,"process-ogs",strurl);



}

