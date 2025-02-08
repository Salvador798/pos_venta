<?php

namespace App\Models;

use App\Config\Model;

class Productos extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public static function getMedidas()
    {
        $sql = "SELECT * FROM medidas WHERE estado = 1";
        $data = self::selectAll($sql);
        return $data;
    }
    public static function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        $data = self::selectAll($sql);
        return $data;
    }
    public static function getProductos()
    {
        $sql = "SELECT p.*, m.id AS id_medida, m.nombre AS medida, c.id AS id_cat, c.nombre AS categoria FROM productos p INNER JOIN medidas m ON p.id_medida = m.id INNER JOIN categorias c ON p.id_categoria = c.id";
        $data = self::selectAll($sql);
        return $data;
    }
    public static function registrarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, string $iva, int $id_medida, int $id_categoria, string $img)
    {
        $verificar = "SELECT * FROM productos WHERE codigo = '$codigo'";
        $existe = self::select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO productos (codigo, descripcion, precio_compra, precio_venta, iva, id_medida, id_categoria, foto) VALUES (?,?,?,?,?,?,?,?)";
            $datos = array($codigo, $nombre, $precio_compra, $precio_venta, $iva, $id_medida, $id_categoria, $img);
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
    public static function modificarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, string $iva, int $id_medida, int $id_categoria, string $img, int $id)
    {
        $sql = "UPDATE productos SET codigo = ?, descripcion = ?, precio_compra = ?, precio_venta = ?, iva = ?, id_medida = ?, id_categoria = ?, foto = ? WHERE id = ?";
        $datos = array($codigo, $nombre, $precio_compra, $precio_venta, $iva, $id_medida, $id_categoria, $img, $id);
        $data = self::save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public static function editarPro(int $id)
    {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = self::select($sql);
        return $data;
    }
    public static function accionPro(int $estado, int $id)
    {
        $sql = "UPDATE productos SET estado = ? WHERE id = ?";
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
