<?php
    class PartidaFinalizadaModel
    {
        private $database;
        public function __construct($database)
        {
            $this->database = $database;
        }
        public function incrementarPuntaje($idUsuario, $puntaje)
        {
            $query = "UPDATE usuario SET puntaje = puntaje + '$puntaje' WHERE id_usuario = ?";

            $stmt = $this->database->getConnection()->prepare($query);
            $stmt->bind_param('i', $idUsuario);
            $stmt->execute();

        }
    }