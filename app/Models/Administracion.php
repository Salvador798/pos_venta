<?php

namespace App\Models;

use App\Config\Model;

class Administracion extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
    public function getDatos(string $table)
    {
        $sql = "SELECT COUNT(*) AS total FROM " . $table . " WHERE estado = 1";
        return $this->select($sql);
    }
    public function getVentas()
    {
        $sql = "SELECT COUNT(*) AS total FROM ventas WHERE fecha > CURDATE()";
        return $this->select($sql);
    }
    public function modificar(string $ruc, string $nombre, string $telefono, string $dir, string $mensaje, int $id)
    {

        $sql = "UPDATE configuracion SET ruc = ?, nombre = ?, telefono = ?, direccion = ?, mensaje = ?, id = ?";
        $datos = array($ruc, $nombre, $telefono, $dir, $mensaje, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function getStockMinimo()
    {
        $sql = "SELECT * FROM productos WHERE cantidad < 15 ORDER BY cantidad DESC LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProductosVendidos()
    {
        $sql = "SELECT d.id_producto, d.cantidad, p.id, p.descripcion, SUM(d.cantidad) AS total FROM detalle_venta d INNER JOIN productos p ON p.id = d.id_producto GROUP BY d.id_producto ORDER BY d.cantidad DESC LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function verificarPermiso(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d on p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
