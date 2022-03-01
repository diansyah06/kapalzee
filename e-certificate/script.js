function fung_add(data,mode,clas,module){

	$.post("api.php", { modul:module, mod:mode,Nama:data ,clas:clas} , function(html) {
		$('.'+ clas).html(html);
		$('.'+ clas).hide();
		$('.' + clas).fadeIn(400);
	});

}

$(".departemen").change(function()
{
	var dataString = 'Nama='+ $(this).val();

	if ($(this).val() !=""){
		fung_add($(this).val(),'jenis','jenis','loadCombo');
	}

	$('.upload').val('');

});

$(".jenis").change(function()
{

	$('.upload').val('');

});


$('.upload').change(function(e){
	var fileName = e.target.files[0].name;
	var departemen= document.getElementById('departemen').value; 
	var jenis= document.getElementById('jenis').value; 
	var idnumber= document.getElementById('idnumber').value; 

	


	var payload = departemen + "#" +  jenis + "#" + idnumber + "#" ;

	fung_add(payload,'listuploadbulks','listuploadbulks','checkfileExist');

	//alert('The file' + payload  );
});




function delay(callback, ms) {
	var timer = 0;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timer);
		timer = setTimeout(function () {
			callback.apply(context, args);
		}, ms || 0);
	};
}



$(document).ready(function(){

	fung_add(0,'departemen','departemen','loadCombodepartemen');
	$('.upload').val('');
	$('.idnumber').val('');

	

	$('#idnumber').keyup(delay(function (e) {

		var departemenn= document.getElementById('departemen').value ;

		if ((this.value != "") && (departemenn !== "" )) {
			//alert(document.getElementById('departemen').value);

			$.get( "cekregister.php?noreg=" + this.value + "&departemen=" + departemenn , function( data ) {
				$( ".result" ).html( data );

				if (confirm('Data register yang anda masukan adalah register : ' + data + ' . Appakah sudah benar ?')) {
				  // Save it!
				  console.log('register sudah benar');
				} else {
				  // Do nothing!
				  console.log('menghapus nomer register input');
				  document.getElementById('idnumber').value="";

				}

			});

		}

	}, 500));

});


