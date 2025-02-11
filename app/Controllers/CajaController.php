<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Caja;

class CajaController extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }
        parent::__construct();
        $this->model = new Caja();
    }

    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = Caja::verificarPermiso($id_user, 'caja');
        if (!empty($verificar) || $id_user == 1) {
            echo view("Caja/index");
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function arqueo()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = Caja::verificarPermiso($id_user, 'arqueo_caja');
        if (!empty($verificar) || $id_user == 1) {
            echo view("Caja/arqueo");
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function list()
    {
        $data = Caja::getCajas('caja');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="editCaj(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" desactiveCaj(' . $data[$i]['id'] . ');"><i class="fa-solid fa-lock"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick=" activeCaj(' . $data[$i]['id'] . ');"><i class="fa-solid fa-unlock"></i></button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listArqueo()
    {
        $data = Caja::getCajas('cierre_caja');
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

    public function store()
    {
        $caja = $_POST['caja'];
        $id = $_POST['id'];
        if (empty($caja)) {
            $msg = array('msg' => 'El nombre de la Caja es obligatorio', 'icon' => 'warning');
        } else {
            if ($id == "") {
                $data = Caja::registrarCajas($caja);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja registrada con éxito', 'icon' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Caja ya existe', 'icon' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar la Caja', 'icon' => 'error');
                }
            } else {
                $data = Caja::modificarCajas($caja, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Caja modificada con éxito', 'icon' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la Caja', 'icon' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function openArqueo()
    {
        $monto_inicial = $_POST['monto_inicial'];
        $fecha_apertura = date('Y-m-d');
        $id_usuario = $_SESSION['id_usuario'];
        $id = $_POST['id'];
        if (empty($monto_inicial)) {
            $msg = array('msg' => 'El nombre de la Caja es obligatorio', 'icon' => 'warning');
        } else {
            if ($id == "") {
                $data = Caja::registrarArqueo($id_usuario, $monto_inicial, $fecha_apertura);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja abierta con éxito', 'icon' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Caja ya está abierta', 'icon' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al abrir la Caja', 'icon' => 'error');
                }
            } else {
                $monto_final = Caja::getVentas($id_usuario);
                $total_ventas = Caja::getTotalVentas($id_usuario);
                $inicial = Caja::getMontoInicial($id_usuario);
                $general = $monto_final['total'] + $inicial['monto_inicial'];
                $data = Caja::actualizarArqueo($monto_final['total'], $fecha_apertura, $total_ventas['total'], $general, $inicial['id']);
                if ($data == "ok") {
                    Caja::actualizarApertura($id_usuario);
                    $msg = array('msg' => 'Caja cerrar con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al cerrar la Caja', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $data = Caja::editarCaj($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function desactive(int $id)
    {
        $data = Caja::accionCaj(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Caja desactivada', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar la Caja', 'icon' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function active(int $id)
    {
        $data = Caja::accionCaj(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Caja activada', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar la Caja', 'icon' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getSales()
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
