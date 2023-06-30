$(document).ready(function() {
    $('#guardar').submit(function(event) {
        event.preventDefault(); //Esto evita que se envíe el formulario de forma perrito

        var formData = $(this).serialize(); // Obtiene los datos del formulario

        $.ajax({
            url: '/GestionPreguntas/guardarCategoria',
            type: 'POST',
            data: formData, // Datos del formulario
            dataType: 'json',
            success: function(response) {
                $('.error').remove(); // Eliminar mensajes de error existentes

                $.each(response, function(key, value) {
                    let errorElement = $('#' + key + '-div').find('.error');
                    if (errorElement.length) {
                        errorElement.text(value);
                    } else {
                        $('#' + key + '-div').append('<p class="error">' + value + '</p>');
                    }
                    var newUrl = "/GestionPreguntas/categorias";
                    history.pushState(null, '', newUrl);
                });

                if (response[0] == true) {
                    console.log("Se guardo");
                    window.location.href = "/GestionPreguntas/categorias?mensaje=guardado";
                    window.history.pushState(null, null, '/GestionPreguntas/categorias');

                    console.log('La pregunta ha sido guardada');
                }
            },
            error: function(xhr, status, error) {
                // Manejo del error de la solicitud
                console.error(error,xhr, status);
            }
        });
    });
});

