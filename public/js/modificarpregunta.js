$(document).ready(function() {
    $('#tablaPreguntas').on('click', '#btn-modificar', function(e) {
        e.preventDefault();


        var fila = $(this).closest('tr');
        var pregunta = fila.find('td:nth-child(1)').text();



        var datos = {
            pregunta: pregunta,
        };


        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            data: datos,
            success: function(response) {
                console.log(response);
                $('#resultado').html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });


});
