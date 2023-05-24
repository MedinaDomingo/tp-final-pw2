<?php

class PerfilUsuarioController
{
    private $renderer;

    public function __construct($renderer) {
        $this->renderer = $renderer;
    }

    public function mostrarLogin() {
        $this->renderer->render('perfilUsuario');
    }
}