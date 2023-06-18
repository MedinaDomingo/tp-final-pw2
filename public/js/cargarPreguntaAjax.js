$(document).ready(function() {
    $('#guardar').submit(function(event) {
        event.preventDefault(); //Esto evita que se envíe el formulario de forma perrito

        var formData = $(this).serialize(); // Obtiene los datos del formulario

        $.ajax({
            url: 'http://localhost:8080/GestionPreguntas/guardarPregunta',
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
                    var newUrl = "/GestionPreguntas/gestion";
                    history.pushState(null, '', newUrl);
                });

                if (response[0] === 'guardado') {
                    window.location.href = "/GestionPreguntas/gestion?mensaje=guardado";

                    console.log('La pregunta ha sido guardada');
                }
            },
        });
    });
});


/*
$(document).ready(function() {
    $('#guardar').submit(function(event) {
        event.preventDefault(); //Esto evita que se envíe el formulario de forma perrito

        var formData = $(this).serialize(); // Obtiene los datos del formulario

        $.ajax({
            url: 'http://localhost:8080/GestionPreguntas/guardarPregunta',
            type: 'POST',
            data: formData, // Datos del formulario
            dataType: 'json',
            success: function(response) {
                $('.error').empty();

                if (response.pregunta) {
                    $('#pregunta-div .error').text(response.pregunta);
                }

                if (response.respuestaCorrecta) {
                    $('#respuestaCorrecta-div .error').text(response.respuestaCorrecta);
                }

                if (response.respuestaIncorrectaA) {
                    $('#respuestaIncorrectaA-div .error').text(response.respuestaIncorrectaA);
                }

                if (response.respuestaIncorrectaB) {
                    $('#respuestaIncorrectaB-div .error').text(response.respuestaIncorrectaB);
                }

                if (response.respuestaIncorrectaC) {
                    $('#respuestaIncorrectaC-div .error').text(response.respuestaIncorrectaC);
                }

                if (response.categoria) {
                    // Manejar el mensaje de error de categoría de acuerdo a tu lógica
                    let categoriaDiv = $('#categoria-div');
                    let errorElement = categoriaDiv.find('.error');
                    if (errorElement.length) {
                        errorElement.text(response.categoria);
                    } else {
                        categoriaDiv.append('<p class="error">' + response.categoria + '</p>');
                    }
                    console.log('error ' + response.categoria);
                } else if (response[0] === 'guardado') {
                    window.location.href = "/GestionPreguntas/gestion?mensaje=guardado";
                    console.log('La pregunta guardada');
                }
            },
        });
    });
});*/
