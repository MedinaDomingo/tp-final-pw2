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
    public function obtenerRankingDeUsuarios($currentPage = 1){
        $this->paginator->setCurrentPage($currentPage);
        $sql = "SELECT u.* FROM usuario u JOIN rol r ON u.id_rol = r.id_rol WHERE r.descripción = 'cliente' ORDER BY puntaje DESC";
        $result = $this->database->query($sql);
        $totalItems = count($result);

        $this->paginator->setTotalItems($totalItems);

        $offset = $this->paginator->getOffset();
        $limit = $this->paginator->perPage;

        $sql .= " LIMIT $limit OFFSET $offset";

        $result = $this->database->query($sql);
        $result = $this->calcularEdades($result);
        $result = $this->designarRankingUsuario($result);
        return [
            'users' => $result,
            'paginator' => [
                'currentPage' => $currentPage,
                'totalPages' => $this->paginator->getTotalPages(),
                'hasPreviousPage' => $currentPage > 1,
                'previousPage' => $currentPage - 1,
                'hasNextPage' => $currentPage < $this->paginator->getTotalPages(),
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