$(function(){
	$('#ville').autocomplete({
		source : '../ajax/getListeVille.php',
		minLength: 1,
		messages: {
			noResults: '',
			results: function() {}
		}
	});
	
	$('#univ').autocomplete({
		source : '../ajax/getListeCampus.php',
		minLength: 1,
		messages: {
			noResults: '',
			results: function() {}
		}
	});
	
});