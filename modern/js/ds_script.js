function pageDatabaseExpert(){
$("#kasus_prop").change(function()
		{
		var dataString = 'Nama='+ $(this).val();
		
	if ($(this).val() !=""){
		fung_add($(this).val(),'caseProperty','CA');
		}
		
	});

	$(".SP").change(function()
	{
		var txt= this.options[this.selectedIndex].text;
		var dataString = $(this).val()+"#"+$("#kasus_prop").val() + "#" + txt;
		
		
		fung_add(dataString,'specifick','specipik');
		
	
	});


	$('.CA').change(function(){									   
		var dataString = $(this).val()+"#"+$("#kasus_prop").val();
		fung_add(dataString,'CauseArea','SP');
		
	
	});


	$('.specipik').change(function(){									   
		var dataString = $(this).val()+"#"+$("#kasus_prop").val();
		//alert(dataString);
		fung_add(dataString,'MoreSpecific','damages');
		
		
	});
	
				//Program a custom submit function for the form
			$("form#expert").submit(function(event){
			 
			  //disable the default form submission
			  event.preventDefault();
			 
			  //grab all form data  
			  var formData = new FormData($(this)[0]);
			 
			  $.ajax({
				url: 'dsproc.php',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (html) {
			$('.training').html(html);
			$(".training").hide();
			$(".training").fadeIn(400);}
			  });
			 
			  return false;
			});
	
}
	
function fung_add(data,mode,clas){

	var module= "loadCombo";

	$.post("dsproc.php", { modul:module, mod:mode,Nama:data ,clas:clas} , function(html) {
			$('.'+ clas).html(html);
			$('.'+ clas).hide();
			$('.' + clas).fadeIn(400);
			
			
			});

}


function addExpert(){
			 document.body.style.cursor = 'wait';
/* var kasus_prop = $("#kasus_prop").val() ; 
var CA = $("#CA").val() ; 
var SP = $("#SP").val() ; 
var specipik = $("#specipik").val() ; 
var damages = $("#damages").val() ; 

var sourceClass = $("#sourceClass").val() ; 
var kojek = $("#kojek").val() ; 
var casename=document.getElementById('casename').value;

var bkicorel=document.getElementById('bkicorel').value;
var howbecome= $("#pesanndee").val();
var countermes= $("#countermeasure").val();
var modul="addexpert" ; */

			//Program a custom submit function for the form
			$("form#expert").submit(function(event){
			 
			  //disable the default form submission
			  event.preventDefault();
			 
			  //grab all form data  
			  var formData = new FormData($(this)[0]);

			  $.ajax({
				url: 'dsproc.php',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (html) {
			$('.training').html(html);
			$(".training").hide();
			$(".training").fadeIn(400);}
			  });
			 
			  return false;
			});

}

function dellExpert(exID){

var exID = exID;

if (confirm('Are you sure you want to dell ?')) {
	document.body.style.cursor = 'wait';
	var act = "del";
	var modul="addexpert" ;
	
		$.post("dsproc.php", { modul:modul, exID:exID, act:act} , function(html) {
			$('.training').html(html);
			$('.training').hide();
			$('.training').fadeIn(400); });

	}


}

function dellDamageStat(exID){
var exID = exID;

if (confirm('Are you sure you want to dell ?')) {
	document.body.style.cursor = 'wait';
	var act = "del";
	var modul="damageStatitik" ;
	
		$.post("dsproc.php", { modul:modul, exID:exID, act:act} , function(html) {
			$('.training').html(html);
			$('.training').hide();
			$('.training').fadeIn(400); });

	}
	
}	

