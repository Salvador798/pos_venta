<?php
class CajaModel extends Query
{
    private $caja, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getCajas()
    {
        $sql = "SELECT * FROM caja";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarCajas(string $caja)
    {
        $this->caja = $caja;
        $verificar = "SELECT * FROM caja WHERE caja = '$this->caja'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO caja (caja) VALUES (?)";
            $datos = array($this->caja);
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
    public function modificarCajas(string $caja, int $id)
    {
        $this->caja = $caja;
        $this->id = $id;
        $sql = "UPDATE caja SET caja = ? WHERE id = ?";
        $datos = array($this->caja, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarCaj(int $id)
    {
        $sql = "SELECT * FROM caja WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionCaj(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE caja SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
