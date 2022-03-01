function tableiNvest(){

        var oTable = $('#sample_2').dataTable({
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
        $('#sample_2_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        // modify table search input
        $('#sample_2_wrapper .dataTables_length select').addClass("m-wrap small");
        // modify table per page dropdown
        $('#sample_2_wrapper .dataTables_length select').select2();
        // initialzie select2 dropdown
        $('#sample_2_column_toggler input[type="checkbox"]').change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
 
}
function FuncAjaxRequest(page , nameClass,modul,stringCommand,richtext1,richtext2){
	
	$.post(page, {modul:modul, stringCommand:stringCommand,richtext1:richtext1,richtext2:richtext2} , function(html) {
			$('.' + nameClass ).html(html);
			$("." + nameClass).hide();
			$("." + nameClass).fadeIn(400);});
	
}

function AddPlanPeriode(){
	
	var Start= document.getElementById('start').value;
	var End= document.getElementById('due').value;
	var stringCommand= "add#" + Start + "#" + End ;
	var page="Process.php";
	
	if ((Start.trim()) || (End.trim()) )  {	// is empty or whitespace

	//alert (stringCommand);
	FuncAjaxRequest(page,"project","planPeriode",stringCommand," "," ");
	}
	
}

function DellPlanperiode(id){
	
	var stringCommand= "del#" + id ;
	var page="Process.php";
	
	FuncAjaxRequest(page,"project","planPeriode",stringCommand," "," ");	
}

function SetOnPlanPeriode(id){

	var stringCommand= "setOn#" + id ;
	var page="Process.php";
	
	FuncAjaxRequest(page,"project","planPeriode",stringCommand," "," ");			
}

function addAplan(){
	
var planName=document.getElementById('form-field-1').value;
var typeEvent=document.getElementById('form-field-select-3').value;
var TypeOftopic=document.getElementById('form-field-select-14').value;
var Schdule=document.getElementById('schedule').value;
var Participant="" ;
var adress=document.getElementById('location').value;
var country=document.getElementById('country').value;
var amount=document.getElementById('amount').value;
var curency=document.getElementById('form-field-select-2').value;
var kurs=document.getElementById('kurs').value;
var description=$("#pesanndee").val();

var e = document.getElementById("form-field-select-4");	
if (planName != ""){		
for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
		
		Participant= Participant + "," + e.options[i].value  ;
    }
}

	
	var stringCommand= "add#" + planName + "#" + typeEvent + "#" + TypeOftopic + "#" + Schdule + "#" + Participant + "#" + adress + "#" + country + "#" + amount + "#" + curency + "#" + kurs ;
	var page="Process.php";

	FuncAjaxRequest(page,"training","inserbudguet",stringCommand, description," ");			
	clearFrom();
}else {
	alert("Please fill the blank field");
	}	

}
function dellPlan(id){
	
	var stringCommand= "del#" + id ;
	var page="Process.php";
if (confirm('Are you sure you want to dell ?')) {	
	FuncAjaxRequest(page,"training","inserbudguet",stringCommand," "," ");	
}	
}


function addInvest(){

var Item=document.getElementById('invet_itemname').value;
var Type =document.getElementById('invet_type').value;
var anggaran=document.getElementById('invet_amount').value;
var Currency=document.getElementById('invet_curency').value;
var kurs =document.getElementById('invet_kurs').value;
var description=$("#pesanndede").val();




	var stringCommand= "add#" + Item  + "#" + Type  + "#" + anggaran  + "#" + Currency  + "#" + kurs ;
	var page="Process.php";
	
	if (Item != ""){		
		FuncAjaxRequest(page,"investasi","inserbudguetInvest",stringCommand,description," ");	
		//clearFrom();	
	}else {
		alert("Please fill the blank field");
		}	

}

function dellInvest(id){
	
	var stringCommand= "del#" + id ;
	var page="Process.php";
if (confirm('Are you sure you want to dell ?')) {	
	FuncAjaxRequest(page,"investasi","inserbudguetInvest",stringCommand," "," ");	
}	
	
}

function peoplechange(selectObj) {
   var selectIndex=selectObj.selectedIndex;
   var selectValue=selectObj.options[selectIndex].value;
   var output=document.getElementById("output");
   peopelechangeAjax(selectValue);
   //output.innerHTML=selectValue;
 }
function peopelechangeAjax(id){

	var stringCommand= "refresh#" + id ;
	var page="Process.php";
	//alert(id);
	FuncAjaxRequest(page,"peopleplan","GetPeoplePlan",stringCommand," "," ");	

}

function tambahCost(){

var nameCost=document.getElementById('nameCost').value;

var nilaicost= document.getElementById('jmlcost').value;
var currency= document.getElementById('form-field-select-1').value;
var tipekegiatanss= document.getElementById('tipekegiatan').value;
var InvestorEvent= getValueRadio('optionsRadios');
var idKegiatan= document.getElementById('idKegiatan').value;
var realization= document.getElementById('realization').value;
var kurs= document.getElementById('invet_kurs').value; 
var descriptionCost= $("#form-field-22").val();

	var stringCommand= "add#" + nameCost  + "#" + nilaicost  + "#" + currency  + "#" + kurs  + "#" + tipekegiatanss  + "#" + InvestorEvent  + "#" + idKegiatan  + "#" + realization;
	var page="Process.php";
	
	if (nameCost != ""){		
		
		//alert (descriptionCost);
		FuncAjaxRequest(page,"cost","cost",stringCommand,descriptionCost," ");	
		//clearFrom();	
	}else {
		alert("Please fill the blank field");
		}
		
}
 
function dellCosttt(id){
	
	var stringCommand= "dell#" + id ;
	var page="Process.php";
	if (confirm('Are you sure you want to dell ?')) {	
		FuncAjaxRequest(page,"cost","cost",stringCommand," "," ");	
	}
}
function refreshCosttt(id){
	
	var stringCommand= "refresh1#" + id ;
	var page="Process.php";
	
		FuncAjaxRequest(page,"cost","cost",stringCommand," "," ");	

}
function refreshCostii(id){
	
	var stringCommand= "refresh2#" + id ;
	var page="Process.php";
	
		FuncAjaxRequest(page,"cost","cost",stringCommand," "," ");	

}

function dellCostttii(id){
	
	var stringCommand= "del#" + id ;
	var page="Process.php";
	if (confirm('Are you sure you want to dell ?')) {	
		FuncAjaxRequest(page,"cost","cost",stringCommand," "," ");	
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

function suggestEvent(inputString){



		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
			jQuery('.suggestionList').fadeOut();
		} else {
		$('#country').addClass('load');

		var InvestEvent = getValueRadio('optionsRadios');
			
			if (InvestEvent==0){
				var module="queryTraining" ;	
			}else{
				//alert("sa");
				var module="queryInvest" ;	
			}	
			
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
	
	
function tambahbank(){

var inputan=document.getElementById('inputan').value;

var background= document.getElementById('background').value;
var Objective= document.getElementById('Objective').value;
var resource= document.getElementById('resource').value;

var mark= document.getElementById('mark').value;


	var stringCommand= "add#" + inputan  + "#" + background  + "#" + Objective  + "#" + resource  + "#" + mark  ;
	var page="Process.php";
	
	if (inputan != ""){		
		
		//alert (stringCommand);
		FuncAjaxRequest(page,"researchbank","researchbank",stringCommand," " ," ");	
		clearFrom();	
	}else {
		alert("Please fill the blank field");
		}
		
}
 
function dellbank(id){
	
	var stringCommand= "dell#" + id ;
	var page="Process.php";
	if (confirm('Are you sure you want to dell ?')) {	
		FuncAjaxRequest(page,"researchbank","researchbank",stringCommand," "," ");	
	}
}

function tambahPlanResearch(){

var title=document.getElementById('title').value;

var objectiveplan= document.getElementById('objectiveplan').value;
var typeplan= document.getElementById('typeplan').value;
var costplan= document.getElementById('costplan').value;
var resourceplan= document.getElementById('resourceplan').value;
var periodeplan= document.getElementById('periodeplan').value;
var prioritiplan= document.getElementById('prioritiplan').value;

var descripplan= document.getElementById('descripplan').value;
var Participant = "" ;
var e = document.getElementById("penelitiplan");	

for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
		
		Participant= Participant + "," + e.options[i].value  ;
    }
}


	var stringCommand= "add#" + title  + "#" + objectiveplan + "#" + typeplan  + "#" + costplan + "#" + Participant + "#" + resourceplan  + "#" + periodeplan + "#" + prioritiplan + "#" + descripplan   ;
	var page="Process.php";
	
	if (title != ""){		
		
		//alert (stringCommand);
		FuncAjaxRequest(page,"planresearch","planresearch",stringCommand," " ," ");	
		clearFrom();	
	}else {
		alert("Please fill the blank field");
		}
		
}
 
function dellplanresearch(id){
	
	var stringCommand= "dell#" + id ;
	var page="Process.php";
	if (confirm('Are you sure you want to dell ?')) {	
		FuncAjaxRequest(page,"planresearch","planresearch",stringCommand," "," ");	
	}
}


function tambahResultResearch(){

var titleresult=document.getElementById('titleresult').value;

var result_result= document.getElementById('result_result').value;
var typeresult= document.getElementById('typeresult').value;


var perioderesult= document.getElementById('perioderesult').value;
var followupresult= document.getElementById('followupresult').value;

var descriptionresult= document.getElementById('descriptionresult').value;

var Participant = "" ;
var e = document.getElementById("Resecher");	

for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
		
		Participant= Participant + "," + e.options[i].value  ;
    }
}


	var stringCommand= "add#" + titleresult  + "#" + result_result + "#" + typeresult   + "#" + Participant  + "#" + perioderesult + "#" + followupresult + "#" + descriptionresult   ;
	var page="Process.php";
	
	if (titleresult != ""){		
		
		//alert (stringCommand);
		FuncAjaxRequest(page,"resultreserach","resultreserach",stringCommand," " ," ");	
		clearFrom();	
	}else {
		alert("Please fill the blank field");
		}
		
}
 
