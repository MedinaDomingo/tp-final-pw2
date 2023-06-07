<?php

class RankingController
{
    private $model;
    private $renderer;
    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function ranking(){
        if(!$_SESSION['valid']){
            header('Location:/');
        }

        $this->renderer->render('ranking');
    }
}