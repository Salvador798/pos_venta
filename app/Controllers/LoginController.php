<?php

namespace App\Controllers;

use App\Config\Controller;
use App\Models\Usuarios;

class LoginController extends Controller
{
    public function login()
    {
        session_start();

        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $msg = "Los campos están vacios";
        } else {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $hash = hash("SHA256", $clave);

            $data = Usuarios::getUsuario($usuario, $hash);
            if ($data) {
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['activo'] = true;
                $msg = "ok";
            } else {
                $msg = "Usuario o Contraseña incorrecta";
            }
        }

        header('Content-Type: application/json');
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("location: " . APP_URL);
    }
}
