<?php
class PartidaModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function obtenerPregunta()
    {
        // Lógica para obtener una nueva pregunta de la base de datos

        $pregunta = [
            'id_pregunta' => 1,
            'descripción' => '¿Cuál es la capital de Francia?',
            'respuestas' => [
                ['id_respuesta' => 1, 'descripción' => 'París'],
                ['id_respuesta' => 2, 'descripción' => 'Londres'],
                ['id_respuesta' => 3, 'descripción' => 'Roma'],
                ['id_respuesta' => 4, 'descripción' => 'Madrid'],
            ],
        ];

        return $pregunta;
    }
}

