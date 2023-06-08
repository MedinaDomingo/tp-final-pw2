<?php
include_once("./helpers/Paginator.php");
class RankingModel
{
    private $database;
    private $paginator;

    public function __construct($database)
    {
        $this->database = $database;
        $this->paginator = new Paginator(3); // El número 10 representa la cantidad de usuarios por página.
    }
    public function obtenerRankingDeUsuarios($currentPage = 1,  $perPage = 3){
        $sqlCount = "SELECT COUNT(*) AS total FROM usuario u JOIN rol r ON u.id_rol = r.id_rol WHERE r.descripción = 'cliente'";
        $countResult = $this->database->query($sqlCount);
        $totalItems = $countResult[0]['total'];

        $totalPages = ceil($totalItems / $perPage);

        $offset = ($currentPage - 1) * $perPage;

        $sql = "SELECT u.* FROM usuario u JOIN rol r ON u.id_rol = r.id_rol WHERE r.descripción = 'cliente' ORDER BY puntaje DESC LIMIT $offset, $perPage";
        $result = $this->database->query($sql);
        $result = $this->calcularEdades($result);
        $result = $this->designarRankingUsuario($result, $currentPage, $offset);

        return [
            'users' => $result,
            'paginator' => [
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'hasPreviousPage' => $currentPage > 1,
                'previousPage' => $currentPage - 1,
                'hasNextPage' => $currentPage < $totalPages,
                'nextPage' => $currentPage + 1,
            ],
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

    private function designarRankingUsuario($result, $currentPage, $offset)
    {
        $startRanking = $offset + 1;
        $prev_puntaje = null;
        $ranking = $startRanking;

        foreach ($result as &$row) {
            if ($row['puntaje'] !== $prev_puntaje) {
                $ranking = $startRanking;
            }
            $row['ranking'] = $ranking;
            $ranking++;
            $prev_puntaje = $row['puntaje'];
        }

        return $result;
    }
}