<?php

namespace App\Config;

use App\Config\Views;

class Controller
{
    protected $model, $views;

    public function __construct()
    {
        $this->views = new Views();
        $this->cargarModel();
    }
    public function cargarModel()
    {
        $model = str_replace('Controller', '', get_class($this));
        $model = 'App\\Models\\' . $model;
        if (class_exists($model)) {
            $this->model = new $model();
        }
    }
}
