<?php

class AbmRol
{
    private $msjOp;

    public function __construct() {}

    public function getMsjError()
    {
        return $this->msjOp;
    }

    public function setMsjError($msjOp)
    {
        $this->msjOp = $msjOp;
    }

    public function buscarRol()
    {
        $objRol = null;
        $rolModelo = $this->obtenerDatosRol();
        $idRol = $rolModelo['idrol'];

        if ($idRol) {
            try {
                $colRol = Rol::listar("idrol = '" . $idRol . "'");
                if (!empty($colRol)) $objRol = $colRol[0];
            } catch (PDOException $e) {
                $this->setMsjError('Error: ' . $e->getMessage());
            }
        }
        return $objRol;
    }

    public function crearRol() {}

    public function modificarRol() {}

    public function listarRoles($condicion = "") {
        try {
            $colRoles = Rol::listar($condicion);   
        } catch (PDOException $e) {
            $this->setMsjError('Error Rol: ' . $e->getMessage());
            $colRoles = [];
        }
        return $colRoles;
    }

    public function eliminarRol() {}

    public function obtenerRol() {}

    public function obtenerRolCliente()
    {
        $rolCliente = null;

        try {
            $roles = Rol::listar("rodescripcion = 'Cliente'");

            if (!empty($roles)) {
                $rolCliente = $roles[0];
            }
        } catch (PDOException $e) {
            $this->setMsjError('Error' . $e->getMessage());
        }

        return $rolCliente;
    }

    public function darRolUsuario() {}

    private function obtenerDatosRol()
    {
        $datos = darDatosSubmitted();
        return [
            'idrol' => $datos['idrol'] ?? null,
            'rolDescr' => $datos['rolDescr'] ?? null
        ];
    }
}
