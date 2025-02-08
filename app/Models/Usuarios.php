<?php

namespace App\Models;

use App\Config\Model;

class Usuarios extends Model
{
    public static function getUsuario(string $usuario, string $clave)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $param = [$usuario, $clave];
        $data = self::select($sql, $param);
        return $data;
    }

    public static function getCajas()
    {
        $sql = "SELECT * FROM caja WHERE estado = 1";
        $data = self::selectAll($sql);
        return $data;
    }

    public static function getUsuarios()
    {
        $sql = "SELECT u.*, c.id as id_caja, c.caja FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id";
        $data = self::selectAll($sql);
        return $data;
    }

    public static function registrarUsuario(string $usuario, string $nombre, string $clave, int $id_caja)
    {
        $verificar = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $existe = self::select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO usuarios (usuario, nombre, clave, id_caja) VALUES (?,?,?,?)";
            $datos = array($usuario, $nombre, $clave, $id_caja);
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

    public static function modificarUsuario(string $usuario, string $nombre, int $id_caja, int $id)
    {
        $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, id_caja = ? WHERE id = ?";
        $datos = array($usuario, $nombre, $id_caja, $id);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public static function editarUser(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = self::select($sql);
        return $data;
    }

    public static function getPass(string $clave, int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE clave = '$clave' AND id = $id";
        $data = self::select($sql);
        return $data;
    }

    public static function accionUser(int $estado, int $id)
    {
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = self::save($sql, $datos);
        return $data;
    }

    public static function modificarPass(string $clave, int $id)
    {
        $sql = "UPDATE usuarios SET clave = ? WHERE id = ?";
        $datos = array($clave, $id);
        $data = self::save($sql, $datos);
        return $data;
    }

    public static function getPermisos()
    {
        $sql = "SELECT * FROM permisos";
        $data = self::selectAll($sql);
        return $data;
    }

    public static function registrarPermisos(int $id_user, int $id_permiso)
    {
        $sql = "INSERT INTO detalle_permisos (id_usuario, id_permiso) VALUES (?, ?)";
        $datos = array($id_user, $id_permiso);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = 'ok';
        } else {
            $res = 'error';
        }
        return $res;
    }

    public static function eliminarPermisos(int $id_user)
    {
        $sql = "DELETE FROM detalle_permisos WHERE id_usuario = ?";
        $datos = array($id_user);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = 'ok';
        } else {
            $res = 'error';
        }
        return $res;
    }

    public static function getDetallePermisos(int $id_user)
    {
        $sql = "SELECT * FROM detalle_permisos WHERE id_usuario = $id_user";
        $data = self::selectAll($sql);
        return $data;
    }

    public static function verificarPermiso(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d on p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = self::selectAll($sql);
        return $data;
    }
}
