<?php

namespace App\Config;

use PDO;

class Model extends Conexion
{
    private static $pdo;

    public static function init()
    {
        if (self::$pdo === null) {
            $conexion = new Conexion();
            self::$pdo = $conexion->conect();
        }
    }

    public static function select(string $sql, array $params = [])
    {
        self::init();
        try {
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function selectAll(string $sql, array $params = [])
    {
        self::init();
        try {
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function save(string $sql, array $params)
    {
        self::init();
        try {
            $stmt = self::$pdo->prepare($sql);
            $result = $stmt->execute($params);
            
            if ($result) {
                // Verificar si fue un INSERT y obtener el número de filas afectadas
                $rowCount = $stmt->rowCount();
                if ($rowCount > 0) {
                    return 1;
                } else {
                    error_log("Warning: save() ejecutado pero 0 filas afectadas. SQL: $sql");
                    return 0;
                }
            } else {
                error_log("Error: execute() devolvió false. SQL: $sql");
                return 0;
            }
        } catch (\PDOException $e) {
            error_log("PDO Error en save(): " . $e->getMessage() . " | SQL: " . $sql . " | Params: " . json_encode($params));
            return false;
        }
    }
}
