<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Categorias;

class CategoriasController extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }
        parent::__construct();
        $this->model = new Categorias();
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = Categorias::verificarPermiso($id_user, 'categorias');
        if (!empty($verificar) || $id_user == 1) {
            echo view("Categorias/index");
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }
    public function list()
    {
        $data = Categorias::getCategorias();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="editCat(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" desactiveCat(' . $data[$i]['id'] . ');"><i class="fa-solid fa-lock"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick=" activeCat(' . $data[$i]['id'] . ');"><i class="fa-solid fa-unlock"></i></button>
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
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icon' => 'warning');
        } else {
            if ($id == "") {
                $data = Categorias::registrarCategorias($nombre);

                if ($data == "ok") {
                    $msg = array('msg' => 'Categoria registrada con éxito', 'icon' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Categoria ya existe', 'icon' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar la Categoria', 'icon' => 'error');
                }
            } else {
                $data = Categorias::modificarCategorias($nombre, $id);

                if ($data == "modificado") {
                    $msg = array('msg' => 'Categoria modificada con éxito', 'icon' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la Categoria', 'icon' => 'error');
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function edit(int $id)
    {
        $data = Categorias::editarCat($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function desactive(int $id)
    {
        $data = Categorias::accionCat(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Categoria Desactivada', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar la Categoria', 'icon' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function active(int $id)
    {
        $data = $this->model->accionCat(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Categoria activada', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar la Categoria', 'icon' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
