<?php

class RegistroController
{
    private $renderer;

    public function __construct($renderer) {
        $this->renderer = $renderer;
    }

    public function mostrarRegistro() {
        $this->renderer->render('registro');
    }
}