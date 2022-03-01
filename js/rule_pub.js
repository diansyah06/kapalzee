function load_rulepub(){
	
	var tipe  =$("input[type=radio]:checked").val();
	
	
	var name_element = document.getElementById('cekall');

    if (name_element.checked == true){
		var alll = "alll" ;
		
		}else { var alll = "noo" ;} 

	var modul= "rules_pub";
	
	$.post("rules/show_rule_pub.php", { tipe: tipe , modul: modul, alll:alll } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});

}

function Update_status(id,status){
	
	var ids=id ;
	var status=status;


	var modul= "update_status";
	
	$.post("rules/show_rule_pub.php", { ids: ids , modul: modul, status:status } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});

}

function dell_status(id){
	
	var ids=id ;



	var modul= "dell_status";
	
	$.post("rules/show_rule_pub.php", { ids: ids , modul: modul } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});

}