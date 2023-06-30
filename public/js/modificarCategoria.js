$(document).ready(function() {
    $('#tablaPreguntas').on('click', '#btn-modificar', function(e) {
        e.preventDefault();


        var fila = $(this).closest('tr');
        var categoria = fila.find('td:nth-child(1)').text();



        var datos = {
            categoria: categoria,
        };


        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            data: datos,
            success: function(response) {

                $('#resultado').html(response);
            },
            error: function(xhr, status, error) {
                console.error(error,xhr, status);
            }
        });
    });

});
