<?php

class LobbyController
{
    private $model;
    private $renderer;
    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function lobby(){
        if(!$_SESSION['valid']){
            header('Location:/');
        }

        $user_data = $_SESSION['user_data'];
        $data = array(
            'nombre_u' => $user_data['nombre_u']
        );
        $this->renderer->render('lobby', $data);
    }
}