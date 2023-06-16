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
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='cliente'){
            header('Location:/');
        }

        $id = $_SESSION['user_data']['id_usuario'];
        $rank = $this->model->obtenerRankingUsuario($id)[0]['ranking'];
        $_SESSION['user_data']['rank'] = $rank;
        $user_data = $_SESSION['user_data'];
        $data = array(
            'nombre_u' => $user_data['nombre_u']
        );
        //$this->renderer->render('lobby', $data);
        $this->renderer->render('lobby', $user_data);
    }

}