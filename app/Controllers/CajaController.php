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
        try {
            // Limpiar cualquier salida previa si existe
            if (ob_get_level() > 0) {
                ob_clean();
            }
            
            $monto_inicial = $_POST['monto_inicial'] ?? '';
            $fecha_apertura = date('Y-m-d');
            $id_usuario = $_SESSION['id_usuario'] ?? null;
            $id = $_POST['id'] ?? '';
            
            // Validar que el usuario esté en sesión
            if (empty($id_usuario)) {
                $msg = array('msg' => 'Error de sesión. Por favor, inicie sesión nuevamente.', 'icon' => 'error');
                header('Content-Type: application/json');
                echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                die();
            }
            
            // Validar monto inicial
            // NOTA: No hay restricciones sobre el monto inicial basado en cajas anteriores.
            // El usuario puede abrir una nueva caja con cualquier monto inicial, incluso si es igual
            // al monto inicial de una caja anterior cerrada.
            if (empty($monto_inicial) || trim($monto_inicial) === '') {
                $msg = array('msg' => 'El monto inicial es obligatorio', 'icon' => 'warning');
            } else {
                // Validar que el monto sea numérico
                $monto_inicial = str_replace(',', '', $monto_inicial); // Remover comas
                if (!is_numeric($monto_inicial) || floatval($monto_inicial) < 0) {
                    $msg = array('msg' => 'El monto inicial debe ser un número válido', 'icon' => 'warning');
                } else {
                    if ($id == "") {
                        // Verificar directamente usando el método estático del modelo
                        // Solo se verifica que no haya una caja abierta (estado = 1)
                        // No se compara el monto inicial con cajas anteriores
                        $cajasAbiertas = Caja::getCajasAbiertas($id_usuario);
                        
                        error_log("DEBUG openArqueo - Usuario: $id_usuario, Cajas abiertas encontradas: " . count($cajasAbiertas));
                        
                        if (!empty($cajasAbiertas) && count($cajasAbiertas) > 0) {
                            $idsAbiertas = array_column($cajasAbiertas, 'id');
                            error_log("DEBUG openArqueo - IDs de cajas abiertas: " . implode(', ', $idsAbiertas));
                            $msg = array('msg' => 'Ya tiene una caja abierta (ID: ' . implode(', ', $idsAbiertas) . '). Debe cerrarla primero usando el botón "Cerrar Caja" antes de abrir una nueva.', 'icon' => 'warning');
                        } else {
                            // No hay cajas abiertas, proceder a abrir nueva caja
                            // El monto inicial puede ser cualquier valor numérico >= 0, sin restricciones
                            $data = Caja::registrarArqueo($id_usuario, $monto_inicial, $fecha_apertura);
                            
                            if ($data === "ok") {
                                $msg = array('msg' => 'Caja abierta con éxito', 'icon' => 'success');
                            } else if ($data === "existe") {
                                // Esto no debería pasar si ya verificamos arriba, pero por si acaso
                                $cajaAbierta = Caja::getMontoInicial($id_usuario);
                                $idCaja = !empty($cajaAbierta) && isset($cajaAbierta['id']) ? $cajaAbierta['id'] : 'N/A';
                                $msg = array('msg' => 'Ya tiene una caja abierta (ID: ' . $idCaja . '). Debe cerrarla primero usando el botón "Cerrar Caja" antes de abrir una nueva.', 'icon' => 'warning');
                            } else {
                                // Error en la inserción
                                error_log("Error al abrir caja - Usuario: $id_usuario, Monto: $monto_inicial, Fecha: $fecha_apertura, Resultado: " . var_export($data, true));
                                
                                // Obtener todas las cajas del usuario para debugging
                                $todasLasCajas = Caja::getAllCajasUsuario($id_usuario);
                                error_log("DEBUG - Todas las cajas del usuario $id_usuario: " . json_encode($todasLasCajas));
                                
                                $msg = array('msg' => 'Error al abrir la Caja. Verifique los logs del servidor para más detalles.', 'icon' => 'error');
                            }
                        }
                    } else {
                        // Cerrar caja existente
                        $monto_final = Caja::getVentas($id_usuario);
                        $total_ventas = Caja::getTotalVentas($id_usuario);
                        $inicial = Caja::getMontoInicial($id_usuario);
                        
                        // Validar que exista una caja abierta
                        if (empty($inicial) || $inicial === false || !isset($inicial['id'])) {
                            $msg = array('msg' => 'No hay una caja abierta para cerrar', 'icon' => 'warning');
                        } else {
                            // Asegurar valores por defecto si no hay ventas
                            $monto_final_valor = isset($monto_final['total']) && $monto_final['total'] !== null ? floatval($monto_final['total']) : 0.00;
                            $total_ventas_valor = isset($total_ventas['total']) && $total_ventas['total'] !== null ? intval($total_ventas['total']) : 0;
                            $monto_inicial_valor = isset($inicial['monto_inicial']) && $inicial['monto_inicial'] !== null ? floatval($inicial['monto_inicial']) : 0.00;
                            
                            $general = $monto_final_valor + $monto_inicial_valor;
                            
                            // Convertir todos los valores a string como espera el método
                            $data = Caja::actualizarArqueo(
                                (string)$monto_final_valor,
                                $fecha_apertura,
                                (string)$total_ventas_valor,
                                (string)$general,
                                intval($inicial['id'])
                            );
                            
                            if ($data === "ok") {
                                Caja::actualizarApertura($id_usuario);
                                $msg = array('msg' => 'Caja cerrada con éxito', 'icon' => 'success');
                            } else {
                                error_log("Error al cerrar caja - Usuario: $id_usuario, Resultado: " . var_export($data, true));
                                $msg = array('msg' => 'Error al cerrar la Caja', 'icon' => 'error');
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $msg = array('msg' => 'Error inesperado: ' . $e->getMessage(), 'icon' => 'error');
        }
        
        header('Content-Type: application/json');
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
        try {
            $id_usuario = $_SESSION['id_usuario'] ?? null;
            
            if (empty($id_usuario)) {
                $data = array(
                    'monto_total' => array('total' => 0),
                    'total_ventas' => array('total' => 0),
                    'inicial' => array('id' => '', 'monto_inicial' => 0),
                    'monto_general' => 0
                );
                header('Content-Type: application/json');
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
                die();
            }
            
            $monto_total = $this->model->getVentas($id_usuario);
            $total_ventas = $this->model->getTotalVentas($id_usuario);
            $inicial = $this->model->getMontoInicial($id_usuario);
            
            // Asegurar que siempre haya una estructura válida
            $data['monto_total'] = !empty($monto_total) && $monto_total !== false ? $monto_total : array('total' => 0);
            $data['total_ventas'] = !empty($total_ventas) && $total_ventas !== false ? $total_ventas : array('total' => 0);
            $data['inicial'] = !empty($inicial) && $inicial !== false ? $inicial : array('id' => '', 'monto_inicial' => 0);
            
            // Calcular monto general
            $monto_ventas = isset($data['monto_total']['total']) ? floatval($data['monto_total']['total']) : 0;
            $monto_inicial = isset($data['inicial']['monto_inicial']) ? floatval($data['inicial']['monto_inicial']) : 0;
            $data['monto_general'] = $monto_ventas + $monto_inicial;
            
            header('Content-Type: application/json');
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        } catch (\Exception $e) {
            error_log("Error en getSales: " . $e->getMessage());
            $data = array(
                'monto_total' => array('total' => 0),
                'total_ventas' => array('total' => 0),
                'inicial' => array('id' => '', 'monto_inicial' => 0),
                'monto_general' => 0
            );
            header('Content-Type: application/json');
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    /**
     * Endpoint de diagnóstico para verificar el estado de las cajas
     */
    public function debugCajas()
    {
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        if (empty($id_usuario)) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Usuario no autenticado'), JSON_UNESCAPED_UNICODE);
            die();
        }
        
        $todasLasCajas = Caja::getAllCajasUsuario($id_usuario);
        $cajasAbiertas = Caja::getCajasAbiertas($id_usuario);
        
        $resultado = array(
            'usuario' => $id_usuario,
            'todas_las_cajas' => $todasLasCajas,
            'cajas_abiertas' => $cajasAbiertas,
            'total_cajas' => count($todasLasCajas),
            'total_abiertas' => count($cajasAbiertas)
        );
        
        header('Content-Type: application/json');
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        die();
    }
}
