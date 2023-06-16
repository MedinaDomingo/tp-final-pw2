<?php
include_once('exeptions/CategoriaNoExisteExeptions.php');

class GestionPreguntasModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function guardarPregunta($pregunta, $categoria, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC)
    {
        $errores = [];
        try {
            $idCategoria = $this->idCategoria($categoria, $errores);
            $idRespuesta = $this->guardarRespuestas($respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC);
            $this->crearPregunta($pregunta, $idCategoria, $idRespuesta);
        } catch (CategoriaNoExisteExeptions $e) {
            $errores['categoria'] = $e->getMessage();
        }

        if (empty($errores)) {
            return ["guardado"];
        } else {
            return $errores;
        }
    }

    public function idCategoria($categoria)
    {

        $sql = "SELECT id_categoria FROM categoria WHERE descripcion = '$categoria'";
        $result = $this->database->query($sql);
        if (!$result) {
            throw new CategoriaNoExisteExeptions("La categoria no existe");
        }
        return $result[0]['id_categoria'];


    }

    private function guardarRespuestas($respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC)
    {
        $sql = "INSERT INTO `respuesta` (`correcta`, `incorrecta_a`, `incorrecta_b`, `incorrecta_c`) VALUES (?, ?, ?, ?)";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("ssss", $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC);
        $stmt->execute();
        $idRepuesta = $stmt->insert_id;
        return $idRepuesta;
    }

    private function crearPregunta($pregunta, $idCategoria, $idRespuesta)
    {
        $sql = "INSERT INTO `pregunta`(`descripción`, `id_categoria`, `id_respuesta`) VALUES (?, ?, ?)";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("sss", $pregunta, $idCategoria, $idRespuesta);
        $stmt->execute();
    }
}