<?php

class RegistroController
{
    private $registroModel;
    private $renderer;

    public function __construct($registroModel, $renderer)
    {
        $this->registroModel = $registroModel;
        $this->renderer = $renderer;
    }

    public function mostrarRegistro()
    {
        $this->renderer->render('registro');
    }

    public function validarRegistro()
    {
        $errores = $this->registroModel->validarCampos();
        if (!empty($errores["errores"])) {
            $this->renderer->render('registro', $errores);
        } else {
            $this->renderer->render('login');
        }
    }

    public function mostrarActivarCuenta()
    {
        $this->renderer->render('validarCuenta');
    }

    public function activarCuenta()
    {
        $where = $this->registroModel->activarUsuario();
        $this->renderer->render($where[0], $where[1]);

    }
}