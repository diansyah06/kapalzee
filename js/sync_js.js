function Sync_teliksandi(){
	
	var modul= "telik";
	var act = "add";
	
	$.post("synk/sinx_tel.php", { act: act , modul: modul } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}

function load_rulepub(){
	
	var tipe  =$("input[type=radio]:checked").val();
	
	
	var name_element = document.getElementById('cekall');

    if (name_element.checked == true){
		var alll = "alll" ;
		
		}else { var alll = "noo" ;} 

	var modul= "rules_pub";
	
	$.post("rules/show_rule_pub.php", { tipe: tipe , modul: modul, alll:alll } , function(html) {
			$('.rulesspub').html(html);
			$(".rulesspub").hide();
			$(".rulesspub").fadeIn(400);});

}

function load_rulepubaaaa(){
	
	var tipe  =$("input[type=radio]:checked").val();
	
	
	var name_element = document.getElementById('cekall');

    if (name_element.checked == true){
		var alll = "alll" ;
		
		}else { var alll = "noo" ;} 

	var modul= "rules_pub";
	
	$.post("rules/show_rulepub_synk.php", { tipe: tipe , modul: modul, alll:alll } , function(html) {
			$('.rulesspub').html(html);
			$(".rulesspub").hide();
			$(".rulesspub").fadeIn(400);});

}


function load_rulepub_umum(){
	
	var tipe  =$("input[type=radio]:checked").val();

	var alll = "noo" ;

	var modul= "rules_pub";
	
	$.post("rules/show_rule_pub.php", { tipe: tipe , modul: modul, alll:alll } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});

}

function add_corigenda_to(id){
	var modul= "add_corigenda";
	var id = id ;
	


	$.post("synk/proc_sync.php", { modul: modul , id: id } , function(html) {
			$('.ruless_dist').html(html);
			$(".ruless_dist").hide();
			$(".ruless_dist").fadeIn(400);});

}

function dell_ditributiion_list(id){
	var modul= "dell_ditributiion_list";
	var id = id ;
	


	$.post("synk/proc_sync.php", { modul: modul , id: id } , function(html) {
			$('.ruless_dist').html(html);
			$(".ruless_dist").hide();
			$(".ruless_dist").fadeIn(400);});

}

function show_update_name(nama,id_coment){

	document.getElementById('id_diar').value='';
	
	document.getElementById('namarules').value=nama;
		popup();
document.getElementById('id_diar').value=id_coment;
		
}

function popup() {

		$( "#dialog" ).dialog({

				autoOpen: true,
				height: 180,
				width: 700,
				show: "blind",
				hide: "fadeout"

		});
	}
	
function update_name_ditributiion_list(){
	var modul= "update_name_ditributiion_list";
	
	var name_element = document.getElementById('namarules');
	var nama = name_element.value ;
	
	
		var name_element = document.getElementById('id_diar');
	var id = name_element.value;
	


	$.post("synk/proc_sync.php", { modul: modul , id: id, nama:nama } , function(html) {
			$('.ruless_dist').html(html);
			$(".ruless_dist").hide();
			$(".ruless_dist").fadeIn(400);});
	$("#dialog").dialog( "close" );		

}	


function add_rules_to(id){
	var modul= "add_rules_to";
	var id = id ;
	


	$.post("synk/proc_sync.php", { modul: modul , id: id } , function(html) {
			$('.ruless_dist').html(html);
			$(".ruless_dist").hide();
			$(".ruless_dist").fadeIn(400);});

}

function createxml(){
	var modul= "create_xml";

	


	$.post("synk/proc_sync.php", { modul: modul  } , function(html) {
			$('.ruless_dist').html(html);
			$(".ruless_dist").hide();
			$(".ruless_dist").fadeIn(400);});

}

function createhash(hash){
	var hash= hash;

	


	$.post("http://202.152.52.206:16700/hash.php", { has: hash  } , function(html) {
			$('.hash').html(html);
			$(".hash").hide();
			$(".hash").fadeIn(400);});
	
	alert ('packet send');

}