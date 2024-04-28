<?php
class Categorias extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getCategorias();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="btn btn-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarCat(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" btnEliminarCat(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="btn btn-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick=" btnReingresarCat(' . $data[$i]['id'] . ');">Reingresar</button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $nombre = $_POST['nombre'];
        $id = $_POST['id'];
        if (empty($nombre)) {
            $msg = "El Nombre es obligatorio";
        } else {
            if ($id == "") {
                $data = $this->model->registrarCategorias($nombre);
                if ($data == "ok") {
                    $msg = "si";
                } else if ($data == "existe") {
                    $msg = "El dni ya existe";
                } else {
                    $msg = "Error al registrar el cliente";
                }
            } else {
                $data = $this->model->modificarCategorias($nombre, $id);
                if ($data == "modificado") {
                    $msg = "modificado";
                } else {
                    $msg = "Error al modificar el cliente";
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarCat($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionCat(0, $id);
        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al eliminar la categoria";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionCat(1, $id);
        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al reingresar la categoria";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
