<?php
class MedidasModel extends Query
{
    private $nombre, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getMedidas()
    {
        $sql = "SELECT * FROM medidas";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarMedidas(string $nombre)
    {
        $this->nombre = $nombre;
        $verificar = "SELECT * FROM medidas WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO medidas (nombre) VALUES (?)";
            $datos = array($this->nombre);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function modificarMedidas(string $nombre, int $id)
    {
        $this->nombre = $nombre;
        $this->id = $id;
        $sql = "UPDATE medidas SET nombre = ? WHERE id = ?";
        $datos = array($this->nombre, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarMed(int $id)
    {
        $sql = "SELECT * FROM medidas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionMed(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE medidas SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function verificarPermiso(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d on p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
