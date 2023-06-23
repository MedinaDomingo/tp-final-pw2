$(document).ready(function() {
    let selectModificar  = $("#categoria-modificar")

    $.ajax({
        url: 'http://localhost:8080/GestionPreguntas/listarCategorias',
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            $.each(response, function(index, obj) {
                var valor = obj["0"];
                var descripcion = obj["descripción"];

                if (selectModificar.find('option[value="' + valor + '"]').length === 0) {
                    var option = $("<option>").val(valor).text(descripcion);
                    selectModificar.append(option);
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error en la segunda consulta:', errorThrown);
        }
    });
});