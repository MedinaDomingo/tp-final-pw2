<?php

class PerfilUsuarioController
{
    private $renderer;


    public function __construct($renderer) {
        $this->renderer = $renderer;
    }

    public function mostrarPerfil() {
        if (isset($_SESSION['login']) && $_SESSION['login']) {

            $this->renderer->render('perfilUsuario', $_SESSION["usuario"]);
            exit();
        }
        header("location: /");
        exit();

    }
}