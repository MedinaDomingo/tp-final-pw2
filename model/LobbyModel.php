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
        $sql = "SELECT (SELECT COUNT(*) FROM usuario u WHERE u.puntaje >= usuario.puntaje) AS ranking FROM usuario WHERE id_usuario = $id";
        return $this->database->query($sql);
    }
}