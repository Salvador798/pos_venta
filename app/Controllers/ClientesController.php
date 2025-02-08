<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Clientes;

class ClientesController extends Controller
{
    protected $model;

    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }
        parent::__construct();
        $this->model = new Clientes();
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = Clientes::verificarPermiso($id_user, 'clientes');
        if (!empty($verificar) || $id_user == 1) {
            echo view("Clientes/index");
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }
    public function list()
    {
        $data = Clientes::getClientes();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="edditCli(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" desactiveCli(' . $data[$i]['id'] . ');"><i class="fa-solid fa-lock"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick=" activeCli(' . $data[$i]['id'] . ');"><i class="fa-solid fa-unlock"></i></button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function store()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = Clientes::verificarPermiso($id_user, 'registrar_clientes');
        if (!empty($verificar) || $id_user == 1) {
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $id = $_POST['id'];
            if (empty($dni) || empty($nombre) || empty($telefono) || empty($direccion)) {
                $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'warning');
            } else {
                if ($id == "") {
                    $data = Clientes::registrarCliente($dni, $nombre, $telefono, $direccion);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Cliente registrado con éxito', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El Cliente ya existe', 'icono' => 'warning');
                    } else {
                        $msg = array('msg' => 'Error al registrar el Cliente', 'icono' => 'error');
                    }
                } else {
                    $data = Clientes::modificarCliente($dni, $nombre, $telefono, $direccion, $id);
                    if ($data == "modificado") {
                        $msg = array('msg' => 'Cliente modificado con éxito', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar el Cliente', 'icono' => 'error');
                    }
                }
            }
        } else {
            $msg = array('msg' => 'No tienes permisos para registrar Cliente', 'icono' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function edit(int $id)
    {
        $data = Clientes::editarCli($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function desactive(int $id)
    {
        $data = Clientes::accionCli(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente desactivado', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar el cliente', 'icon' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function active(int $id)
    {
        $data = Clientes::accionCli(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente activado', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar el cliente', 'icon' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
