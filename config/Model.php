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
            return $result ? 1 : 0;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
