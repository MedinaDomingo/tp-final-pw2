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
        $this->renderer->render('login');
    }

    public function iniciarSesion(){
        $aDondeVamosMono = $this->loginModel->validarUsuario();

        if($aDondeVamosMono[0]!=="login"){
            $_SESSION["login"] = true;
            $_SESSION["usuario"] = $aDondeVamosMono[1];
            header("location: /lobby/mostrarLobby");
        }else{
            $this->renderer->render($aDondeVamosMono[0], $aDondeVamosMono[1]);
        }

    }
}