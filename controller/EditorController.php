<?php

class EditorController
{
    private $model;
    private $renderer;

    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function editor(){
        if(!$_SESSION['valid']){
            header('Location:/');
        }
        $this->renderer->render('perfilEditor', $_SESSION["user_data"]);
    }
}