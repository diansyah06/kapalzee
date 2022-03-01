function fung_load_relation(cek_po, nama ){
	
	var tipe  = "rules";
	var nama = nama;
	
	$.post("rules/load-char.php", { tipe: tipe , cek_po: cek_po  , nama: nama} , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);
			$('h4#results-text').fadeOut();
			$("ul#results").fadeOut();
			document.getElementById('search').value='';
			});	
	
}

function fung_load_literatur(id,nama){
	
	var tipe  = "literature";
	var nama = nama;
	
	$.post("rules/load-char.php", { tipe: tipe , id: id , nama:nama } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);
			$('h4#results-text').fadeOut();
			$("ul#results").fadeOut();
			
			$('h4#results-text').fadeOut();
			$("ul#results").fadeOut();
			document.getElementById('search').value='';
			
			
			});	
	
}


function fung_load_other(id, nama ){
	
	var tipe  = "other";
	var nama = nama;
	
	$.post("rules/load-char.php", { tipe: tipe , id: id , nama:nama } , function(html) {
			$('.deskripsi').html(html);
			$(".deskripsi").hide();
			$(".deskripsi").fadeIn(400);
			$('h4#results-text').fadeOut();
			$("ul#results").fadeOut();
			
			$('h4#results-text').fadeOut();
			$("ul#results").fadeOut();
			document.getElementById('search').value='';
			
			});	
	
}