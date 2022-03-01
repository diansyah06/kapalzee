$('#go').keyup(function() {
	var search_query = $(this).val()   ;
	var saring = $('#kategoris').val()  ;

	
	$.post('rules_sup/search.php', {search_query : search_query , saring : saring }, function(searchq) {
		$('#search_query').html(searchq);
	});
});

/* Digae ben begitu filter di klik langsung refresh*/
$(document).ready(function() {

	$(".kategoris").change(function()
		{

	var search_query = $('#go').val()   ;
	var saring = $('#kategoris').val()  ;

	
	$.post('search.php', {search_query : search_query , saring : saring }, function(searchq) {
		$('#search_query').html(searchq);
	});
		
	});

	
})