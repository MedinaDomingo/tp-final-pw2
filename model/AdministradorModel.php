<?php

class AdministradorModel
{
    private $database;
    private $pdf;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function traerCantidadPartidas($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT count(*) AS cantidad_partidas FROM partida WHERE 1=1";

        if ($fecha_inicial && $fecha_final) {
            $sql .= " AND fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'";
        } elseif ($fecha_inicial) {
            $sql .= " AND fecha_registro >= '$fecha_inicial'";
        } elseif ($fecha_final) {
            $sql .= " AND fecha_registro <= '$fecha_final'";
        }

        $result = $this->database->query($sql);

        return $result[0];
    }
    public function traerCantidadClientes($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT count(*) AS cantidad_clientes FROM usuario u WHERE u.id_rol = 1";

        if ($fecha_inicial && $fecha_final) {
            $sql .= " AND fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'";
        } elseif ($fecha_inicial) {
            $sql .= " AND fecha_registro >= '$fecha_inicial'";
        } elseif ($fecha_final) {
            $sql .= " AND fecha_registro <= '$fecha_final'";
        }

        $result = $this->database->query($sql);

        return $result[0];
    }
    public function cantidadPreguntasEnJuego($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT count(*) AS cantidad_preguntas FROM pregunta p WHERE p.id_estado = 2";

        if ($fecha_inicial && $fecha_final) {
            $sql .= " AND fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'";
        } elseif ($fecha_inicial) {
            $sql .= " AND fecha_registro >= '$fecha_inicial'";
        } elseif ($fecha_final) {
            $sql .= " AND fecha_registro <= '$fecha_final'";
        }

        $result = $this->database->query($sql);

        return $result[0];
    }
    public function cantidadPreguntasCreadas($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT count(*) AS cantidad_preguntas_creadas FROM pregunta p WHERE p.id_estado = 3";

        if ($fecha_inicial && $fecha_final) {
            $sql .= " AND fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'";
        } elseif ($fecha_inicial) {
            $sql .= " AND fecha_registro >= '$fecha_inicial'";
        } elseif ($fecha_final) {
            $sql .= " AND fecha_registro <= '$fecha_final'";
        }

        $result = $this->database->query($sql);

        return $result[0];
    }
    public function cantidadUsuariosPorSexo($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT sexo, COUNT(*) AS cantidad FROM usuario WHERE id_rol = 1 ";


        if ($fecha_inicial && $fecha_final) {
            $sql .= " AND fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'";
        } elseif ($fecha_inicial) {
            $sql .= " AND fecha_registro >= '$fecha_inicial'";
        } elseif ($fecha_final) {
            $sql .= " AND fecha_registro <= '$fecha_final'";
        }

        $sql .= " GROUP BY sexo ORDER BY sexo ASC";


        $result = $this->database->query($sql);

        return $result;
    }
    public function cantidadUsuariosPorPais($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT pais, COUNT(*) AS cantidad FROM usuario WHERE id_rol = 1";

        if ($fecha_inicial && $fecha_final) {
            $sql .= " AND fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'";
        } elseif ($fecha_inicial) {
            $sql .= " AND fecha_registro >= '$fecha_inicial'";
        } elseif ($fecha_final) {
            $sql .= " AND fecha_registro <= '$fecha_final'";
        }

        $sql .= " GROUP BY pais";

        $result = $this->database->query($sql);

        return json_encode($result);
    }


    public function cantidadUsuariosRangoEtario($fecha_inicial, $fecha_final)
    {

        $fecha_final_condition = ($fecha_final) ? "AND fecha_registro <= '$fecha_final'" : "";

        if ($fecha_inicial && $fecha_final) {
            $fecha_condition = "WHERE fecha_registro >= '$fecha_inicial' AND fecha_registro <= '$fecha_final'";
        } elseif ($fecha_inicial) {
            $fecha_condition = "WHERE fecha_registro >= '$fecha_inicial'";
        } elseif ($fecha_final) {
            $fecha_condition = "WHERE fecha_registro <= '$fecha_final'";
        }

        $sql = "SELECT
            CASE
                WHEN DATEDIFF(CURDATE(), fecha_nac) < 18 * 365 THEN 'menores'
                WHEN DATEDIFF(CURDATE(), fecha_nac) >= 18 * 365 AND DATEDIFF(CURDATE(), fecha_nac) <= 65 * 365 THEN 'medio'
                ELSE 'jubilados'
            END AS grupo_edad,
            COUNT(*) AS cantidad
        FROM usuario
        WHERE fecha_registro >= '$fecha_inicial' $fecha_final_condition
        AND id_rol = 1
        GROUP BY grupo_edad";



        $result = $this->database->query($sql);

        return json_encode($result);
    }



}