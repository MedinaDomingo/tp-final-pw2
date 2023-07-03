const TIMER = 1000;
const TIME_IN_SECONDS = TIMER / 100;
const SERVER_TIMER = TIMER * 4;
let currentTimer;

// Función para manejar la selección de una respuesta por el usuario
function seleccionarRespuesta(respuesta, pregunta) {
    // Enviar la respuesta seleccionada al servidor para su verificación
    $.ajax({
        type: 'POST',
        url: '/Partida/verificarRespuesta',
        data: {
            respuesta: respuesta,
            pregunta: pregunta
        },
        success: function (response) {
            console.log("RESPONSE: " + response + "\n");

            if (response == 'ERROR_NMQ') {
                redirigirAlLobby();
            }

            if (response === 'correcta') {

                // La respuesta es correcta, cargar una nueva pregunta

                cargarNuevaPregunta();

            } else if (response === 'incorrecta') {
                // La respuesta es incorrecta, redirigir al lobby
                console.log("false");
                redirigirAlLobby();
            }
        },
        error: function () {
            // Manejar el error en caso de fallo en la solicitud AJAX
            console.log('Error al verificar la respuesta.');
        }
    });
}

// Función para cargar una nueva pregunta en la vista de partida
function cargarNuevaPregunta() {

    clearTimeout(currentTimer);
    startTimer(TIME_IN_SECONDS);

    $.ajax({
        type: 'GET',
        url: '/Partida/preguntaAleatoria',
        success: function (data) {
            if(data === "ERROR_NMQ"){
                redirigirAlLobby();
            }else{
                data = $.parseJSON(data)

                // Actualizar la vista con la nueva pregunta y opciones de respuesta
                $('#pregunta-enviar').text(data.pregunta);
                $('#categoria').text('Categoría: ' + data.categoria);
                $('#opcionA').text(data.opcion_a);
                $('#opcionB').text(data.opcion_b);
                $('#opcionC').text(data.opcion_c);
                $('#opcionD').text(data.opcion_d);

                $(".cat-container").removeClass(function(index, className){
                    return (className.match(/(^|\s)cat-color-[^-\s]+/g) || []).join(' ');
                });

                $(".cat-container").addClass("cat-color-" + data.categoria);


                // Incrementar el puntaje de partida en 1
                puntajePartida = data.puntajePartida;
                $('#puntaje-partida').find('h2').html('Puntaje: ' + puntajePartida);
            }


        },
        error: function(xhr, status, error) {
            // Manejo del error de la solicitud
            console.error(error,xhr, status);
        }
    });
}

// Función para redirigir al usuario al lobby
function redirigirAlLobby() {

    window.location.href = '/PartidaFinalizada/gameover';
}

$('#reportarPregunta').on('click', function () {
    $.ajax({
        type: 'POST',
        url: '/Partida/reportarPregunta',
        success: function (data) {
            clearTimeout(currentTimer);
            if(data == 1){
                Swal.fire({
                    title: '¡Tu pregunta ha sido reportada!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    cargarNuevaPregunta();
                });
            }

        },
        error: function(xhr, status, error) {

            console.error(error,xhr, status);
        }
    });
});

// Manejar el evento de clic en las opciones de respuesta
$('#opcionA').on('click', function () {
    let pregunta = $('#pregunta-enviar').text();
    let opcionA = $('#opcionA').text();
    seleccionarRespuesta(opcionA, pregunta);
});

$('#opcionB').on('click', function () {
    let pregunta = $('#pregunta-enviar').text();
    let opcionB = $('#opcionB').text();
    seleccionarRespuesta(opcionB, pregunta);
});

$('#opcionC').on('click', function () {
    let pregunta = $('#pregunta-enviar').text();
    let opcionC = $('#opcionC').text();
    seleccionarRespuesta(opcionC, pregunta);
});

$('#opcionD').on('click', function () {
    let pregunta = $('#pregunta-enviar').text();
    let opcionD = $('#opcionD').text();
    seleccionarRespuesta(opcionD, pregunta);
});



function startTimer(time = 10) {
    currentTimer = setTimeout(updateTimer, TIMER, time);
}

function updateTimer(time) {



    $.ajax({
        type: 'POST',
        url: '/Partida/timer',
        data: { time: time },
        success: function (data) {
            data = $.parseJSON(data);


            if (time === 0) {

            } else {
                currentTimer = setTimeout(updateTimer, TIMER, time - 1);
            }

            $("#time").html(time);

            if (data.GameStatus == false) {
                redirigirAlLobby();
            }

        },
        error: function () {
            console.log('Error al obtener una nueva pregunta.');
        }
    });



}
