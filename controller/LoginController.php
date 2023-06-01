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

        if(is_array($aDondeVamosMono)){

            $this->renderer->render($aDondeVamosMono[0], $aDondeVamosMono[1]);
        }else{
            session_start();
            $_SESSION["validado"] = 1;
            $_SESSION["usuario"] = $aDondeVamosMono[1];
            $this->renderer->render("$aDondeVamosMono", $aDondeVamosMono[1]);

        }



    }
}