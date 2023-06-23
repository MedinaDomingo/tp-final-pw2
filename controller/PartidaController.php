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

    public function partida()
    {
        if (!$_SESSION['valid']) {
            header('Location:/');
            exit();
        }
        unset($_SESSION['preguntasRealizadas']);
        unset($_SESSION['idPreguntaActual']);

        $_SESSION['preguntasRealizadas'] = [];

        // Obtener una pregunta aleatoria de la base de datos
        $pregunta = $this->model->obtenerPreguntaAleatoria($_SESSION['preguntasRealizadas']);
        array_push($_SESSION['preguntasRealizadas'], $pregunta[0]['id_pregunta']);
        $_SESSION['idPreguntaActual'] = $pregunta[0]['id_pregunta'];

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
            'opcion_a' => $pregunta[0]['opcion_a'],
            'opcion_b' => $pregunta[0]['opcion_b'],
            'opcion_c' => $pregunta[0]['opcion_c'],
            'opcion_d' => $pregunta[0]['opcion_d']
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

    public function verificarRespuesta()
    {
        // Obtener la respuesta seleccionada por el usuario
        $respuestaUsuario = $_POST['respuesta'];

        // Obtener la pregunta actual
        /*$pregunta = $this->model->obtenerPreguntaActual();*/
        $pregunta = $this->model->obtenerPregunta($_POST['pregunta']);

        // Verificar si la respuesta es correcta
        if ($respuestaUsuario == $pregunta['opcion_correcta']) {
            // La respuesta es correcta

            // Actualizar el puntaje del usuario
            $this->model->incrementarPuntaje($_SESSION['user_data']['id_usuario']);

            // Obtener una nueva pregunta aleatoria
            $nuevaPregunta = $this->model->obtenerPreguntaAleatoria($_SESSION['preguntasRealizadas']);
            array_push($_SESSION['preguntasRealizadas'], $pregunta['id_pregunta']);
            $_SESSION['idPreguntaActual'] = $pregunta['id_pregunta'];
            // Mostrar la vista de partida con la nueva pregunta

            try {
                $data = [
                    'pregunta' => $nuevaPregunta[0]['descripción'] ?? null,
                    'categoria' => $nuevaPregunta[0]['id_categoria'] ?? null,
                    'opcion_a' => $nuevaPregunta[0]['opcion_a'] ?? null,
                    'opcion_b' => $nuevaPregunta[0]['opcion_b'] ?? null,
                    'opcion_c' => $nuevaPregunta[0]['opcion_c'] ?? null,
                    'opcion_d' => $nuevaPregunta[0]['opcion_d'] ?? null,
                    'id_pregunta' => $nuevaPregunta[0]['id_pregunta'] ?? null
                ];

                foreach ($data as $campo => $valor) {
                    if ($valor == null) {
                        throw  new Exception();
                    }
                }



                echo "correcta";

            } catch (Exception $e) {
                echo 'ERROR_NMQ';
            }


            /*$this->renderer->render('partida', $data);*/
        } else {
            // La respuesta es incorrecta, redirigir al lobby

            // Obtener el puntaje del usuario
            $puntaje = $this->model->obtenerPuntaje($_SESSION['user_data']['id_usuario']);

            // Mostrar la vista de fin de partida con el puntaje
            $data = [
                'puntaje' => $puntaje
            ];
            echo "incorrecta";
            /*$this->renderer->render('fin_partida', $data);*/
        }
    }

    public function preguntaAleatoria()
    {
        $pregunta = $this->model->obtenerPreguntaAleatoria($_SESSION['preguntasRealizadas']);
        array_push($_SESSION['preguntasRealizadas'], $pregunta[0]['id_pregunta']);
        $data = [
            'pregunta' => $pregunta[0]['descripción'],
            'categoria' => $pregunta[0]['id_categoria'],
            'opcion_a' => $pregunta[0]['opcion_a'],
            'opcion_b' => $pregunta[0]['opcion_b'],
            'opcion_c' => $pregunta[0]['opcion_c'],
            'opcion_d' => $pregunta[0]['opcion_d']
        ];
        echo json_encode($data);
    }

    public function reportarPregunta(){
        $trest = $this->model->reportarPregunta($_SESSION['idPreguntaActual']);
    }
}