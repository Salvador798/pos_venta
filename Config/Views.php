<?php

namespace App\Config;

class Views
{
    public function getView($controller, $view, $data = [])
    {
        $controller = str_replace('App\\Controllers\\', '', $controller);
        $viewPath = "resources/views/" . $controller . "/" . $view . ".php";
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("La vista no existe: " . $viewPath);
        }
    }
}
