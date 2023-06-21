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
        $pregunta = $this->model->obtenerPreguntaAleatoria();

        if (!$pregunta) {
            // No se obtuvo ninguna pregunta
            $data = [
                'error' => 'No hay mas preguntas.'
            ];
            $this->renderer->render('partida', $data);
            return;
        }

        // Mostrar la vista de partida con la pregunta y opciones de respuesta
        $data = [
            'pregunta' => $pregunta[0]['descripción'],
            'categoria' => $pregunta[0]['id_categoria'],
            'opcion_a' =>  $pregunta[0]['opcion_a'],
            'opcion_b' =>  $pregunta[0]['opcion_b'],
            'opcion_c' =>  $pregunta[0]['opcion_c'],
            'opcion_d' =>  $pregunta[0]['opcion_d']
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPregunta = $_POST['id_pregunta'];
            $opcionSeleccionada = $_POST['respuesta'];

            // Verificar la respuesta seleccionada
            $respuestaCorrecta = $this->model->verificarRespuesta($idPregunta, $opcionSeleccionada);

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

    public function verificarRespuesta(){
        // Obtener la respuesta seleccionada por el usuario
        $respuestaUsuario = $_POST['respuesta'];

        // Obtener la pregunta actual
        $pregunta = $this->model->obtenerPreguntaActual();

        // Verificar si la respuesta es correcta
        if ($respuestaUsuario === $pregunta['opcion_correcta']) {
            // La respuesta es correcta

            // Actualizar el puntaje del usuario
            $this->model->incrementarPuntaje($_SESSION['user_data']['id_usuario']);

            // Obtener una nueva pregunta aleatoria
            $nuevaPregunta = $this->model->obtenerPreguntaAleatoria();

            // Mostrar la vista de partida con la nueva pregunta
            $data = [
                'pregunta' => $nuevaPregunta['descripción'],
                'categoria' => $nuevaPregunta['id_categoria'],
                'opcion_a' => $nuevaPregunta['opcion_a'],
                'opcion_b' => $nuevaPregunta['opcion_b'],
                'opcion_c' => $nuevaPregunta['opcion_c'],
                'opcion_d' => $nuevaPregunta['opcion_d'],
                'id_pregunta' => $nuevaPregunta['id_pregunta']
            ];

            $this->renderer->render('partida', $data);
        } else {
            // La respuesta es incorrecta, redirigir al lobby

            // Obtener el puntaje del usuario
            $puntaje = $this->model->obtenerPuntaje($_SESSION['user_data']['id_usuario']);

            // Mostrar la vista de fin de partida con el puntaje
            $data = [
                'puntaje' => $puntaje
            ];

            $this->renderer->render('fin_partida', $data);
        }
    }
}