function dellResultresearch(id){
	
	var stringCommand= "dell#" + id ;
	var page="Process.php";
	if (confirm('Are you sure you want to dell ?')) {	
		FuncAjaxRequest(page,"resultreserach","resultreserach",stringCommand," "," ");	
	}
}


function tambahproposal(){

var title=document.getElementById('title').value;


var typeplan= document.getElementById('typeplan').value;
var costplan= document.getElementById('costplan').value;
var start= document.getElementById('start').value;
var due= document.getElementById('due').value;

var Participant = "" ;
var e = document.getElementById("penelitiplan");	

for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
		
		Participant= Participant + "," + e.options[i].value  ;
    }
}


	var stringCommand= "add#" + title  + "#" + typeplan  + "#" + costplan + "#" + Participant + "#" + start  + "#" + due    ;
	var page="Process.php";
	
	if (title != ""){		
		
		alert (stringCommand);
		FuncAjaxRequest(page,"proposalresearch","proposalresearch",stringCommand," " ," ");	
		clearFrom();	
	}else {
		alert("Please fill the blank field");
		}
		
}
 
function dellproposal(id){
	
	var stringCommand= "dell#" + id ;
	var page="Process.php";
	if (confirm('Are you sure you want to dell ?')) {	
		FuncAjaxRequest(page,"proposalresearch","proposalresearch",stringCommand," "," ");	
	}
}
function EditProposal(id){

var title=document.getElementById('title').value;


var typeplan= document.getElementById('typeplan').value;
var costplan= document.getElementById('costplan').value;
var start= document.getElementById('start').value;
var due= document.getElementById('due').value;

var Participant = "" ;
var e = document.getElementById("penelitiplan");	

for (i=0;i<e.options.length;i++) {
    if (e.options[i].selected) {
        
		
		Participant= Participant + "," + e.options[i].value  ;
    }
}


	var stringCommand= "edit#" + title  + "#" + typeplan  + "#" + costplan + "#" + Participant + "#" + start  + "#" + due + "#" + id   ;
	var page="Process.php";
	
	if (title != ""){		
		
		//alert (stringCommand);
		FuncAjaxRequest(page,"infoo","proposalresearch",stringCommand," " ," ");	
		//clearFrom();	
	}else {
		alert("Please fill the blank field");
		}
		
}

