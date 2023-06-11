<?php

class UsersProfileController
{
    private $model;
    private $renderer;

    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function user()
    {
        //http://localhost/UsersProfile/user?user=Genti
        $userName = $_GET['user'];
        $data = $this->model->getUserData($userName);

        if (isset($_SESSION['valid']) && $userName != $_SESSION['usuario']['nombre_u']) {
            $data[1]['valid'] = true;
        }

        $this->renderer->render('perfilUsuario', $data[1]);
    }
}