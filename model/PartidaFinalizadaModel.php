<?php
    class PartidaFinalizadaModel
    {
        private $database;
        public function __construct($database)
        {
            $this->database = $database;
        }
        public function obtenerDatosFinalizacion($id_usuario){


            //  $query = "SELECT puntaje FROM usuario WHERE id_usuario = ? ";


            $statement = $this->database->getConnection()->prepare($query);
            $statement->bind_param("s", $id_usuario);
            $statement->execute();
            $statement->bind_result($id_usuario);

            return ['puntaje'=>$id_usuario];
        }
    }