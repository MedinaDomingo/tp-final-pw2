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
        $this->renderer->render('partida');
    }
}