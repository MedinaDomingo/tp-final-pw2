// Obtener elementos relevantes
const questionContainer = document.querySelector('.question');
const answerOptions = document.querySelectorAll('.answer-option');

// Asignar evento de clic a las opciones de respuesta
answerOptions.forEach(option => {
    option.addEventListener('click', () => {
        const idPregunta = questionContainer.dataset.idPregunta;
        const idRespuesta = option.dataset.idRespuesta;

        // Realizar la solicitud Ajax para obtener la próxima pregunta
        fetch('/obtener-pregunta-ajax', {
            method: 'POST',
            body: JSON.stringify({ idPregunta, idRespuesta }),
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                // Actualizar la vista con la nueva pregunta obtenida
                questionContainer.dataset.idPregunta = data.id_pregunta;
                questionContainer.querySelector('h2').textContent = data.descripción;
            })
            .catch(error => {
                console.error('Error en la solicitud :', error);
            });
    });
});
