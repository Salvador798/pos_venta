<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Medidas;

class MedidasController extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }
        parent::__construct();
        $this->model = new Medidas();
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = Medidas::verificarPermiso($id_user, 'medidas');
        if (!empty($verificar) || $id_user == 1) {
            echo view("Medidas/index");
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function list()
    {
        $data = Medidas::getMedidas();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="editExt(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" desactiveExt(' . $data[$i]['id'] . ');"><i class="fa-solid fa-lock"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick=" activeExt(' . $data[$i]['id'] . ');"><i class="fa-solid fa-unlock"></i></button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $nombre = $_POST['nombre'];
        $id = $_POST['id'];
        if (empty($nombre)) {
            $msg = array('msg' => 'El Nombre es obligatorio', 'icon' => 'warning');
        } else {
            if ($id == "") {
                $data = Medidas::registrarMedidas($nombre);
                if ($data == "ok") {
                    $msg = array('msg' => 'Medida registrada con éxito', 'icon' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La medida ya existe', 'icon' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar la Medida', 'icon' => 'error');
                }
            } else {
                $data = Medidas::modificarMedidas($nombre, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Medida modificada con éxito', 'icon' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la Medida', 'icon' => 'warning');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $data = Medidas::editarMed($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function desactive(int $id)
    {
        $data = Medidas::accionMed(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Medida desactivada', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar la Medida', 'icon' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function active(int $id)
    {
        $data = Medidas::accionMed(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Medida activada', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar la Medida', 'icon' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
