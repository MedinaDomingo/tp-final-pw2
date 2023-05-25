<?php

class RegistroController
{
    private $registroModel;
    private $renderer;

    public function __construct($registroModel,$renderer) {
        $this->registroModel = $registroModel;
        $this->renderer = $renderer;
    }

    public function mostrarRegistro() {
        $this->renderer->render('registro');
    }

    public function validarRegistro(){
        $errores = $this->registroModel->validarCampos();
        $this->renderer->render('registro', $errores);
    }
}