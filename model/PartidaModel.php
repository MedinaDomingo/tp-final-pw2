<?php

class PartidaModel
{
    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    // Obtener una pregunta aleatoria de la base de datos
    public function obtenerPreguntaAleatoria($preguntasRealizadas, $u_id)
    {
        $query = "SELECT id_nivel FROM usuario WHERE usuario.id_usuario = '$u_id'";
        $dif = $this->database->query($query)[0]['id_nivel'];

        if (count($preguntasRealizadas) > 0) {
            $query = "SELECT * FROM pregunta WHERE dificultad = $dif AND id_estado = 2 AND id_pregunta NOT IN (" . implode(",", $preguntasRealizadas) . ") ORDER BY RAND() LIMIT 1";
        } else {
            $query = "SELECT * FROM pregunta WHERE dificultad = $dif AND id_estado = 2 ORDER BY RAND() LIMIT 1";
        }

        $result = $this->database->query($query);


        $result[0]['id_categoria'] ?? null;

        if (array_key_exists(0, $result)) {
            $id_cat = $result[0]['id_categoria'];

            $query = "SELECT descripción FROM categoria WHERE categoria.id_categoria = $id_cat";

            array_push($result, $this->database->query($query)[0]);
        }

        return $result;
    }

    public function verificarRespuesta($idPregunta, $opcionSeleccionada)
    {
        $opcionCorrecta = null;
        // Obtener la respuesta correcta de la pregunta
        $query = "SELECT opcion_correcta FROM pregunta WHERE id_pregunta = ?";
        $statement = $this->database->prepare($query);
        $statement->bind_param("i", $idPregunta);
        $statement->execute();
        $statement->bind_result($opcionCorrecta);

        // Obtener el valor de $opcionCorrecta
        $statement->fetch();
        $statement->close();
        $statement->bindParam("i", $idPregunta);

        // Verificar si la opción seleccionada coincide con la respuesta correcta
        return $opcionSeleccionada === $opcionCorrecta;
    }

    public function obtenerPreguntaActual($idPartida)
    {
        $query = "SELECT p.* FROM pregunta p 
                  INNER JOIN partida pa ON p.id_pregunta = pa.id_pregunta 
                  WHERE pa.id_partida = :id_partida 
                  ORDER BY p.id_pregunta DESC 
                  LIMIT 1";

        $stmt = $this->database->prepare($query);
        $stmt->bindParam(':id_partida', $idPartida);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPregunta($pregunta)
    {
        $query = "SELECT p.* FROM pregunta p 
              WHERE p.descripción = '$pregunta'";

        $stmt = $this->database->query($query);

        return $stmt[0];
    }

    public function obtenerPuntaje($idUsuario)
    {
        $query = "SELECT u.puntaje FROM usuario u 
              WHERE u.id_usuario = '$idUsuario'";

        $stmt = $this->database->query($query);

        return $stmt[0]['puntaje'];
    }

    public function reportarPregunta($idPregunta)
    {
        $query = "SELECT reportes FROM pregunta where pregunta.id_pregunta = '$idPregunta'";
        $stmt = $this->database->query($query);

        $reportes = (int) $stmt[0]['reportes'] + 1;

        $query = "UPDATE pregunta SET reportes = ? WHERE pregunta.id_pregunta = ?";
        $sentencia = $this->database->getConnection()->prepare($query);
        $sentencia->bind_param("ss", $reportes, $idPregunta);
        $result = $sentencia->execute();


        if ($reportes > 20) {
            $query = "UPDATE pregunta SET id_estado = 1 WHERE pregunta.id_pregunta = ?";
            $sentencia = $this->database->getConnection()->prepare($query);
            $sentencia->bind_param("s", $idPregunta);
            $sentencia->execute();
        }

        return $result;
    }

    public function actualizarPuntaje($idUsuario, $puntaje)
    {
        $query = "UPDATE usuario SET puntaje = ? WHERE usuario.id_usuario = ?";
        $sentence = $this->database->getConnection()->prepare($query);
        $sentence->bind_param("ss", $puntaje, $idUsuario);
        $sentence->execute();

        if ($puntaje > 30 && $puntaje < 60) {
            $query = "UPDATE usuario SET id_nivel = 2 WHERE usuario.id_usuario = ?";
        } elseif ($puntaje > 60) {
            $query = "UPDATE usuario SET id_nivel = 3 WHERE usuario.id_usuario = ?";
        } else {
            $query = "UPDATE usuario SET id_nivel = 1 WHERE usuario.id_usuario = ?";
        }

        $sentence = $this->database->getConnection()->prepare($query);
        $sentence->bind_param("s", $idUsuario);
        $sentence->execute();
    }

    public function obtenerFotoPerfil($idUsuario)
    {
        $query = "SELECT foto_perfil FROM usuario WHERE id_usuario = ?";

        $stmt = $this->database->getConnection()->prepare($query);
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        $stmt->bind_result($fotoPerfil);
        $stmt->fetch();
        $stmt->close();

        return $fotoPerfil;
    }

    public function checkTimer()
    {
        if (!isset($_SESSION["GameTimer"])) {
            $_SESSION["GameTimer"] = $_POST['time'];
            return true;
        }

        $_SESSION["GameTimer"] -= 1;

        if ($_SESSION["GameTimer"] <= 0) {
            return false;
        }

        return true;
    }

}