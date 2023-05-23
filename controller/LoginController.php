<?php

class LoginController
{
    private $renderer;

    public function __construct($renderer) {
        $this->renderer = $renderer;
    }

    public function mostrarLogin() {
        $this->renderer->render('login');
    }
}