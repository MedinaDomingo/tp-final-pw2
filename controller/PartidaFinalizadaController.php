<?php

class PartidaFinalizadaController
{
    private $model;
    private $renderer;

    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function gameover()
    {
        unset($_SESSION["antiF5"]);
        unset($_SESSION['preguntasRealizadas']);
        unset($_SESSION['idPreguntaActual']);

        $data = [
            'puntaje' => $_SESSION['puntajePartida'],
            'nombre_u' => $_SESSION['user_data']['nombre_u'],
            'foto_perfil' => $_SESSION['user_data']['foto_perfil']
        ];

        $this->model->incrementarPuntaje($_SESSION['user_data']['id_usuario'], $_SESSION['puntajePartida']);

        $this->renderer->render('partidaFinalizada', $data);
    }
}