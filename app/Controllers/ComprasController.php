<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Compras;
use FPDF;

class ComprasController extends Controller
{
    protected $model;

    public function __construct()
    {
        session_start();
        parent::__construct();
        $this->model = new Compras();
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'nueva_compra');
        if (!empty($verificar) || $id_user == 1) {
            echo \view('Compras/index');
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function historial()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'historial_compra');
        if (!empty($verificar) || $id_user == 1) {
            echo view('Compras/historial');
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function ventas()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'nueva_venta');
        if (!empty($verificar) || $id_user == 1) {
            $data = $this->model->getClientes();
            echo view('Compras/ventas', $data);
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }
    public function historial_ventas()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'historial_venta');
        if (!empty($verificar) || $id_user == 1) {
            echo \view('Compras/historial_ventas');
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function buscarCodigo($cod)
    {
        $data = $this->model->getProCod($cod);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ingresar()
    {
        $id = $_POST["id"];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos['precio_compra'];
        $cantidad = $_POST['cantidad'];
        $comprobar = $this->model->consultarDetalle('detalle', $id_producto, $id_usuario);
        if (empty($comprobar)) {
            $sub_total = $precio * $cantidad;
            $data = $this->model->registrarDetalle('detalle', $id_producto, $id_usuario, $precio, $cantidad, $sub_total);
            if ($data == "ok") {
                $msg = array('msg' => 'Producto ingresado a la compra', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al ingresar el producto a la compra', 'icono' => 'error');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            $data = $this->model->actualizarDetalle('detalle', $precio, $total_cantidad, $sub_total, $id_producto, $id_usuario,);
            if ($data == "modificado") {
                $msg = array('msg' => 'Producto actualizado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al actualizar el producto a la compra', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ingresarVenta()
    {
        $id = $_POST["id"];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos['precio_venta'];
        $cantidad = $_POST['cantidad'];
        $comprobar = $this->model->consultarDetalle('detalle_temp', $id_producto, $id_usuario);
        if (empty($comprobar)) {
            if ($datos['cantidad'] >= $cantidad) {
                $sub_total = $precio * $cantidad;
                $data = $this->model->registrarDetalle('detalle_temp', $id_producto, $id_usuario, $precio, $cantidad, $sub_total);
                if ($data == "ok") {
                    $msg = array('msg' => 'Producto ingresado a la venta', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al ingresar el producto a la venta', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'Stock disponible ' . $datos['cantidad'], 'icono' => 'warning');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            if ($datos['cantidad'] < $total_cantidad) {
                $msg = array('msg' => 'Stock no disponible', 'icono' => 'warning');
            } else {
                $data = $this->model->actualizarDetalle('detalle_temp', $precio, $total_cantidad, $sub_total, $id_producto, $id_usuario,);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Producto actualizado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al actualizar el producto a la compra', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listar($table)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->model->getDetalle($table, $id_usuario);
        $data['total_pagar'] = $this->model->calcularCompra($table, $id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function delete($id)
    {
        $data = $this->model->deleteDetalle('detalle', $id);
        if ($data == 'ok') {
            $msg = array('msg' => 'Producto eliminado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el Producto', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }
    public function deleteVenta($id)
    {
        $data = $this->model->deleteDetalle('detalle_temp', $id);
        if ($data == 'ok') {
            $msg = array('msg' => 'Producto eliminado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el Producto', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }
    public function registrarCompra()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->model->calcularCompra('detalle', $id_usuario);
        $data = $this->model->registrarCompra($total);
        if ($data == 'ok') {
            $detalle = $this->model->getDetalle('detalle', $id_usuario);
            $id_compra = $this->model->getId('compras');
            foreach ($detalle as $row) {
                $cantidad = $row['cantidad'];
                $precio = $row['precio'];
                $id_pro = $row['id_producto'];
                $sub_total = $cantidad * $precio;
                $this->model->registrarDetalleCompra($id_compra['id'], $id_pro, $cantidad, $precio, $sub_total);
                $stock_actual = $this->model->getProductos($id_pro);
                $stock = $stock_actual['cantidad'] + $cantidad;
                $this->model->actualizarStock($stock, $id_pro);
            }
            $vaciar = $this->model->vaciarDetalle('detalle', $id_usuario);
            if ($vaciar == 'ok') {
                $msg = array('msg' => 'ok', 'id_compra' => $id_compra['id']);
            }
        } else {
            $msg = 'Error al realizar la compra';
        }
        echo json_encode($msg);
        die();
    }
    public function registrarVenta($id_cliente)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarCaja($id_usuario);
        if (empty($verificar)) {
            $msg = array('msg' => 'La caja está cerrada', 'icono' => 'warning');
        } else {
            $total = $this->model->calcularCompra('detalle_temp', $id_usuario);
            $data = $this->model->registrarVenta($id_usuario, $id_cliente, $total);
            if ($data == 'ok') {
                $detalle = $this->model->getDetalle('detalle_temp', $id_usuario);
                $id_venta = $this->model->getId('ventas');
                foreach ($detalle as $row) {
                    $cantidad = $row['cantidad'];
                    $desc = $row['descuento'];
                    $precio = $row['precio'];
                    $id_pro = $row['id_producto'];
                    $sub_total = ($cantidad * $precio) - $desc;
                    $this->model->registrarDetalleVenta($id_venta['id'], $id_pro, $cantidad, $desc, $precio, $sub_total);
                    $stock_actual = $this->model->getProductos($id_pro);
                    $stock = $stock_actual['cantidad'] - $cantidad;
                    $this->model->actualizarStock($stock, $id_pro);
                }
                $vaciar = $this->model->vaciarDetalle('detalle_temp', $id_usuario);
                if ($vaciar == 'ok') {
                    $msg = array('msg' => 'ok', 'id_venta' => $id_venta['id']);
                }
            } else {
                $msg = array('msg' => 'Error al realizar la venta', 'icono' => 'error');
            }
        }
        echo json_encode($msg);
        die();
    }

    public function generarPdf($id_compra)
    {
        // Iniciar el almacenamiento en búfer de salida
        ob_start();

        $empresa = $this->model->getEmpresa();
        $productos = $this->model->getProCompra($id_compra);
        require('Libraries/fpdf/fpdf.php');

        $pdf = new FPDF('P', 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Compra');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, mb_convert_encoding($empresa['nombre'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

        // Ruc
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'RIF ', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, $empresa['ruc'], 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, 'DATOS DEL CLIENTE', 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, 'VENTAS AL CONTADO', 0, 1, 'L');

        // Folio
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'FACTURA: ', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(40, 5, $id_compra, 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, 'FECHA Y HORA');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, $productos[0]['fecha'], 0, 1, 'R');

        // Separador
        $pdf->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < 37; $i++) {
            $pdf->Cell(2, 5, '-', 0, 0, '');
        }
        $pdf->Ln();

        // Encabezado del producto
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(35, 5, mb_convert_encoding('Descripción', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L', true);
        $pdf->Cell(10, 5, 'Cant', 0, 0, 'L', true);
        $pdf->Cell(15, 5, 'Total', 0, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);

        $total = 0.00;
        foreach ($productos as $row) {
            $total += $row['sub_total'];
            $pdf->Cell(35, 5, mb_convert_encoding($row['descripcion'], 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->Cell(10, 5, $row['cantidad'], 0, 0, 'L');
            $pdf->Cell(15, 5, 'Bs ' . number_format($row['sub_total'], 2, '.', ','), 0, 1, 'L');
        }
        $pdf->Ln();

        // Separador
        $pdf->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < 37; $i++) {
            $pdf->Cell(2, 5, '-', 0, 0, '');
        }
        $pdf->Ln();

        $impuesto = 0.16;
        $exento = 0;
        $aplica = 0;

        foreach ($productos as $producto) {
            if ($producto['iva'] === "Exento") {
                $exento += $producto['sub_total'];
            } else if ($producto['iva'] === 'Aplica') {
                $aplica += $producto['sub_total'];
            }
        }
        $iva = $aplica * $impuesto;

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'Sub Total', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($total, 2, ',', '.'), 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'EXENTO (E)', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($exento, 2, ',', '.'), 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'IVA (16%)', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($iva, 2, ',', '.'), 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'Total', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($productos[0]['total'], 2, ',', '.'), 0, 1, 'R');

        // Separador
        $pdf->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < 37; $i++) {
            $pdf->Cell(2, 5, '-', 0, 0, '');
        }
        $pdf->Ln();

        // Limpiar el búfer de salida antes de generar el PDF
        ob_end_clean();
        $pdf->Output();
    }

    public function listar_historial()
    {
        $data = $this->model->getHistorialCompras();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Completado</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-warning" onclick="btnAnularC(' . $data[$i]['id'] . ')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . APP_URL . "Compras/generarPdf/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Anulado</span>';
                $data[$i]['acciones'] = '<div>
                <a class="btn btn-danger" href="' . APP_URL . "Compras/generarPdf/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listar_historial_venta()
    {
        $data = $this->model->getHistorialVentas();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Completado</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-warning" onclick="btnAnularV(' . $data[$i]['id'] . ')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . APP_URL . "Compras/generarPdfVenta/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Anulado</span>';
                $data[$i]['acciones'] = '<div>
                <a class="btn btn-danger" href="' . APP_URL . "Compras/generarPdfVenta/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generarPdfVenta($id_venta)
    {
        // Iniciar el almacenamiento en búfer de salida
        ob_start();

        $empresa = $this->model->getEmpresa();
        $descuento = $this->model->getDescuento($id_venta);
        $productos = $this->model->getProVenta($id_venta);
        require('Libraries/fpdf/fpdf.php');

        $pdf = new FPDF('P', 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Venta');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, mb_convert_encoding($empresa['nombre'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

        // Ruc
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'RIF ', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, $empresa['ruc'], 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, 'DATOS DEL CLIENTE', 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, 'VENTAS AL CONTADO', 0, 1, 'L');

        // Folio
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'FACTURA: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 5, $id_venta, 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, 'FECHA Y HORA');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, $productos[0]['fecha'], 0, 1, 'R');

        // Separador
        $pdf->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < 37; $i++) {
            $pdf->Cell(2, 5, '-', 0, 0, '');
        }
        $pdf->Ln();

        // Encabezado del producto
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(35, 5, mb_convert_encoding('Descripción', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L', true);
        $pdf->Cell(10, 5, 'Cant', 0, 0, 'L', true);
        $pdf->Cell(15, 5, 'Sub Total', 0, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);

        $total = 0.00;
        foreach ($productos as $row) {
            $total += $row['sub_total'];
            $pdf->Cell(35, 5, mb_convert_encoding($row['descripcion'], 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->Cell(10, 5, $row['cantidad'], 0, 0, 'L');
            $pdf->Cell(15, 5, 'Bs ' . number_format($row['sub_total'], 2, '.', ','), 0, 1, 'L');
        }
        $pdf->Ln();

        // Separador
        $pdf->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < 37; $i++) {
            $pdf->Cell(2, 5, '-', 0, 0, '');
        }
        $pdf->Ln();

        $impuesto = 0.16;
        $exento = 0;
        $aplica = 0;

        foreach ($productos as $producto) {
            if ($producto['iva'] === "Exento") {
                $exento += $producto['sub_total'];
            } else if ($producto['iva'] === 'Aplica') {
                $aplica += $producto['sub_total'];
            }
        }
        $iva = $aplica * $impuesto;

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'Sub Total', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($total, 2, ',', '.'), 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'EXENTO (E)', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($exento, 2, ',', '.'), 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'IVA (16%)', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($iva, 2, ',', '.'), 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'Descuento Total', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($descuento['total'], 2, ',', '.'), 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9, 5, 'Total', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(58, 5, 'Bs ' . number_format($productos[0]['total'], 2, ',', '.'), 0, 1, 'R');

        // Separador
        $pdf->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < 37; $i++) {
            $pdf->Cell(2, 5, '-', 0, 0, '');
        }
        $pdf->Ln();

        // Limpiar el búfer de salida antes de generar el PDF
        ob_end_clean();
        $pdf->Output();
    }
    public function calcularDescuento($datos)
    {
        $array = explode(",", $datos);
        $id = $array[0];
        $desc = $array[1];
        if (empty($id) || empty($desc)) {
            $msg = array('msg' => 'Error', 'icono' => 'error');
        } else {
            $descuento_actual = $this->model->verificarDescuento($id);
            $descuento_total = $descuento_actual['descuento'] + $desc;
            $sub_total = ($descuento_actual['cantidad'] * $descuento_actual['precio']) - $descuento_total;
            $data = $this->model->actualizarDescuento($descuento_total, $sub_total, $id);
            if ($data == 'ok') {
                $msg = array('msg' => 'Descuento aplicado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al aplicar el descuento', 'icono' => 'error');
            }
        }
        echo json_encode($msg);
        die();
    }
    public function anularCompra($id_compra)
    {
        $data = $this->model->getAnularCompra($id_compra);
        $anular = $this->model->getAnular($id_compra);
        foreach ($data as $row) {
            $stock_actual = $this->model->getProductos($row['id_producto']);
            $stock = $stock_actual['cantidad'] - $row['cantidad'];
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok') {
            $msg = array('msg' => 'Compra Anulada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al Anular', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }

    public function anularVenta($id_venta)
    {
        $data = $this->model->getAnularVenta($id_venta);
        $anular = $this->model->getAnularV($id_venta);
        foreach ($data as $row) {
            $stock_actual = $this->model->getProductos($row['id_producto']);
            $stock = $stock_actual['cantidad'] + $row['cantidad'];
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok') {
            $msg = array('msg' => 'Venta Anulada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al Anular', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }

    public function pdf()
    {

        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        if (empty($desde) || empty($hasta)) {
            $data = $this->model->getHistorialVentas();
        } else {
            $data = $this->model->getRangoFechas($desde, $hasta);
        }
        require('Libraries/fpdf/fpdf.php');

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Ventas');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(20, 5, 'Id', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Cliente', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Producto', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Fecha y Hora', 0, 0, 'C', true);
        $pdf->Cell(35, 5, 'Total', 0, 1, 'C', true);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        $clienteActual = '';
        $totalCliente = 0;

        foreach ($data as $row) {
            if ($row['nombre'] != $clienteActual) {
                if ($clienteActual != '') {
                    $pdf->Cell(175, 10, 'El total: $' . $totalCliente, 0, 1, 'R');
                    $pdf->Ln(5);
                }
                $clienteActual = $row['nombre'];
                $totalCliente = 0;
                $pdf->Cell(90, 5, utf8_decode($clienteActual), 0, 1, 'C');
            }
            $pdf->Cell(30, 5, $row['id'], 0, 0, 'C');
            $pdf->Cell(110, 5, utf8_decode($row['descripcion']), 0, 0, 'C');
            $pdf->Cell(2, 5, $row['fecha'], 0, 0, 'R');
            $pdf->Cell(27, 5, '$' . $row['total'], 0, 1, 'R');
            $totalCliente += $row['total'];
        }

        if ($clienteActual != '') {
            $pdf->Cell(175, 10, 'El Total: $' . $totalCliente, 0, 1, 'R');
        }

        $pdf->Output();
    }

    public function pdfCompra()
    {

        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        if (empty($desde) || empty($hasta)) {
            $data = $this->model->getHistorialCompras();
        } else {
            $data = $this->model->getRangoFechasCompra($desde, $hasta);
        }
        require('Libraries/fpdf/fpdf.php');

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Compra');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(20, 5, 'Id', 0, 0, 'C', true);
        $pdf->Cell(55, 5, 'Productos', 0, 0, 'C', true);
        $pdf->Cell(50, 5, 'Fecha y Hora', 0, 0, 'C', true);
        $pdf->Cell(55, 5, 'Total', 0, 1, 'C', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        foreach ($data as $row) {
            $pdf->Cell(30, 5, $row['id'], 0, 0, 'C');
            $pdf->Cell(45, 5, utf8_decode($row['descripcion']), 0, 0, 'C');
            $pdf->Cell(60, 5, $row['fecha'], 0, 0, 'C');
            $pdf->Cell(45, 5, $row['total'], 0, 1, 'C');
        }

        $pdf->Output();
    }
}
