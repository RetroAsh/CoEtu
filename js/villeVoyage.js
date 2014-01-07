$(function(){
	alert('bonjour');

	$('#dep').autocomplete({
		source : './ajax/getListeVille.php',
		minLength: 1,
		messages: {
			noResults: '',
			results: function() {}
		}
	});
	
	$('#arr').autocomplete({
		source : './ajax/getListeVille.php',
		minLength: 1,
		messages: {
			noResults: '',
			results: function() {}
		}
	});
	$('#v_dep').autocomplete({
		source : './ajax/getListeVille.php',
		minLength: 1,
		messages: {
			noResults: '',
			results: function() {}
		}
	});
	
	$('#v_arr').autocomplete({
		source : './ajax/getListeVille.php',
		minLength: 1,
		messages: {
			noResults: '',
			results: function() {}
		}
	});
	
	
});