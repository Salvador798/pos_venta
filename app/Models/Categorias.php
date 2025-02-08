<?php

namespace App\Models;

use App\Config\Model;

class Categorias extends Model
{
    public static function getCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $data = self::selectAll($sql);
        return $data;
    }

    public static function registrarCategorias(string $nombre)
    {
        $verificar = "SELECT * FROM categorias WHERE nombre = '$nombre'";
        $existe = self::select($verificar);

        if (empty($existe)) {
            $sql = "INSERT INTO categorias (nombre) VALUES (?)";
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

    public static function modificarCategorias(string $nombre, int $id)
    {
        $sql = "UPDATE categorias SET nombre = ? WHERE id = ?";
        $datos = array($nombre, $id);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public static function editarCat(int $id)
    {
        $sql = "SELECT * FROM categorias WHERE id = $id";
        $data = self::select($sql);
        return $data;
    }
    public static function accionCat(int $estado, int $id)
    {
        $sql = "UPDATE categorias SET estado = ? WHERE id = ?";
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
