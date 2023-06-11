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
//        if(!$_SESSION['valid']){
//            header('Location:/');
//            exit();
//        }
        $userName = $_GET['user'];
        $data = $this->model->getData($userName);

        if (isset($_SESSION['valid']) && $userName != $_SESSION['user_data']['nombre_u']) {
            $data[1]['valid'] = true;
        }

        $this->renderer->render($data[0], $data[1]);
    }

    public function cerrarSesion(){
        //unset($_SESSION['valid']);
        session_destroy();
        header("Location:/");
    }
}
