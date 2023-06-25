$(document).ready(function() {
    $('#tablaPreguntas').on('click', '#btn-eliminar', function() {
        let fila = $(this).closest('tr');


        let pregunta = fila.find('td:first').text();


        $.ajax({
            url: '/GestionPreguntas/eliminarPreguntaRespuestas',
            type: 'POST',
            data: { pregunta: pregunta },
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
