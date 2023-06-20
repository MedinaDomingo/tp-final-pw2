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

        if ($result) {
            return $result->fetch_assoc();
        }

        return null;
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

        // Verificar si la opción seleccionada coincide con la respuesta correcta
        return $opcionSeleccionada === $opcionCorrecta;
    }
}


