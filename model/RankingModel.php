<?php
class RankingModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerRankingDeUsuarios()
    {
        $sql = "SELECT u.* FROM usuario u JOIN rol r ON u.id_rol = r.id_rol WHERE r.descripción = 'cliente' ORDER BY puntaje DESC";
        $result = $this->database->query($sql);
        $result = $this->calcularEdades($result);
        $result = $this->designarRankingUsuario($result);

        return [
            'users' => $result,
        ];
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
        $prev_puntaje = null;
        $ranking = 1;
        $sameRanking = 1;

        foreach ($result as &$row) {
            if ($row['puntaje'] !== $prev_puntaje) {
                $row['ranking'] = $ranking;
                $sameRanking = 1;
            } else {
                $row['ranking'] = $ranking - $sameRanking;
                $sameRanking++;
            }
            $ranking++;
            $prev_puntaje = $row['puntaje'];
        }

        return $result;
    }
}

