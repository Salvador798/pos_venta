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
    public function arqueo()
    {
        $this->views->getView($this, "arqueo");
    }
    public function listar()
    {
        $data = $this->model->getCajas();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarCaj(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" btnEliminarCaj(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
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
            $msg = array('msg' => 'El nombre de la Caja es obligatorio', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->registrarCajas($caja);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja registrada con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Caja ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar la Caja', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificarCajas($caja, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Caja modificada con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la Caja', 'icono' => 'error');
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
            $msg = array('msg' => 'Caja desactivada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar la Caja', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionCaj(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Caja activada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar la Caja', 'icono' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
