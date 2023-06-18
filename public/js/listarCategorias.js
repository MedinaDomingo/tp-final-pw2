$(document).ready(function() {
    let selectCategoria = $("#categoria");

    $.ajax({
        url: 'http://localhost:8080/GestionPreguntas/listarCategorias',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            selectCategoria.empty();
            $.each(response, function(index, obj) {
                var valor = obj["0"];
                var descripcion = obj["descripción"];

                var option = $("<option>").val(valor).text(descripcion);
                selectCategoria.append(option);
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error en la segunda consulta:', errorThrown);
        }
    });
});

