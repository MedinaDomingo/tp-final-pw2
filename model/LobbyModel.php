<?php

class LobbyModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function obtenerRankingUsuario($id)
    {
        $sql = "SELECT COUNT(DISTINCT u.puntaje) AS ranking FROM usuario u WHERE u.puntaje >= (SELECT puntaje FROM usuario WHERE id_usuario = $id)";

        return $this->database->query($sql);
    }

}