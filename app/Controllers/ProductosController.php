<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Productos;

class ProductosController extends Controller
{
    protected $model;

    public function __construct()
    {
        session_start();

        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }

        parent::__construct();
        $this->model = new Productos();
    }

    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = Productos::verificarPermiso($id_user, 'productos');

        if (!empty($verificar) || $id_user == 1) {
            $data['medidas'] = Productos::getMedidas();
            $data['categorias'] = Productos::getCategorias();
            echo view("Productos/index", $data);
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function list()
    {
        $data = Productos::getProductos();

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . APP_URL . "public/img/" . $data[$i]['foto'] . '" width="40">';
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button class="btn btn-primary" type="button" onclick="editPro(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" type="button" onclick=" desactivePro(' . $data[$i]['id'] . ');"><i class="fa-solid fa-lock"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button class="btn btn-success" type="button" onclick=" activePro(' . $data[$i]['id'] . ');"><i class="fa-solid fa-unlock"></i></button>
                </div>';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];
        $medida = $_POST['medida'];
        $categoria = $_POST['categoria'];
        $id = $_POST['id'];
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $destino = "public/img/" . $name;
        $iva = $_POST['iva'];

        if (empty($name)) {
            $name = "default.png";
        }

        if ($iva != 'Exento' && $iva != 'Aplica') {
            $msg = 'El IVA fue afectado';
        }

        if (empty($codigo) || empty($nombre) || empty($precio_compra) || empty($precio_venta)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icon' => 'warning');
        } else {
            if ($id == "") {
                $data = Productos::registrarProducto($codigo, $nombre, $precio_compra, $precio_venta, $iva, $medida, $categoria, $name);

                if ($data == "ok") {
                    $msg = array('msg' => 'Producto registrado con éxito', 'icon' => 'success');
                    move_uploaded_file($tmpname, $destino);
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El Producto ya existe', 'icon' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar el Producto', 'icon' => 'error');
                }
            } else {
                if ($_POST['foto_actual'] != $_POST['foto_delete']) {
                    $imgDelete = Productos::editarPro($id);

                    if ($imgDelete['foto'] != 'default.png' || $imgDelete['foto'] != "") {
                        if (file_exists($destino . $imgDelete['foto'])) {
                            unlink($destino . $imgDelete['foto']);
                        }
                    }

                    $data = Productos::modificarProducto($codigo, $nombre, $precio_compra, $precio_venta, $iva, $medida, $categoria, $name, $id);

                    if ($data == "modificado") {
                        move_uploaded_file($tmpname, $destino);
                        $msg = array('msg' => 'Producto modificado con éxito', 'icon' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar el Producto', 'icon' => 'error');
                    }
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $data = Productos::editarPro($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function desactive(int $id)
    {
        $data = Productos::accionPro(0, $id);

        if ($data == 1) {
            $msg = array('msg' => 'Producto desactivado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar el Producto', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function active(int $id)
    {
        $data = Productos::accionPro(1, $id);

        if ($data == 1) {
            $msg = array('msg' => 'Producto activado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar el Producto', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
