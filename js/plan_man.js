function fung_add_plan(){
	
	var name_element = document.getElementById('textfield');
	var task = name_element.value;
	
	var name_element = document.getElementById('textfield2');
	var objective = name_element.value;
	
	var name_element = document.getElementById('date-picker');
	var due = name_element.value;
	
	var modul= "plan";
	var act = "add";
	
	$.post("lain32/plan_proc.php", { act: act , modul: modul, task:task , objective:objective , due:due } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}

function fung_dell_plan(id){
	

	var id = id;
	
	var modul= "plan";
	var act = "dell";
	
	$.post("lain32/plan_proc.php", { act: act , modul: modul, id:id } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}


function fung_lock_plan(id){
	

	var id = id;
	
	var modul= "plan";
	var act = "lock";
	
	$.post("lain32/plan_proc.php", { act: act , modul: modul, id:id } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}

function saveReason(id){
	var id = id;
	
	var modul= "plan";
	var act = "reason";
	
var reason = prompt("This Plan can't be done Because ? Give the Reason");

if (reason!=null && reason!="")
  {
	  
  	$.post("lain32/plan_proc.php", { act: act , modul: modul, id:id , reason:reason } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});
  
  }
}

function savelink(id){
	var id = id;
	
	var modul= "plan";
	var act = "link";
	
var reason = prompt("Plan Sukses? so you must give the link code of project");

if (reason!=null && reason!="")
  {
	  
  	$.post("lain32/plan_proc.php", { act: act , modul: modul, id:id , reason:reason } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});
  
  }
}

function fung_load_planb(id){
	

	var id = id;
	
	var modul= "plan";
	var act = "planb";
	
	$.post("lain32/plan_proc.php", { act: act , modul: modul} , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);});

}