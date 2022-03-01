function show_corigenda(id_coregenda){

	var modul= "show_coregenda";
	var id_coregenda = id_coregenda;
	
	$.post("rules/proc_corigenda.php", { id_coregenda: id_coregenda , modul: modul } , function(html) {
			$('.corigenda').html(html);
			$(".corigenda").hide();
			$(".corigenda").fadeIn(400);});

}


function del_corigenda(id_coregenda,id_rulink){

	var modul= "del_corigenda";
	var id_coregenda = id_coregenda;
	var id_rulink=id_rulink;
	
	$.post("rules/proc_corigenda.php", { id_coregenda: id_coregenda , modul: modul,id_rulink:id_rulink } , function(html) {
			$('.allcorigenda').html(html);
			$(".allcorigenda").hide();
			$(".allcorigenda").fadeIn(400);});

}