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

function sugvoyageform(){
    $(function(){

        $('#v_dep').autocomplete({
            source : '../ajax/getListeVille.php',
            minLength: 1,
            messages: {
                noResults: '',
                results: function() {}
            }
        });

        $('#v_arr').autocomplete({
            source : '../ajax/getListeVille.php',
            minLength: 1,
            messages: {
                noResults: '',
                results: function() {}
            }
        });
    });
}

