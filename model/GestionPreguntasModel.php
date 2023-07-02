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
        } else {
            $result = $this->buscarPregunta($pregunta);
            if (!empty($result)) {
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
        if (empty($check)) {
            try {
                $idCategoria = $this->idCategoria($categoria);

            } catch (CategoriaNoExisteExeptions $e) {
                $errores['categoria'] = $e->getMessage();
            }
        }


        if (empty($errores)) {
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

    public function traerTodasLasCategorias($estado=null)
    {
        $sql = "SELECT c.descripción AS categoria, e.descripción AS estado FROM categoria  c LEFT JOIN estado e ON e.id_estado = c.id_estado";
        if($estado!=null){
            $sql .= " WHERE c.id_estado = $estado";
        }
        $result = $this->database->query($sql);
        return $result;
    }

    public function guardarCategoria($categoria)
    {
        $errores = [];

        if (empty($categoria)) {
            $errores['categoria'] = "La categoría no puede estar vacía.";
            return $errores;
        }

        $result = $this->buscarCategoria($categoria);
        if (!empty($result)) {
            $errores['categoria'] = "La categoría ya existe";
            return $errores;
        }

        $cat = 3;

        $sql = "INSERT INTO `categoria`(`descripción`, `id_estado`) VALUES (?, ?)";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("si", $categoria, $cat);
        return [$stmt->execute()];


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

        if (empty("estado")) {
            $errores['estado'] = "El estado no puede estar vacio";
        } else {
            $result = $this->buscaEstado($estado);
            $estado = $result;
        }
        try {
            $idCategoria = $this->idCategoria($categoria);

        } catch (CategoriaNoExisteExeptions $e) {
            $errores['categoria'] = $e->getMessage();
        }

        if (empty($errores)) {
            $result = $this->modificarPreguntaExistente($idPregunta, $pregunta, $estado, $idCategoria, $respuestaCorrecta, $respuestaIncorrectaA, $respuestaIncorrectaB, $respuestaIncorrectaC);
            return $result ? ["modificado"] : ["no se modifico"];
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

    public function buscarCategoria($categoria)
    {
        $sql = "SELECT c.id_categoria, c.descripción AS categoria, e.descripción AS estado FROM categoria  c LEFT JOIN estado e ON e.id_estado = c.id_estado WHERE c.descripción = '$categoria'";
        return $this->database->query($sql);;
    }
    public function eliminarCategoria($categoria)
    {
        $sql = "DELETE FROM `categoria` WHERE descripción = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("s", $categoria);
        $result = $stmt->execute();
        return $result;
    }

    public function modificarCategoria($idCategoria, $categoria, $estado)
    {
        $estado = $this->buscaEstado($estado);

        $sql = "UPDATE categoria SET `descripción`=?, `id_estado`=? WHERE id_categoria = ?";
        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->bind_param("sss", $categoria, $estado['id_estado'], $idCategoria);
        $result = $stmt->execute();

        return ["modificado"];
    }
}