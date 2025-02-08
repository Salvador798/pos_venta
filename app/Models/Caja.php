<?php

namespace App\Models;

use App\Config\Model;

class Caja extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function getCajas(string $table)
    {
        $sql = "SELECT * FROM $table";
        $data = self::selectAll($sql);
        return $data;
    }
    public static function registrarCajas(string $caja)
    {
        $verificar = "SELECT * FROM caja WHERE caja = '$caja'";
        $existe = self::select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO caja (caja) VALUES (?)";
            $datos = array($caja);
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
    public static function modificarCajas(string $caja, int $id)
    {
        $sql = "UPDATE caja SET caja = ? WHERE id = ?";
        $datos = array($caja, $id);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public static function editarCaj(int $id)
    {
        $sql = "SELECT * FROM caja WHERE id = $id";
        $data = self::select($sql);
        return $data;
    }
    public static function accionCaj(int $estado, int $id)
    {
        $sql = "UPDATE caja SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = self::save($sql, $datos);
        return $data;
    }
    public static function registrarArqueo(int $id_usuario, string $monto_inicial, string $fecha_apertura)
    {
        $verificar = "SELECT * FROM cierre_caja WHERE id_usuario = '$id_usuario' AND estado = 1";
        $existe = self::select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO cierre_caja (id_usuario, monto_inicial, fecha_apertura) VALUES (?,?,?)";
            $datos = array($id_usuario, $monto_inicial, $fecha_apertura);
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

    public static function getVentas(int $id_usuario)
    {
        $sql = "SELECT total, SUM(total) AS total FROM ventas WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = self::select($sql);
        return $data;
    }

    public static function getTotalVentas(int $id_usuario)
    {
        $sql = "SELECT COUNT(total) AS total FROM ventas WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = self::select($sql);
        return $data;
    }

    public static function getMontoInicial(int $id_usuario)
    {
        $sql = "SELECT id, monto_inicial FROM cierre_caja WHERE id_usuario = $id_usuario AND estado = 1";
        $data = self::select($sql);
        return $data;
    }

    public static function actualizarArqueo(string $final, string $cierre, string $ventas, string $general, int $id)
    {
        $sql = "UPDATE cierre_caja SET monto_final = ?, fecha_cierre = ?, total_ventas = ?, monto_total = ?, estado = ? WHERE id = ?";
        $datos = array($final, $cierre, $ventas, $general, 0, $id);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public static function actualizarApertura(int $id)
    {
        $sql = "UPDATE ventas SET apertura = ? WHERE id_usuario = ?";
        $datos = array(0, $id);
        self::save($sql, $datos);
    }

    public static function verificarPermiso(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d on p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = self::selectAll($sql);
        return $data;
    }
}
