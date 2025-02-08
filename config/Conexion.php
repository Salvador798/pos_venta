<?php

namespace App\Config;

use PDO;
use PDOException;

class Conexion
{
    protected $conexion;

    public function __construct()
    {
        require_once __DIR__ . '/./Config.php';

        try {
            $pdo = "mysql:host=" . DB_SERVER . ';dbname=' . DB_NAME;
            $this->conexion = new \PDO($pdo, DB_USER, DB_PASS);
            $this->conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    public function conect()
    {
        return $this->conexion;
    }
}
