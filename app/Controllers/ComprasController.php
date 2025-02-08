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

    public function sales()
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
    public function historialSales()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'historial_venta');
        if (!empty($verificar) || $id_user == 1) {
            echo \view('Compras/historial_ventas');
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function searchCode($cod)
    {
        $data = $this->model->getProCod($cod);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getInto()
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
                $msg = array('msg' => 'Producto ingresado a la compra', 'icon' => 'success');
            } else {
                $msg = array('msg' => 'Error al ingresar el producto a la compra', 'icon' => 'error');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            $data = $this->model->actualizarDetalle('detalle', $precio, $total_cantidad, $sub_total, $id_producto, $id_usuario,);
            if ($data == "modificado") {
                $msg = array('msg' => 'Producto actualizado', 'icon' => 'success');
            } else {
                $msg = array('msg' => 'Error al actualizar el producto a la compra', 'icon' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function enterSale()
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
                    $msg = array('msg' => 'Producto ingresado a la venta', 'icon' => 'success');
                } else {
                    $msg = array('msg' => 'Error al ingresar el producto a la venta', 'icon' => 'error');
                }
            } else {
                $msg = array('msg' => 'Stock disponible ' . $datos['cantidad'], 'icon' => 'warning');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            if ($datos['cantidad'] < $total_cantidad) {
                $msg = array('msg' => 'Stock no disponible', 'icon' => 'warning');
            } else {
                $data = $this->model->actualizarDetalle('detalle_temp', $precio, $total_cantidad, $sub_total, $id_producto, $id_usuario,);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Producto actualizado', 'icon' => 'success');
                } else {
                    $msg = array('msg' => 'Error al actualizar el producto a la compra', 'icon' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function list($table)
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
            $msg = array('msg' => 'Producto eliminado', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el Producto', 'icon' => 'error');
        }
        echo json_encode($msg);
        die();
    }
    public function deleteSale($id)
    {
        $data = $this->model->deleteDetalle('detalle_temp', $id);
        if ($data == 'ok') {
            $msg = array('msg' => 'Producto eliminado', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el Producto', 'icon' => 'error');
        }
        echo json_encode($msg);
        die();
    }
    public function registerPurchase()
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
    public function registerSale($id_cliente)
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

    public function generatePDF($id_compra)
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
        $pdf->Cell(55, 5, mb_convert_encoding($empresa['nombre'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->Ln();

        // Ruc
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'RIF ', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, $empresa['rif'], 0, 1, 'R');

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

    public function list_historial()
    {
        $data = $this->model->getHistorialCompras();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Completado</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-warning" onclick="btnAnularC(' . $data[$i]['id'] . ')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . APP_URL . "shopping/generatePDF/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Anulado</span>';
                $data[$i]['acciones'] = '<div>
                <a class="btn btn-danger" href="' . APP_URL . "shopping/generatePDF/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listHistorialSale()
    {
        $data = $this->model->getHistorialVentas();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Completado</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-warning" onclick="btnAnularV(' . $data[$i]['id'] . ')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . APP_URL . "shopping/generatePdfSale/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Anulado</span>';
                $data[$i]['acciones'] = '<div>
                <a class="btn btn-danger" href="' . APP_URL . "shopping/generatePdfSale/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generatePdfSale($id_venta)
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
        $pdf->Cell(55, 5, mb_convert_encoding($empresa['nombre'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->Ln();

        // Ruc
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'RIF ', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, $empresa['rif'], 0, 1, 'R');

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

    public function calculateDiscount($id, $value)
    {
        if (empty($id) || empty($value)) {
            $msg = array('msg' => 'Error', 'icono' => 'error');
        } else {
            $descuento_actual = $this->model->verificarDescuento($id);
            $descuento_total = $descuento_actual['descuento'] + $value;
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

    public function anularShopping($id_compra)
    {
        $data = $this->model->getAnularCompra($id_compra);
        $anular = $this->model->getAnular($id_compra);
        foreach ($data as $row) {
            $stock_actual = $this->model->getProductos($row['id_producto']);
            $stock = $stock_actual['cantidad'] - $row['cantidad'];
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok') {
            $msg = array('msg' => 'Compra Anulada', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al Anular', 'icon' => 'error');
        }
        echo json_encode($msg);
        die();
    }

    public function anularSale($id_venta)
    {
        $data = $this->model->getAnularVenta($id_venta);
        $anular = $this->model->getAnularV($id_venta);
        foreach ($data as $row) {
            $stock_actual = $this->model->getProductos($row['id_producto']);
            $stock = $stock_actual['cantidad'] + $row['cantidad'];
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok') {
            $msg = array('msg' => 'Venta Anulada', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al Anular', 'icon' => 'error');
        }
        echo json_encode($msg);
        die();
    }

    public function pdfSale()
    {
        // Iniciar la sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si las claves 'desde' y 'hasta' están definidas en $_POST
        $desde = isset($_POST['desde']) ? $_POST['desde'] : ($_SESSION['desde'] ?? null);
        $hasta = isset($_POST['hasta']) ? $_POST['hasta'] : ($_SESSION['hasta'] ?? null);

        // Guardar los datos en la sesión si vienen del formulario
        if (!empty($desde) && !empty($hasta)) {
            $_SESSION['desde'] = $desde;
            $_SESSION['hasta'] = $hasta;
        }

        // Obtener los datos según las fechas proporcionadas
        if (empty($desde) || empty($hasta)) {
            $data = $this->model->getHistorialVentas();
        } else {
            $data = $this->model->getRangoFechas($desde, $hasta);
        }

        // Iniciar el almacenamiento en búfer de salida
        ob_start();

        require('Libraries/fpdf/fpdf.php');

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(20, 10, 10); // Márgenes ajustados
        $pdf->SetTitle('Reporte Ventas');
        $pdf->SetFont('Arial', 'B', 14);

        // Título centrado
        $pdf->Cell(0, 10, 'Reporte de Ventas', 0, 1, 'C');
        $pdf->Ln(5); // Espacio adicional

        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(200, 220, 255); // Color de fondo para el encabezado
        $pdf->Cell(30, 10, 'REF', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Cliente', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Fecha y Hora', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Total', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        $clienteActual = '';
        $totalCliente = 0;

        foreach ($data as $row) {
            // Formatear la fecha y hora en formato 12 horas con AM/PM
            $fechaFormateada = date('d/m/Y | h:i:s A', strtotime($row['fecha']));

            if ($row['nombre'] != $clienteActual) {
                if ($clienteActual != '') {
                    // Total por cliente
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(130, 8, 'Total Cliente:', 1, 0, 'R');
                    $pdf->Cell(40, 8, '$' . number_format($totalCliente, 2), 1, 1, 'C');
                    $pdf->Ln(2);
                }
                $clienteActual = $row['nombre'];
                $totalCliente = 0;

                // Nombre del cliente como subtítulo
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->SetFillColor(230, 230, 230); // Fondo gris claro
                $pdf->Cell(165, 8, mb_convert_encoding($clienteActual, 'ISO-8859-1', 'UTF-8'), 1, 1, 'C', true);
            }

            // Detalles de cada venta
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(30, 8, $row['id'], 1, 0, 'C');
            $pdf->Cell(50, 8, mb_convert_encoding($row['nombre'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(50, 8, $fechaFormateada, 1, 0, 'C');
            $pdf->Cell(40, 8, '$' . number_format($row['total'], 2), 1, 1, 'C');
            $totalCliente += $row['total'];
        }

        // Total final del último cliente
        if ($clienteActual != '') {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(130, 8, 'Total Cliente:', 1, 0, 'R');
            $pdf->Cell(40, 8, '$' . number_format($totalCliente, 2), 1, 1, 'C');
        }

        // Limpiar el búfer de salida antes de generar el PDF
        ob_end_clean();
        $pdf->Output();
    }




    public function pdfShopping()
    {
        // Iniciar la sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si las claves 'desde' y 'hasta' están definidas en $_POST
        $desde = isset($_POST['desde']) ? $_POST['desde'] : ($_SESSION['desde'] ?? null);
        $hasta = isset($_POST['hasta']) ? $_POST['hasta'] : ($_SESSION['hasta'] ?? null);

        // Guardar los datos en la sesión si vienen del formulario
        if (!empty($desde) && !empty($hasta)) {
            $_SESSION['desde'] = $desde;
            $_SESSION['hasta'] = $hasta;
        }

        // Obtener los datos según las fechas proporcionadas
        if (empty($desde) || empty($hasta)) {
            $data = $this->model->getHistorialCompras();
        } else {
            $data = $this->model->getRangoFechasCompra($desde, $hasta);
        }

        // Iniciar el almacenamiento en búfer de salida
        ob_start();

        require('Libraries/fpdf/fpdf.php');

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(25, 10, 10);
        $pdf->SetTitle('Reporte Compra');
        $pdf->SetFont('Arial', 'B', 14);

        // Título del reporte
        $pdf->Cell(0, 10, 'Reporte de Compras', 0, 1, 'C');
        $pdf->Ln(5);

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(200, 220, 255); // Color de fondo para el encabezado
        $pdf->Cell(30, 10, 'Ref', 1, 0, 'C', true);
        $pdf->Cell(80, 10, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Total (Bs)', 1, 1, 'C', true);

        foreach ($data as $row) {
            $pdf->SetFont('Arial', '', 10);
            // Convertir la fecha al formato día/mes/año
            $fechaFormateada = date('d/m/Y | h:i:s A', strtotime($row['fecha']));
            $pdf->Cell(30, 10, $row['id'], 1, 0, 'C');
            $pdf->Cell(80, 10, $fechaFormateada, 1, 0, 'C');
            $pdf->Cell(50, 10, 'Bs ' . number_format($row['total'], 2), 1, 1, 'C');
        }

        // Limpiar el búfer de salida antes de generar el PDF
        ob_end_clean();
        $pdf->Output();
    }
}