function Approveproposal(id){
	
	var stringCommand= "approve#" + id ;
	var page="Process.php";
	if (confirm('Are you sure  ?')) {	
		FuncAjaxRequest(page,"infoo","proposalresearch",stringCommand," "," ");	
	}
}

function Unapprovaeproposal(id){
	
	var stringCommand= "unapprove#" + id ;
	var page="Process.php";
	if (confirm('Are you sure  ?')) {	
		FuncAjaxRequest(page,"infoo","proposalresearch",stringCommand," "," ");	
	}
}
function addCommentproposal(id){

var title=document.getElementById('messageComment').value;

	var stringCommand= "addComment#" + title  + "#" + id     ;
	var page="Process.php";
	
	if (title != ""){		
		
		//alert (stringCommand);
		FuncAjaxRequest(page,"commenting","proposalresearch",stringCommand," " ," ");	
		
		document.getElementById('messageComment').value='';
	}else {
		alert("Please fill the blank field");
		}
		
}

function Sendbuzz(id){

var title=document.getElementById('buzz').value;

	var stringCommand= "buzz#" + title  + "#" + id     ;
	var page="Process.php";
	
	if (title != ""){		
		
		//alert (stringCommand);
		FuncAjaxRequest(page,"infoo","proposalresearch",stringCommand," " ," ");	
		
		document.getElementById('messageComment').value='';
	}else {
		alert("Please fill the blank field");
		}
		
}

