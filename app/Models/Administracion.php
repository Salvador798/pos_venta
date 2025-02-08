<?php

namespace App\Models;

use App\Config\Model;

class Administracion extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = self::select($sql);
        return $data;
    }
    public static function getDatos(string $table)
    {
        $sql = "SELECT COUNT(*) AS total FROM " . $table . " WHERE estado = 1";
        return self::select($sql);
    }
    public static function getVentas()
    {
        $sql = "SELECT COUNT(*) AS total FROM ventas WHERE fecha > CURDATE()";
        return self::select($sql);
    }
    public static function modificar(string $rif, string $nombre, string $telefono, string $dir, int $id)
    {

        $sql = "UPDATE configuracion SET rif = ?, nombre = ?, telefono = ?, direccion = ?, id = ?";
        $datos = array($rif, $nombre, $telefono, $dir, $id);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public static function getStockMinimo()
    {
        $sql = "SELECT * FROM productos WHERE cantidad < 15 ORDER BY cantidad DESC LIMIT 10";
        $data = self::selectAll($sql);
        return $data;
    }
    public static function getProductosVendidos()
    {
        $sql = "SELECT d.id_producto, d.cantidad, p.id, p.descripcion, SUM(d.cantidad) AS total FROM detalle_venta d INNER JOIN productos p ON p.id = d.id_producto GROUP BY d.id_producto ORDER BY d.cantidad DESC LIMIT 10";
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
