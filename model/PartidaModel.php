<?php

class PartidaModel
{
    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }
    public function obtenerPreguntaAleatoria() {
        // Obtener una pregunta aleatoria de la base de datos
        $query = "SELECT * FROM pregunta ORDER BY RAND() LIMIT 1";
        $result = $this->database->query($query);

        return $result;
    }

    public function verificarRespuesta($idPregunta, $opcionSeleccionada) {
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

    public function incrementarPuntaje($idUsuario)
    {
        $query = "UPDATE usuario SET puntaje = puntaje + 1 WHERE id_usuario = ?";

        $stmt = $this->database->getConnection()->prepare($query);
        $stmt->bind_param('s', $idUsuario);
        $stmt->execute();
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


}


