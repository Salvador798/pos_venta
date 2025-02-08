<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Usuarios;

class UsuariosController extends Controller
{
    public function __construct()
    {
        session_start();

        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }

        parent::__construct();
        $this->model = new Usuarios();
    }

    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = Usuarios::verificarPermiso($id_user, 'configuracion');

        if (!empty($verificar) || $id_user == 1) {
            $data['cajas'] = Usuarios::getCajas();
            echo view("Usuarios/index", $data);
        } else {
            header('location: ' . APP_URL . 'Errors/permisos');
        }
    }

    public function list()
    {
        $data = Usuarios::getUsuarios();

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                if ($data[$i]['id'] == 1) {
                    $data[$i]['acciones'] = '<div>
                    <span class="badge badge-primary">Administrador</span>
                    </div>';
                } else {
                    $data[$i]['acciones'] = '<div>
                    <a class="btn btn-dark" href="' . APP_URL . 'users/permisos/' . $data[$i]['id'] . '"><i class="fas fa-key"></i></a>
                    <button class="btn btn-primary" type="button" onclick="editUser(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" type="button" onclick=" desactiveUser(' . $data[$i]['id'] . ');"><i class="fa-solid fa-lock"></i></button>
                    </div>';
                }
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="activeUser(' . $data[$i]['id'] . ');"><i class="fa-solid fa-unlock"></i></button>
                </div>';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $confirmar = $_POST['confirmar'];
        $caja = $_POST['caja'];
        $id = $_POST['id'];
        $hash = hash("SHA256", $clave);

        if (empty($usuario) || empty($nombre) || empty($caja)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icon' => 'warning');
        } else {
            if ($id == "") {
                if ($clave != $confirmar) {
                    $msg = array('msg' => 'Las contraseñas no coinciden', 'icon' => 'warning');
                } else {
                    $data = Usuarios::registrarUsuario($usuario, $nombre, $hash, $caja);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Usuario registrado con éxito', 'icon' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El usuario ya existe', 'icon' => 'warning');
                    } else {
                        $msg = array('msg' => 'Error al registrar un usuario', 'icon' => 'error');
                    }
                }
            } else {
                $data = Usuarios::modificarUsuario($usuario, $nombre, $caja, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Usuario modificado con éxito', 'icon' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar el usuario', 'icon' => 'warning');
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $data = Usuarios::editarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function desactive(int $id)
    {
        $data = Usuarios::accionUser(0, $id);

        if ($data == 1) {
            $msg = "ok";
            $msg = array('msg' => 'Usuario desactivado', 'icon' => 'success');
        } else {
            $msg = "Error al eliminar un usuario";
            $msg = array('msg' => 'Error al desactivar un usuario', 'icon' => 'warning');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function active(int $id)
    {
        $data = Usuarios::accionUser(1, $id);

        if ($data == 1) {
            $msg = array('msg' => 'Usuario activado', 'icon' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar el usuario', 'icon' => 'warning');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function cambiarPass()
    {
        $actual = $_POST['clave_actual'];
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['confirmar_clave'];

        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $mensaje = array('msg' => 'Todos los campos son obligatorios', 'icon' => 'warning');
        } else {
            if ($nueva != $confirmar) {
                $mensaje = array('msg' => 'Las Contraseñas no coinciden', 'icon' => 'warning');
            } else {
                $id = $_SESSION['id_usuario'];
                $hash = hash("SHA256", $actual);
                $data = Usuarios::getPass($hash, $id);

                if (!empty($data)) {
                    $verificar = Usuarios::modificarPass(hash("SHA256", $nueva), $id);
                    if ($verificar == 1) {
                        $mensaje = array('msg' => 'Contraseña modificada con éxito', 'icon' => 'success');
                    } else {
                        $mensaje = array('msg' => 'Error al modificar la Contraseña', 'icon' => 'error');
                    }
                } else {
                    $mensaje = array('msg' => 'La contraseña actual es incorrecta', 'icon' => 'warning');
                }
            }
        }

        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function permisos($id)
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . APP_URL);
        }

        $data['datos'] = Usuarios::getPermisos();
        $permisos = Usuarios::getDetallePermisos($id);
        $data['asignados'] = array();
        foreach ($permisos as $permiso) {
            $data['asignados'][$permiso['id_permiso']] = true;
        }

        $data['id_usuario'] = $id;
        echo view("Usuarios/permisos", $data);
    }

    public function registrarPermiso()
    {
        $msg = '';
        $id_user = $_POST['id_usuario'];
        $eliminar = Usuarios::eliminarPermisos($id_user);

        if ($eliminar == 'ok') {
            foreach ($_POST['permisos'] as $id_permiso) {
                $msg = Usuarios::registrarPermisos($id_user, $id_permiso);
            }
            if ($msg == 'ok') {
                $msg = array('msg' => 'Permiso asignado', 'icon' => 'success');
            } else {
                $msg = array('msg' => 'Error al asignar los permisos', 'icon' => 'error');
            }
        } else {
            $msg = array('msg' => 'Error al eliminar los permisos anteriores', 'icon' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }
}
