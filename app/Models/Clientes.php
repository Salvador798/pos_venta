<?php

namespace App\Models;

use App\Config\Model;

class Clientes extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function getClientes()
    {
        $sql = "SELECT * FROM clientes";
        $data = self::selectAll($sql);
        return $data;
    }

    public static function registrarCliente(string $dni, string $nombre, string $telefono, string $direccion)
    {
        $verificar = "SELECT * FROM clientes WHERE dni = '$dni'";
        $existe = self::select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO clientes (dni, nombre, telefono, direccion) VALUES (?,?,?,?)";
            $datos = array($dni, $nombre, $telefono, $direccion);
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

    public static function modificarCliente(string $dni, string $nombre, string $telefono, string $direccion, int $id)
    {
        $sql = "UPDATE clientes SET dni = ?, nombre = ?, telefono = ?, direccion = ? WHERE id = ?";
        $datos = array($dni, $nombre, $telefono, $direccion, $id);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public static function editarCli(int $id)
    {
        $sql = "SELECT * FROM clientes WHERE id = $id";
        $data = self::select($sql);
        return $data;
    }

    public static function accionCli(int $estado, int $id)
    {
        $sql = "UPDATE clientes SET estado = ? WHERE id = ?";
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
