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
        }

        if (empty($errores)) {
            if (!empty($check) && !empty($otraCategoria)) {
                $idCategoria = $this->guardarCategoria($otraCategoria);
            }

            $this->crearPregunta($pregunta, $idCategoria, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC);
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

    private function crearPregunta($pregunta, $idCategoria, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC)
    {
        $sql = "INSERT INTO `pregunta`(`descripción`, `id_categoria`, `opcion_a`, `opcion_b`, `opcion_c`, `opcion_d`, `opcion_correcta`) VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("sssssss", $pregunta, $idCategoria, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC, $respuestaCorrecta);
        $stmt->execute();
    }

    public function traerTodasLasPreguntas($estado)
    {
        $sql = "SELECT p.id_pregunta, p.descripción as pregunta, c.descripción as categoria, p.opcion_correcta as correcta, p.opcion_a, p.opcion_b, p.opcion_c, p.opcion_d, e.descripción as estado FROM pregunta p 
                LEFT JOIN estado e ON e.id_estado = p.id_estado
                LEFT JOIN categoria c ON c.id_categoria = p.id_categoria";
        if (!empty($estado)) {
            $sql .= " WHERE p.id_estado = $estado";
        }

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
        $sql = "SELECT p.id_pregunta, p.descripción as pregunta, c.descripción as categoria, p.opcion_correcta, p.opcion_a, p.opcion_b, p.opcion_c, p.opcion_d, e.descripción as estado  FROM pregunta p 
                LEFT JOIN estado e ON e.id_estado = p.id_estado
                LEFT JOIN categoria c ON c.id_categoria = p.id_categoria WHERE p.descripción = '$pregunta';";
        $result = $this->database->query($sql);
        return $result;
    }

    public function modificarPregunta($idPregunta, $pregunta, $categoria, $estado, $otraCategoria, $check, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC)
    {
        if (empty($pregunta)) {
            $errores['pregunta'] = "La pregunta no puede estar vacía.";
        }/*else{
            $preguntaOriginal = $this->buscarPreguntaPorId($idPregunta);
            if(!empty($preguntaOriginal)) {
                $result = $this->buscarPregunta($pregunta);
                if(!empty($result)){
                    $errores['pregunta'] = "La pregunta ya existe";
                }
            }
        }*/


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

        if(empty("estado")){
            $errores['estado'] = "El estado no puede estar vacio";
        }else{


                $result= $this->buscaEstado($estado);
                $estado = $result;

        }

        if (empty($errores)) {
            if (!empty($check) && !empty($otraCategoria)) {
                $idCategoria = $this->guardarCategoria($otraCategoria);
            }

            $result = $this->modificarPreguntaExistente($idPregunta,$pregunta, $estado, $idCategoria, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC);
            return $result?["modificado"]:["no se modifico"];
        } else {
            return $errores;
        }
    }

    private function modificarPreguntaExistente($idPregunta, $pregunta, $estado, $idCategoria, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC)
    {
        if ($estado['descripción'] != 'en_revision') {
            $reportes = 0;
        } else {
            $reportes = null;
        }

        $sql = "UPDATE pregunta SET `descripción`=?, `id_categoria`=?, `id_estado`=?, `opcion_a`=?, `opcion_b`=?, `opcion_c`=?, `opcion_d`=?, `opcion_correcta`=?, `reportes`=? WHERE id_pregunta = ?";
        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->bind_param("ssssssssss", $pregunta, $idCategoria, $estado['id_estado'], $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC, $respuestaCorrecta, $reportes, $idPregunta);
        $result = $stmt->execute();

        return $result;
    }

    private function buscarPreguntaPorId($idPregunta)
    {
        $sql = "SELECT descripción FROM pregunta WHERE id_pregunta = '$idPregunta'";
        $result = $this->database->query($sql);
        return $result;
    }

    private function buscaEstado($estado)
    {
        $sql = "SELECT * FROM estado WHERE descripción = '$estado'";
        $result = $this->database->query($sql);
        return $result[0];
    }
}