$(document).ready(function() {
    let selectModificar  = $("#categoria-modificar")

    $.ajax({
        url: '/GestionPreguntas/listarCategorias?paginacion=no',
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            $.each(response, function(index, obj) {
                let valor = obj.categoria;
                let descripcion = obj.categoria;

                if (selectModificar.find('option[value="' + valor + '"]').length === 0) {
                    var option = $("<option>").val(valor).text(descripcion);
                    selectModificar.append(option);
                }
            });
        },
        error: function(xhr, status, error) {
            console.error(error,xhr, status);
        }
    });
});