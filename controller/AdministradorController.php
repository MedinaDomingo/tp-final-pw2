<?php

class AdministradorController
{
    private $model;
    private $renderer;
    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }
    public function administrador()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='administrador'){
            header('Location:/');
            exit();
        }
        $this->renderer->render('perfiladm', $_SESSION["user_data"]);
    }
}