<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Administracion;

class AdministracionController extends Controller
{
    protected $model;

    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }
        parent::__construct();
        $this->model = new Administracion();
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'configuracion');
        if (!empty($verificar) || $id_user == 1) {
            $data = $this->model->getEmpresa();
            echo view('Administracion/index', $data);
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }
    public function home($parametro = "")
    {
        $data['usuarios'] = $this->model->getDatos('usuarios');
        $data['clientes'] = $this->model->getDatos('clientes');
        $data['productos'] = $this->model->getDatos('productos');
        $data['ventas'] = $this->model->getVentas();
        echo view("Administracion/home", $data);
    }
    public function modificar()
    {
        $ruc = $_POST['ruc'];
        $nombre = $_POST['nombre'];
        $tel = $_POST['telefono'];
        $dir = $_POST['direccion'];
        $mensaje = $_POST['mensaje'];
        $id = $_POST['id'];

        $data = $this->model->modificar($ruc, $nombre, $tel, $dir, $mensaje, $id);
        if ($data == "ok") {
            $msg = "ok";
        } else {
            $msg = "error";
        }

        echo json_encode($data);
        die();
    }

    public function reporteStock()
    {
        $data = $this->model->getStockMinimo();
        echo json_encode($data);
        die();
    }

    public function productosVendidos()
    {
        $data = $this->model->getProductosVendidos();
        echo json_encode($data);
        die();
    }
}
