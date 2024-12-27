<?php

namespace App\Models;

use App\Config\Model;

class Compras extends Model
{
    private $nombre, $id, $estado;

    public function __construct()
    {
        parent::__construct();
    }
    public function getClientes()
    {
        $sql = "SELECT * FROM clientes WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProCod(string $cod)
    {
        $sql = "SELECT * FROM productos WHERE codigo = '$cod'";
        $data = $this->select($sql);
        return $data;
    }
    public function getProductos(int $id)
    {
        $sql = "SELECT * FROM productos WHERE id = '$id'";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalle(string $table, int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
    {
        $sql = "INSERT INTO $table (id_producto, id_usuario, precio, cantidad, sub_total) VALUE (?,?,?,?,?)";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function getDetalle(string $table, int $id)
    {
        $sql = "SELECT d.*, p.id AS id_pro, p.descripcion FROM $table d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = '$id'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function calcularCompra(string $table, int $id_usuario)
    {
        $sql = "SELECT d.sub_total, p.iva FROM $table d INNER JOIN productos p ON d.id_producto = p.id WHERE id_usuario = '$id_usuario'";
        $data = $this->selectAll($sql);

        $impuesto = 0.16;
        $exento = 0;
        $aplica = 0;

        foreach ($data as $row) {
            if ($row['iva'] === 'Exento') {
                $exento += $row['sub_total'];
            } else if ($row['iva'] === 'Aplica') {
                $aplica += $row['sub_total'];
            }
        }

        $iva = ($aplica * $impuesto);
        $total = $exento + ($aplica + $iva);

        return $total;
    }
    public function deleteDetalle(string $table, int $id)
    {
        $sql = "DELETE FROM $table WHERE id = ?";
        $datos = array($id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function consultarDetalle(string $table, int $id_producto, int $id_usuario)
    {
        $sql = "SELECT * FROM $table WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data;
    }
    public function actualizarDetalle(string $table, string $precio, int $cantidad, string $sub_total, int $id_producto, int $id_usuario)
    {
        $sql = "UPDATE $table SET precio = ?, cantidad = ?, sub_total = ? WHERE id_producto = ? AND id_usuario = ?";
        $datos = array($precio, $cantidad, $sub_total, $id_producto, $id_usuario);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function registrarCompra(string $total)
    {
        $sql = "INSERT INTO compras (total) VALUES (?)";
        $datos = array($total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function getId(string $table)
    {
        $sql = "SELECT MAX(id) AS id FROM $table";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalleCompra(int $id_compra, int $id_pro, int $cantidad, string $precio, string $sub_total)
    {
        $sql = "INSERT INTO detalle_compras (id_compra, id_producto, cantidad, precio, sub_total) VALUES (?,?,?,?,?)";
        $datos = array($id_compra, $id_pro, $cantidad, $precio, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function registrarDetalleVenta(int $id_venta, int $id_pro, int $cantidad, string $desc, string $precio, string $sub_total)
    {
        $sql = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, descuento, precio, sub_total) VALUES (?,?,?,?,?,?)";
        $datos = array($id_venta, $id_pro, $cantidad, $desc, $precio, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
    public function vaciarDetalle(string $table, int $id_usuario)
    {
        $sql = "DELETE FROM $table WHERE id_usuario = ?";
        $datos = array($id_usuario);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function getProCompra(int $id_compra)
    {
        $sql = "SELECT c.*, d.*, p.id, p.descripcion, p.iva FROM compras c INNER JOIN detalle_compras d ON c.id = d.id_compra INNER JOIN productos p ON p.id = d.id_producto WHERE c.id = $id_compra";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProVenta(int $id_venta)
    {
        $sql = "SELECT v.*, d.*, p.id, p.descripcion, p.iva FROM ventas v INNER JOIN detalle_venta d ON v.id = d.id_venta INNER JOIN productos p ON p.id = d.id_producto WHERE v.id = $id_venta";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getHistorialCompras()
    {
        $sql = "SELECT * FROM compras";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getHistorialVentas()
    {
        $sql = "SELECT c.id, c.nombre, v.* FROM clientes c INNER JOIN ventas v ON v.id_cliente = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function actualizarStock(int $cantidad, int $id_pro)
    {
        $sql = "UPDATE productos SET cantidad = ? WHERE id = ?";
        $datos = array($cantidad, $id_pro);
        $data = $this->save($sql, $datos);
        return $data;
    }
    public function registrarVenta(int $id_usuario, int $id_cliente, string $total)
    {
        $sql = "INSERT INTO ventas (id_usuario, id_cliente, total) VALUES (?,?,?)";
        $datos = array($id_usuario, $id_cliente, $total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function clientesVenta(int $id)
    {
        $sql = "SELECT v.id, v.id_cliente, c.* FROM ventas v INNER JOIN clientes c ON c.id = v.id_cliente WHERE v.id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function verificarDescuento($id)
    {
        $sql = "SELECT * FROM detalle_temp WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function actualizarDescuento(string $desc, string $sub_total, int $id)
    {
        $sql = "UPDATE detalle_temp SET descuento = ?, sub_total = ? WHERE id = ?";
        $datos = array($desc, $sub_total, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function getDescuento(int $id_venta)
    {
        $sql = "SELECT descuento, SUM(descuento) AS total FROM detalle_venta WHERE id_venta = '$id_venta'";
        $data = $this->select($sql);
        return $data;
    }
    public function getAnularCompra(int $id_compra)
    {
        $sql = "SELECT c.*, d.* FROM compras c INNER JOIN detalle_compras d ON c.id = d.id_compra WHERE c.id = $id_compra";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getAnular(int $id_compra)
    {
        $sql = "UPDATE compras SET estado = ? WHERE id = ?";
        $datos = array(0, $id_compra);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getAnularVenta(int $id_venta)
    {
        $sql = "SELECT v.*, d.* FROM ventas v INNER JOIN detalle_venta d ON v.id = d.id_venta WHERE v.id = $id_venta";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getAnularV(int $id_venta)
    {
        $sql = "UPDATE ventas SET estado = ? WHERE id = ?";
        $datos = array(0, $id_venta);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function verificarCaja(int $id)
    {
        $sql = "SELECT * FROM cierre_caja WHERE id_usuario = $id AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function getRangoFechas(string $desde, string $hasta)
    {
        $sql = "SELECT c.id, c.nombre, p.id, p.descripcion, v.* FROM clientes c INNER JOIN ventas v ON v.id_cliente = c.id INNER JOIN productos p ON v.id_producto = p.descripcion WHERE v.fecha BETWEEN '$desde' AND '$hasta'";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getRangoFechasCompra(string $desde, string $hasta)
    {
        $sql = "SELECT p.id, p.descripcion, c.* FROM productos p INNER JOIN compras c ON c.id_producto = p.descripcion WHERE c.fecha BETWEEN '$desde' AND '$hasta'";
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
