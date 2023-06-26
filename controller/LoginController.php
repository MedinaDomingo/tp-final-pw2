<?php

class LoginController
{
    private $loginModel;
    private $renderer;

    public function __construct($loginModel, $renderer) {
        $this->loginModel = $loginModel;
        $this->renderer = $renderer;
    }

    public function mostrarLogin() {
        if(isset($_SESSION['valid'])){

            switch ($_SESSION['user_data']['descripción']){
                case 'editor':
                    header('Location: /Editor/editor');
                    exit();
                case 'administrador':
                    header('Location: /Administrador/administrador');
                    exit();
                case 'cliente':
                    header('Location: /Lobby/lobby');
                    exit();
            }
        }

        $this->renderer->render('login');
    }

    public function iniciarSesion(){
        $aDondeVamosMono = $this->loginModel->validarUsuario();


        if($aDondeVamosMono[0] != 'login'){
            $_SESSION["valid"] = 1;
            $_SESSION["user_data"] = $aDondeVamosMono[1];
            $controller = ucfirst($aDondeVamosMono[0]);
            $method = $aDondeVamosMono[0];
            header("Location: /$controller/$method");
            exit();
        }else{
            $this->renderer->render($aDondeVamosMono[0],$aDondeVamosMono[1]);
        }
    }


}