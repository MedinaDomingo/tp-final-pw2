<?php

class MySqlDatabase {
    private $connection;

    public function __construct($serverName, $userName, $password, $databaseName) {
        $this->connection = mysqli_connect(
            $serverName,
            $userName,
            $password,
            $databaseName);

        if (!$this->connection) {
            die('Connection failed: ' . mysqli_connect_error());
        }
    }

    public function __destruct() {
        mysqli_close($this->connection);
    }

    public function query($sql) {
        $result = mysqli_query($this->connection, $sql);
        if (!$result) {
            die('Error en la consulta: ' . mysqli_error($this->connection));
        }
        return mysqli_fetch_all($result, MYSQLI_BOTH);
    }

    public function getConnection() {
        return $this->connection;
    }
}