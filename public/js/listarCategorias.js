$(document).ready(function() {
    let selectCategoria = $("#categoria");
    let url = '/GestionPreguntas/listarCategorias';


    if (window.location.pathname.includes('/gestion')) {
        url += '?paginacion=no';
    }
    if (window.location.pathname.includes('/sugerir')){
        url += '?paginacion=no';
    }

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            selectCategoria.empty();
            categorias = response
            $.each(categorias, function(index, obj) {
                let valor = obj.categoria;
                let descripcion = obj.categoria;

                let option = $("<option>").val(valor).text(descripcion);
                selectCategoria.append(option);
            });
        },
        error: function(xhr, status, error) {
            // Manejo del error de la solicitud
            console.error(error,xhr, status);
        }
    });
});

