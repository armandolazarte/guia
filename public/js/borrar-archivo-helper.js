/**
 * Created by Samuel Mercado on 10/09/2015.
 */

(function() {
    $('.borrar-archivo').click(function(e) {
        e.preventDefault();

        var archivo_id = $(this).val();
        var archivo_nombre = $(this).parent('td').prev().text();

        $('#borrar-archivo-form').attr('action', function (i, value) {
            var x = value.lastIndexOf('/');
            if(x > 24){
                value = value.slice(0,x);
            }
            return value + '/' + archivo_id;
        });

        $('#nombre-archivo').empty();
        $('#nombre-archivo').append(archivo_nombre);
    });
})();
