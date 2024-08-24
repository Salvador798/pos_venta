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
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'caja');
        if (!empty($verificar) || $id_user == 1) {
            $this->views->getView($this, "index");
        } else {
            header('location: ' . APP_URL . 'errors/permisos');
        }
    }
    public function arqueo()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermiso($id_user, 'arqueo_caja');
        if (!empty($verificar) || $id_user == 1) {
            $this->views->getView($this, "arqueo");
        } else {
            header('location: ' . APP_URL . 'errors/permisos');
        }
    }
    public function listar()
    {
        $data = $this->model->getCajas('caja');
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
    public function listar_arqueo()
    {
        $data = $this->model->getCajas('cierre_caja');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Abierta</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Cerrada</span>';
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
    public function abrirArqueo()
    {
        $monto_inicial = $_POST['monto_inicial'];
        $fecha_apertura = date('Y-m-d');
        $id_usuario = $_SESSION['id_usuario'];
        $id = $_POST['id'];
        if (empty($monto_inicial)) {
            $msg = array('msg' => 'El nombre de la Caja es obligatorio', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->registrarArqueo($id_usuario, $monto_inicial, $fecha_apertura);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja abierta con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Caja ya está abierta', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al abrir la Caja', 'icono' => 'error');
                }
            } else {
                $monto_final = $this->model->getVentas($id_usuario);
                $total_ventas = $this->model->getTotalVentas($id_usuario);
                $inicial = $this->model->getMontoInicial($id_usuario);
                $general = $monto_final['total'] + $inicial['monto_inicial'];
                $data = $this->model->actualizarArqueo($monto_final['total'], $fecha_apertura, $total_ventas['total'], $general, $inicial['id']);
                if ($data == "ok") {
                    $this->model->actualizarApertura($id_usuario);
                    $msg = array('msg' => 'Caja cerrar con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al cerrar la Caja', 'icono' => 'error');
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

    public function getVentas()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['monto_total'] = $this->model->getVentas($id_usuario);
        $data['total_ventas'] = $this->model->getTotalVentas($id_usuario);
        $data['inicial'] = $this->model->getMontoInicial($id_usuario);
        $data['monto_general'] = $data['monto_total']['total'] + $data['inicial']['monto_inicial'];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
