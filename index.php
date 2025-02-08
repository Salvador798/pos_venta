<?php

use App\Config\Route;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/Config.php'; // Incluir el archivo de configuración
require __DIR__ . '/config/helpers.php'; // Incluir el archivo de ayuda

Route::init();

require __DIR__ . '/routes/web.php';

Route::run();

// require __DIR__ . '/config/Route.php'; // Incluir el archivo de rutas
// require __DIR__ . '/routes/web.php';

// Route::dispatch();

// $ruta = !empty($_GET['url']) ? $_GET['url'] : "home/index";
// $array = explode("/", $ruta);
// $controller = ucfirst($array[0]) . 'Controller'; // Añadir el sufijo 'Controller'
// $metodo = "index";
// $parametro = "";

// if (!empty($array[1])) {
//     if ($array[1] != "") {
//         $metodo = $array[1];
//     }
// }
// if (!empty($array[2])) {
//     if ($array[2] != "") {
//         $parametro = "";
//         for ($i = 2; $i < count($array); $i++) {
//             $parametro .= $array[$i] . ",";
//         }
//         $parametro = trim($parametro, ",");
//     }
// }

// // Asegúrate de que $controller esté definido
// if (!isset($controller)) {
//     echo "Controlador no definido";
//     exit;
// }

// // Cargar el controlador y método
// $controller = "App\\Controllers\\" . $controller;
// if (class_exists($controller)) {
//     $controller = new $controller();
//     if (method_exists($controller, $metodo)) {
//         $controller->{$metodo}($parametro);
//     } else {
//         echo "Método no encontrado";
//     }
// } else {
//     echo "Controlador no encontrado";
// }
