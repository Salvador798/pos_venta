<?php

namespace App\Models;

use App\Config\Model;

class Medidas extends Model
{
    private $nombre, $id, $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getMedidas()
    {
        $sql = "SELECT * FROM medidas";
        $data = self::selectAll($sql);
        return $data;
    }

    public static function registrarMedidas(string $nombre)
    {
        $verificar = "SELECT * FROM medidas WHERE nombre = '$nombre'";
        $existe = self::select($verificar);

        if (empty($existe)) {
            $sql = "INSERT INTO medidas (nombre) VALUES (?)";
            $datos = array($nombre);
            $data = self::save($sql, $datos);

            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }

        return $res;
    }

    public static function modificarMedidas(string $nombre, int $id)
    {
        $sql = "UPDATE medidas SET nombre = ? WHERE id = ?";
        $datos = array($nombre, $id);
        $data = self::save($sql, $datos);

        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }

        return $res;
    }

    public static function editarMed(int $id)
    {
        $sql = "SELECT * FROM medidas WHERE id = $id";
        $data = self::select($sql);
        return $data;
    }

    public static function accionMed(int $estado, int $id)
    {
        $sql = "UPDATE medidas SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = self::save($sql, $datos);
        return $data;
    }

    public static function verificarPermiso(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d on p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = self::selectAll($sql);
        return $data;
    }
}
