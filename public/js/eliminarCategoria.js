$(document).ready(function() {
    $('#tablaPreguntas').on('click', '#btn-eliminar', function() {
        let fila = $(this).closest('tr');


        let categoria = fila.find('td:first').text();


        $.ajax({
            url: '/GestionPreguntas/eliminarCategoria',
            type: 'POST',
            data: { categoria: categoria },
            success: function(response) {
                if(response){
                    fila.remove();
                }else{
                    console.log("No elimino");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error al eliminar la fila:', errorThrown);
            }
        });
    });
});
