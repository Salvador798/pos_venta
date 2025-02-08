<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Administracion;

class AdministracionController extends Controller
{
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
        $verificar = Administracion::verificarPermiso($id_user, 'configuracion');

        if (!empty($verificar) || $id_user == 1) {
            $data = $this->model->getEmpresa();
            echo view('Administracion/index', $data);
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }
    public function home($parametro = "")
    {
        $data['usuarios'] = Administracion::getDatos('usuarios');
        $data['clientes'] = Administracion::getDatos('clientes');
        $data['productos'] = Administracion::getDatos('productos');
        $data['ventas'] = Administracion::getVentas();

        echo view("Administracion/home", $data);
    }
    public function modify()
    {
        $rif = $_POST['rif'];
        $nombre = $_POST['nombre'];
        $tel = $_POST['telefono'];
        $dir = $_POST['direccion'];
        $id = $_POST['id'];

        $data = Administracion::modificar($rif, $nombre, $tel, $dir, $id);
        if ($data == "ok") {
            $msg = "ok";
        } else {
            $msg = "error";
        }

        echo json_encode($data);
        die();
    }

    public function reportStock()
    {
        $data = Administracion::getStockMinimo();
        echo json_encode($data);
        die();
    }

    public function productsSold()
    {
        $data = Administracion::getProductosVendidos();
        echo json_encode($data);
        die();
    }
}
