<?php

class LobbyController
{
    private $lobbyModel;
    private $renderer;
    private $sessionManager;

    public function __construct($model, $renderer)
    {
        $this->lobbyModel = $model;
        $this->renderer = $renderer;
    }
    public function mostrarLobby() {
        if (isset($_SESSION['login']) && $_SESSION['login']) {
            $id = $_SESSION["usuario"]["id_usuario"];
            $_SESSION["usuario"]["ranking"] = $this->lobbyModel->obtenerRankingUsuario($id)[0]["ranking"];
            $this->renderer->render('lobby', $_SESSION["usuario"]);
            exit();
        }
        header("location: /");
        exit();
    }


}