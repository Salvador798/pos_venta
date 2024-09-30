<?php
class Medidas extends Controller
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
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'medidas');
        if (!empty($verificar) || $id_user == 1) {
            $this->views->getView($this, "index");
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }
    public function listar()
    {
        $data = $this->model->getMedidas();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarMed(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" btnEliminarMed(' . $data[$i]['id'] . ');"><i class="fa-solid fa-lock"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick=" btnReingresarMed(' . $data[$i]['id'] . ');"><i class="fa-solid fa-unlock"></i></button>
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
            $msg = array('msg' => 'El Nombre es obligatorio', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->registrarMedidas($nombre);
                if ($data == "ok") {
                    $msg = array('msg' => 'Medida registrada con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La medida ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar la Medida', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificarMedidas($nombre, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Medida modificada con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la Medida', 'icono' => 'warning');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarMed($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionMed(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Medida desactivada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar la Medida', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionMed(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Medida activada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar la Medida', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