//function to update user information
//made by rizky
//Update:
//1. 01/29/2018 --> initial (rizky)
function sendBio(event)
{
	var name = document.getElementById("firstname").value;
	var uID = document.getElementById("user-id").value;
	var pos = document.getElementById("position").value;
	var email = document.getElementById("email").value;
	var phone = document.getElementById("phone").value;
	var address = document.getElementById("city").value + "+" + document.getElementById("zipcode").value;
	var othermail = document.getElementById("othermail").value;
	var facebook = document.getElementById("facebook").value;
	var pass = document.getElementById("password").value;
	var passAgain = document.getElementById("password_again").value;
	var fileSelect = document.getElementById("file-select");
	
	var submitButton = document.getElementById("submit-button");
	var buttonContent = submitButton.innerHTML;
	
	var stringCommand = uID + "#" + name + "#" + pos + "#" + email + "#" + phone + "#" + address + "#" + othermail + "#" + facebook + "#" + passAgain;  
	
	var formData = new FormData();
	var files = fileSelect.files;
	
	event.preventDefault();
	submitButton.innerHTML = "Submitting...";
	
	for (var i = 0; i < files.length; i++) 
	{
		var file = files[i];
		
		// Add the file to the request.
		formData.append('chunks[]', file, file.name);
	}
	formData.append('modul', 'updateBio');
	formData.append('stringCommand', stringCommand);
	
	if(pass === passAgain)
	{
		$.ajax
		({
			type: "POST",
			url: "process.php",
			data: formData,
			processData: false,
			contentType: false,
			success: function(response)
			{
				alert(response);
				submitButton.innerHTML = buttonContent;
			},
			error: function(errResp)
			{
				console.log(errResp);
			}
			
		});
	}else
	{
		alert("Please check the inputted password");
		submitButton.innerHTML = buttonContent;
	}
}

