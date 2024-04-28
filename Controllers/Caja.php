<?php
class Caja extends Controller
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
        $data = $this->model->getCajas();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="btn btn-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarCaj(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" btnEliminarCaj(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="btn btn-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick=" btnReingresarCaj(' . $data[$i]['id'] . ');">Reingresar</button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $caja = $_POST['caja'];
        $id = $_POST['id'];
        if (empty($caja)) {
            $msg = "El Nombre de la caja es obligatorio";
        } else {
            if ($id == "") {
                $data = $this->model->registrarCajas($caja);
                if ($data == "ok") {
                    $msg = "si";
                } else if ($data == "existe") {
                    $msg = "La Caja ya existe";
                } else {
                    $msg = "Error al registrar la Caja";
                }
            } else {
                $data = $this->model->modificarCajas($caja, $id);
                if ($data == "modificado") {
                    $msg = "modificado";
                } else {
                    $msg = "Error al modificar la Caja";
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarCaj($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionCaj(0, $id);
        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al eliminar la caja";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionCaj(1, $id);
        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al reingresar la Caja";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
