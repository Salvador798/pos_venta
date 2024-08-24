<?php
class Productos extends Controller
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
        $verificar = $this->model->verificarPermiso($id_user, 'productos');
        if (!empty($verificar) || $id_user == 1) {
            $data['medidas'] = $this->model->getMedidas();
            $data['categorias'] = $this->model->getCategorias();
            $this->views->getView($this, "index", $data);
        } else {
            header('location: ' . APP_URL . 'errors/permisos');
        }
    }
    public function listar()
    {
        $data = $this->model->getProductos();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . APP_URL . "Assets/img/" . $data[$i]['foto'] . '" width="40">';
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarPro(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick=" btnEliminarPro(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick=" btnReingresarPro(' . $data[$i]['id'] . ');">Reingresar</button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];
        $medida = $_POST['medida'];
        $categoria = $_POST['categoria'];
        $id = $_POST['id'];
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $destino = "Assets/img/" . $name;
        if (empty($name)) {
            $name = "default.png";
        }
        if (empty($codigo) || empty($nombre) || empty($precio_compra) || empty($precio_venta)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->registrarProducto($codigo, $nombre, $precio_compra, $precio_venta, $medida, $categoria, $name);
                if ($data == "ok") {
                    $msg = array('msg' => 'Producto registrado con éxito', 'icono' => 'success');
                    move_uploaded_file($tmpname, $destino);
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El Producto ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar el Producto', 'icono' => 'error');
                }
            } else {
                if ($_POST['foto_actual'] != $_POST['foto_delete']) {
                    $imgDelete = $this->model->editarPro($id);
                    if ($imgDelete['foto'] != 'default.png' || $imgDelete['foto'] != "") {
                        if (file_exists($destino . $imgDelete['foto'])) {
                            unlink($destino . $imgDelete['foto']);
                        }
                    }
                    $data = $this->model->modificarProducto($codigo, $nombre, $precio_compra, $precio_venta, $medida, $categoria, $name, $id);
                    if ($data == "modificado") {
                        move_uploaded_file($tmpname, $destino);
                        $msg = array('msg' => 'Producto modificado con éxito', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar el Producto', 'icono' => 'error');
                    }
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarPro($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionPro(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Producto desactivado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar el Producto', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionPro(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Producto activado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar el Producto', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function salir()
    {
        session_destroy();
        header("location: " . APP_URL);
    }
}
