<?php

namespace App\Controllers;

use App\Config\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        session_start();
        if (!empty($_SESSION['activo'])) {
            header("location: " . APP_URL . "Usuarios");
        }
        parent::__construct();
    }

    public function index()
    {
        echo view('index');
    }
}
