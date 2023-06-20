$(document).ready(function () {
    $('#guardar').submit(function (event) {
        event.preventDefault(); //Esto evita que se envíe el formulario de forma perrito

        var formData = $(this).serialize(); // Obtiene los datos del formulario
        console.log(formData);
        $.ajax({
            url: '/GestionPreguntas/guardarPregunta',
            type: 'POST',
            data: formData, // Datos del formulario
            dataType: 'json',
            success: function (response) {
                $('.error').remove(); // Eliminar mensajes de error existentes

                $.each(response, function (key, value) {
                    let errorElement = $('#' + key + '-div').find('.error');
                    if (errorElement.length) {
                        errorElement.text(value);
                    } else {
                        $('#' + key + '-div').append('<p class="error">' + value + '</p>');
                    }
                    var newUrl = "/GestionPreguntas/gestion";
                    history.pushState(null, '', newUrl);
                });

                if (response[0] === 'guardado') {
                    console.log("Se guardo");
                    window.location.href = "/GestionPreguntas/gestion?mensaje=guardado";
                    window.history.pushState(null, null, '/GestionPreguntas/gestion');

                    console.log('La pregunta ha sido guardada');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.log('No se cargó:', errorThrown);
                console.log('Estado:', textStatus);
                console.log('Respuesta del servidor:', jqXHR.responseText);
                console.log('No se cargo', errorThrown);
            }
        });
    });
});

