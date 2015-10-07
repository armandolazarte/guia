/**
 * Created by Samuel Mercado on 07/10/2015.
 */

$(function(){
    $('#SelCuentaBancaria').on('change', function(e) {
        var cuenta_bancaria_id = e.target.value;

        $('.ruta-dinamica').attr('href', function (i, value) {
            var href_array = value.split('/');
            var nombre_reporte = href_array.slice(href_array.length - 4, href_array.length - 3);
            var aaaa = href_array.slice(href_array.length - 2, href_array.length - 1);
            var mes = href_array.slice(href_array.length - 1);

            var pos_nombre_reporte = value.indexOf(nombre_reporte);
            var new_value = value.slice(0, pos_nombre_reporte);

            return new_value + nombre_reporte + '/' + cuenta_bancaria_id + '/' + aaaa + '/' + mes;
        });
    });
    $('#SelAaaa').on('change', function(e) {
        var aaaa = e.target.value;

        $('.ruta-dinamica').attr('href', function (i, value) {
            var href_array = value.split('/');
            var nombre_reporte = href_array.slice(href_array.length - 4, href_array.length - 3);
            var cuenta_bancaria_id = href_array.slice(href_array.length - 3, href_array.length - 2);
            var mes = href_array.slice(href_array.length - 1);

            var pos_nombre_reporte = value.indexOf(nombre_reporte);
            var new_value = value.slice(0, pos_nombre_reporte);

            return new_value + nombre_reporte + '/' + cuenta_bancaria_id + '/' + aaaa + '/' + mes;
        });
    });
    $('#SelMes').on('change', function(e) {
        var mes = e.target.value;

        $('.ruta-dinamica').attr('href', function (i, value) {
            var href_array = value.split('/');
            var nombre_reporte = href_array.slice(href_array.length - 4, href_array.length - 3);
            var cuenta_bancaria_id = href_array.slice(href_array.length - 3, href_array.length - 2);
            var aaaa = href_array.slice(href_array.length - 2, href_array.length - 1);

            var pos_nombre_reporte = value.indexOf(nombre_reporte);
            var new_value = value.slice(0, pos_nombre_reporte);

            return new_value + nombre_reporte + '/' + cuenta_bancaria_id + '/' + aaaa + '/' + mes;
        });
    });
})();