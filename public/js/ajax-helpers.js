/**
 * Created by Samuel Mercado on 02/07/2015.
 */

(function() {

    var submitAjaxRequest = function(e) {

        var form = $(this);
        var method = form.find('input[name="_method"]').val() || 'POST';

        $.ajax({
            type: method,
            url: form.prop('action'),
            data: form.serialize(),
            success: function(response) {
                $('#json-message').append('<div class="alert alert-info alert-dismissable" role="alert">' +
                '' + response.message + '' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '</div>');
                $("#"+response.ocultar).hide();
            }
        })

        e.preventDefault();
    };

    //Formulario con atributo "data-remote" enviarán información vía AJAX
    $('form[data-remote]').on('submit', submitAjaxRequest);

    //The "data-click-submits-form" attribute
    $('*[data-click-submits-form]').on('change', function () {
        $(this).closest('form').submit();
    })

})();
