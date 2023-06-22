<?php
include_once('exeptions/CategoriaNoExisteExeptions.php');

class GestionPreguntasModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function guardarPregunta($pregunta, $categoria, $otraCategoria, $check, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC)
    {
        $errores = [];

        if (empty($pregunta)) {
            $errores['pregunta'] = "La pregunta no puede estar vacía.";
        }else{
            $result = $this->buscarPregunta($pregunta);
            if(!empty($result)){
                $errores['pregunta'] = "La pregunta ya existe";
            }
        }

        if (empty($respuestaCorrecta)) {
            $errores['respuestaCorrecta'] = "La respuesta correcta no puede estar vacía.";
        }

        if (empty($respuestaIncorrectaA)) {
            $errores['respuestaIncorrectaA'] = "La respuesta incorrecta A no puede estar vacía.";
        }

        if (empty($respuestaIncorrectaB)) {
            $errores['respuestaIncorrectaB'] = "La respuesta incorrecta B no puede estar vacía.";
        }

        if (empty($respuestaIncorrectaC)) {
            $errores['respuestaIncorrectaC'] = "La respuesta incorrecta C no puede estar vacía.";
        }
        if(empty($check)){
            try {
                $idCategoria = $this->idCategoria($categoria);

            } catch (CategoriaNoExisteExeptions $e) {
                $errores['categoria'] = $e->getMessage();
            }
        }

        if (!empty($check) && empty($otraCategoria)) {
            $errores["otra-categoria"] = "La nueva categoria no puede estar vacía";
            $errores["categoria"] = "";
        }else{

        }

        if (empty($errores)) {
            if (!empty($check) && !empty($otraCategoria)) {
                $idCategoria = $this->guardarCategoria($otraCategoria);
            }
            $idRespuesta = $this->guardarRespuestas($respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC);
            $this->crearPregunta($pregunta, $idCategoria, $idRespuesta);
            return ["guardado"];
        } else {
            return $errores;
        }
    }

    public function idCategoria($categoria)
    {

        $sql = "SELECT id_categoria FROM categoria WHERE descripción = '$categoria'";
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

    public function traerTodasLasPreguntas()
    {
        $sql = "SELECT p.descripción as pregunta, c.descripción as categoria, r.correcta, r.incorrecta_a, r.incorrecta_b, r.incorrecta_c, e.descripción as estado  FROM pregunta p 
                LEFT JOIN respuesta r ON p.id_respuesta = r.id_respuesta 
                LEFT JOIN estado e ON e.id_estado = p.id_estado
                LEFT JOIN categoria c ON c.id_categoria = p.id_categoria";
        $result = $this->database->query($sql);
        return $result;
    }

    public function traerTodasLasCategorias()
    {
        $sql = "SELECT descripción FROM categoria";
        $result = $this->database->query($sql);
        return $result;
    }

    private function guardarCategoria($otraCategoria)
    {
        $sql = "INSERT INTO `categoria`(`descripción`) VALUES (?)";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("s", $otraCategoria);
        $stmt->execute();
        $idCategoria = $stmt->insert_id;
        return $idCategoria;
    }

    public function eliminarPreguntaRespuestas($pregunta)
    {
        $sql = "DELETE FROM `pregunta` WHERE descripción = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("s", $pregunta);
        $result = $stmt->execute();
        return $result;
    }

    public function buscarPregunta($pregunta)
    {
        $sql = "SELECT p.id_pregunta, p.descripción as pregunta, c.descripción as categoria, r.correcta, r.incorrecta_a, r.incorrecta_b, r.incorrecta_c, e.descripción as estado  FROM pregunta p 
                LEFT JOIN respuesta r ON p.id_respuesta = r.id_respuesta 
                LEFT JOIN estado e ON e.id_estado = p.id_estado
                LEFT JOIN categoria c ON c.id_categoria = p.id_categoria WHERE p.descripción = '$pregunta';";
        $result = $this->database->query($sql);
        return $result;
    }

    public function modificarPregunta($idPregunta, $pregunta, $categoria, $estado, $otraCategoria, $check, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC)
    {
        if (empty($pregunta)) {
            $errores['pregunta'] = "La pregunta no puede estar vacía.";
        }else{
            $result = $this->buscarPregunta($pregunta);
            if(!empty($result)){
                $errores['pregunta'] = "La pregunta ya existe";
            }
        }

        if (empty($respuestaCorrecta)) {
            $errores['respuestaCorrecta'] = "La respuesta correcta no puede estar vacía.";
        }

        if (empty($respuestaIncorrectaA)) {
            $errores['respuestaIncorrectaA'] = "La respuesta incorrecta A no puede estar vacía.";
        }

        if (empty($respuestaIncorrectaB)) {
            $errores['respuestaIncorrectaB'] = "La respuesta incorrecta B no puede estar vacía.";
        }

        if (empty($respuestaIncorrectaC)) {
            $errores['respuestaIncorrectaC'] = "La respuesta incorrecta C no puede estar vacía.";
        }
        if(empty($check)){
            try {
                $idCategoria = $this->idCategoria($categoria);

            } catch (CategoriaNoExisteExeptions $e) {
                $errores['categoria'] = $e->getMessage();
            }
        }

        if (!empty($check) && empty($otraCategoria)) {
            $errores["otra-categoria"] = "La nueva categoria no puede estar vacía";
            $errores["categoria"] = "";
        }

        if (empty($errores)) {
            if (!empty($check) && !empty($otraCategoria)) {
                $idCategoria = $this->guardarCategoria($otraCategoria);
            }
            $idRespuesta = $this->guardarRespuestas($respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC);
            $this->modificarPreguntaExistente($idPregunta, $pregunta, $idCategoria, $idRespuesta);
            return ["guardado"];
        } else {
            return $errores;
        }
    }

    private function modificarPreguntaExistente($idPregunta,$pregunta, $idCategoria, $idRespuesta)
    {
        $sql = "UPDATE `pregunta` SET `descripción`= ?,`id_categoria`=?,`id_estado`= 1,`id_respuesta`=? WHERE id_pregrunta = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("ssss", $pregunta, $idCategoria, $idRespuesta, $idPregunta);
        $result = $stmt->execute();
        return $result;
    }
}