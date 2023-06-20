<?php

class PartidaController
{
    private $model;
    private $renderer;
    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function partida(){
        // Obtener una pregunta aleatoria de la base de datos
        $pregunta = $this->partidaModel->obtenerPreguntaAleatoria();

        // Mostrar la vista de partida con la pregunta y opciones de respuesta
        $data = [
            'pregunta' => $pregunta['descripción'],
            'categoria' => $pregunta['id_categoria'],
            'opciones' => [
                $pregunta['opcion_a'],
                $pregunta['opcion_b'],
                $pregunta['opcion_c'],
                $pregunta['opcion_d']
            ]
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPregunta = $_POST['id_pregunta'];
            $opcionSeleccionada = $_POST['respuesta'];

            // Verificar la respuesta seleccionada
            $respuestaCorrecta = $this->partidaModel->verificarRespuesta($idPregunta, $opcionSeleccionada);

            if ($respuestaCorrecta) {
                echo 'correcta';
                exit();
            } else {
                echo 'incorrecta';
                exit();
            }
        }

        $this->renderer->render('partida', $data);

    }

    public function verificarRespuesta() {
        // Obtener la respuesta seleccionada por el usuario
        $respuestaUsuario = $_POST['respuesta'];

        // Obtener la pregunta actual
        $pregunta = $this->partidaModel->obtenerPreguntaActual();

        // Verificar si la respuesta es correcta
        if ($respuestaUsuario === $pregunta['opcion_correcta']) {
            // Actualizar el puntaje del usuario
            $this->partidaModel->incrementarPuntaje($_SESSION['user_data']['id_usuario']);

            // Obtener una nueva pregunta aleatoria
            $nuevaPregunta = $this->partidaModel->obtenerPreguntaAleatoria();

            // Mostrar la vista de partida con la nueva pregunta
            $data = [
                'pregunta' => $nuevaPregunta['descripción'],
                'categoria' => $nuevaPregunta['id_categoria'],
                'opciones' => [
                    $nuevaPregunta['opcion_a'],
                    $nuevaPregunta['opcion_b'],
                    $nuevaPregunta['opcion_c'],
                    $nuevaPregunta['opcion_d']
                ]
            ];

            $this->renderer->render('partida', $data);
        } else {
            // La respuesta es incorrecta, finalizar la partida y mostrar el puntaje
            $puntaje = $this->partidaModel->obtenerPuntaje($_SESSION['user_data']['id_usuario']);
            $data = [
                'puntaje' => $puntaje
            ];
            $this->renderer->render('partida_finalizada', $data);
        }
    }
}
