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
        unset($_SESSION['puntajePartida']);
        unset($_SESSION["GameTimer"]);

        $_SESSION['preguntasRealizadas'] = [];
        $_SESSION['puntajePartida'] = 0;

        // Obtener una pregunta aleatoria de la base de datos
        $pregunta = $this->model->obtenerPreguntaAleatoria($_SESSION['preguntasRealizadas'], $_SESSION['user_data']['id_usuario']);

        if($pregunta == null){
            $data = array(
                "error" => "No se pudieron encontrar preguntas"
            );

            $this->renderer->render('partidaFinalizada', $data);
            return;
        }
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

        $puntaje = $this->model->obtenerPuntaje($_SESSION['user_data']['id_usuario']);
        $fotoPerfil = $this->model->obtenerFotoPerfil($_SESSION['user_data']['id_usuario']);
        // Mostrar la vista de partida con la pregunta y opciones de respuesta

        $data = [
            'pregunta' => $pregunta[0]['descripción'],
            'categoria' => $pregunta[1]['descripción'],
            'opcion_a' => $pregunta[0]['opcion_a'],
            'opcion_b' => $pregunta[0]['opcion_b'],
            'opcion_c' => $pregunta[0]['opcion_c'],
            'opcion_d' => $pregunta[0]['opcion_d'],
            'puntajePartida' => $_SESSION['puntajePartida'],
            'puntaje' => $puntaje,
            'foto_perfil' => $fotoPerfil,

        ];

        //            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//                $idPregunta = $_POST['id_pregunta'];
//                $opcionSeleccionada = $_POST['respuesta'];
//
//                // Verificar la respuesta seleccionada
//                $respuestaCorrecta = $this->model->verificarRespuesta($idPregunta, $opcionSeleccionada);
//
//                if ($respuestaCorrecta) {
//                    echo 'correcta';
//                    exit();
//                } else {
//                    echo 'incorrecta';
//                    exit();
//                }
//            }

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
        if ($respuestaUsuario == $pregunta['opcion_correcta']) { // La respuesta es correcta

            // Actualizar el puntaje de la partida
            $_SESSION['puntajePartida'] += 1;
            // Actualizar el puntaje del usuario
            //$this->model->incrementarPuntaje($_SESSION['user_data']['id_usuario']);


            // Obtener una nueva pregunta aleatoria
            $nuevaPregunta = $this->model->obtenerPreguntaAleatoria($_SESSION['preguntasRealizadas'], $_SESSION['user_data']['id_usuario']);
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
                        throw new Exception();
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
            //var_dump($_SESSION['puntajePartida']);
            $puntaje += $_SESSION['puntajePartida'];
            $this->model->actualizarPuntaje($_SESSION['user_data']['id_usuario'], $puntaje);

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

        unset($_SESSION["GameTimer"]);

        $puntaje = $this->model->obtenerPuntaje($_SESSION['user_data']['id_usuario']);
        $pregunta = $this->model->obtenerPreguntaAleatoria($_SESSION['preguntasRealizadas'], $_SESSION['user_data']['id_usuario']);
        if(empty($pregunta)){
            echo 'ERROR_NMQ';
            exit();
        }
        array_push($_SESSION['preguntasRealizadas'], $pregunta[0]['id_pregunta']);
        $data = [
            'pregunta' => $pregunta[0]['descripción'],
            'categoria' => $pregunta[1]['descripción'],
            'opcion_a' => $pregunta[0]['opcion_a'],
            'opcion_b' => $pregunta[0]['opcion_b'],
            'opcion_c' => $pregunta[0]['opcion_c'],
            'opcion_d' => $pregunta[0]['opcion_d'],
            'puntajePartida' => $_SESSION['puntajePartida'],
            'puntaje' => $puntaje
        ];
        $_SESSION['idPreguntaActual'] = $pregunta[0]['id_pregunta'];

        echo json_encode($data);
    }

    public function reportarPregunta()
    {
        $trest = $this->model->reportarPregunta($_SESSION['idPreguntaActual']);
        echo $trest;
    }

    public function timer()
    {
        $data = [
            'GameStatus' => $this->model->checkTimer()
        ];
 
       echo json_encode($data);
    }



}