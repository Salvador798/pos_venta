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
        try {
            // Obtener TODAS las cajas del usuario para verificar manualmente
            $sql = "SELECT id, estado FROM cierre_caja WHERE id_usuario = ?";
            $todasLasCajas = self::selectAll($sql, [$id_usuario]);
            
            // Verificar si hay alguna con estado = 1
            $cajaAbierta = null;
            if (is_array($todasLasCajas) && !empty($todasLasCajas)) {
                foreach ($todasLasCajas as $caja) {
                    $estado = isset($caja['estado']) ? intval($caja['estado']) : 0;
                    if ($estado === 1) {
                        $cajaAbierta = $caja;
                        break;
                    }
                }
            }
            
            // Si encontramos una caja con estado = 1, está abierta
            if ($cajaAbierta !== null && isset($cajaAbierta['id'])) {
                error_log("Intento de abrir caja cuando ya existe una abierta - Usuario: $id_usuario, ID Caja: " . $cajaAbierta['id']);
                return "existe";
            }
            
            // Validar que el monto inicial sea válido
            // NOTA: No se compara con montos de cajas anteriores. El usuario puede usar cualquier monto.
            if (!is_numeric($monto_inicial) || floatval($monto_inicial) < 0) {
                error_log("Monto inicial inválido - Usuario: $id_usuario, Monto: $monto_inicial");
                return "error";
            }
            
            // No existe caja abierta, proceder a insertar
            // El monto inicial puede ser cualquier valor numérico >= 0, sin importar cajas anteriores
            // Nota: monto_final, fecha_cierre, total_ventas son NOT NULL, así que debemos proporcionar valores por defecto
            $sql = "INSERT INTO cierre_caja (id_usuario, monto_inicial, monto_final, fecha_apertura, fecha_cierre, total_ventas, monto_total, estado) VALUES (?,?,?,?,?,?,?,?)";
            $datos = array($id_usuario, $monto_inicial, 0.00, $fecha_apertura, '0000-00-00', 0, 0.00, 1);
            $data = self::save($sql, $datos);
            
            // save() devuelve 1 si es exitoso, 0 si falla, false si hay excepción
            if ($data === 1) {
                $res = "ok";
                error_log("Caja abierta exitosamente - Usuario: $id_usuario, Monto: $monto_inicial");
            } else {
                error_log("Error al insertar en cierre_caja - Usuario: $id_usuario, Monto: $monto_inicial, Fecha: $fecha_apertura, Resultado: " . var_export($data, true));
                $res = "error";
            }
        } catch (\Exception $e) {
            error_log("Excepción en registrarArqueo: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
            $res = "error";
        } catch (\Error $e) {
            error_log("Error fatal en registrarArqueo: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
            $res = "error";
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

    /**
     * Obtener todas las cajas abiertas de un usuario (para debugging)
     */
    public static function getCajasAbiertas(int $id_usuario)
    {
        // Obtener todas las cajas y filtrar manualmente
        $sql = "SELECT id, monto_inicial, fecha_apertura, estado FROM cierre_caja WHERE id_usuario = ?";
        $data = self::selectAll($sql, [$id_usuario]);
        if ($data === false || !is_array($data)) {
            return array();
        }
        
        // Filtrar solo las que realmente tienen estado = 1
        $resultado = array();
        foreach ($data as $row) {
            $estado = isset($row['estado']) ? intval($row['estado']) : 0;
            if ($estado === 1) {
                $resultado[] = $row;
            }
        }
        return $resultado;
    }
    
    /**
     * Obtener todas las cajas de un usuario (para debugging completo)
     */
    public static function getAllCajasUsuario(int $id_usuario)
    {
        $sql = "SELECT id, monto_inicial, fecha_apertura, fecha_cierre, estado FROM cierre_caja WHERE id_usuario = ? ORDER BY id DESC";
        $data = self::selectAll($sql, [$id_usuario]);
        return $data !== false && is_array($data) ? $data : array();
    }
}
