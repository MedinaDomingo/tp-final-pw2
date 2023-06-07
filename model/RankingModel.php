<?php

class RankingModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function obtenerRankingDeUsuarios(){
        $sql = "SELECT u.* FROM usuario u JOIN rol r ON u.id_rol = r.id_rol WHERE r.descripción = 'cliente' ORDER BY puntaje DESC";
        $result = $this->database->query($sql);

        $result = $this->calcularEdades($result);
        $result = $this->designarRankingUsuario($result);
        return ['users' => $result];
    }

    private function calcularEdades($result)
    {
        foreach ($result as &$row) {
            $fechaNacimiento = $row['fecha_nac'];

            $fechaActual = new DateTime();
            $fechaNac = new DateTime($fechaNacimiento);

            $edad = $fechaNac->diff($fechaActual)->y;

            $row['edad'] = $edad;
        }
        unset($row);
        return $result;
    }

    private function designarRankingUsuario($result)
    {
        $ranking = 0;
        $prev_puntaje = null;
        foreach ($result as &$row) {

            if ($prev_puntaje !== null && $row['puntaje'] != $prev_puntaje) {
                $ranking += 1;
            }
            $row['ranking'] = $ranking;
            $prev_puntaje = $row['puntaje'];
        }

        return $result;
    }
}