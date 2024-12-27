<?php

namespace App\Controllers;

use App\Config\Controller;

class ErrorsController extends Controller
{
    public function index()
    {
        echo view('Errors/index');
    }

    public function permisos()
    {
        echo view('Errors/permisos');
    }
}
