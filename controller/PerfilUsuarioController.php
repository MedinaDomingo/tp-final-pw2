<?php

class PerfilUsuarioController
{
    private $renderer;
    private $model;


    public function __construct($model, $renderer) {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function mostrarPerfil() {
        $data = $this->model->getData($_GET['user']);

        $view = $data[0]; //Esto es la vista, perfilUsuario.mustache
        $info = $data[1]; //Estos serian los datos con los que poblar la pagina
                          //Lo que se llame de al bd y cosas asi, aca solo use el nombre de usuario

        $this->renderer->render($data[0], $data[1]);
    }

    public function cerrarSesion(){
        unset($_SESSION['valid']);
        header("Location:/");
    }
}