<?php

    class PartidaFinalizadaController{
        private $model;
        private $renderer;

        public function __construct($model, $renderer)
        {
            $this->renderer = $renderer;
            $this->model = $model;
        }

        public function gameover(){

            $data = [
                'puntaje' => $_SESSION['puntajePartida'],
                'nombre_u' => $_SESSION['user_data']['nombre_u'],
                'foto_perfil' => $_SESSION['user_data']['foto_perfil']

            ];

            var_dump($_SESSION['user_data']['id_usuario']);

            $this->model->incrementarPuntaje($_SESSION['user_data']['id_usuario'], $_SESSION['puntajePartida']);

            $this->renderer->render('partidaFinalizada',$data);
        }
    }