<?php

class PartidaController
{
    private $model;
    private $renderer;
    public function __construct($renderer)
    {
        $this->renderer = $renderer;
        $this->model = new PartidaModel();
    }

    public function partida(){
        $preguntas = $this->model->obtenerPregunta();
        $this->renderer->render('partida', ['preguntas' => $preguntas]);
    }

    public function obtenerPreguntaAjax()
    {
        // Obtener la próxima pregunta
        $pregunta = $this->model->obtenerPregunta();

        // Devolver la pregunta en formato JSON
        echo json_encode($pregunta);
    }

}