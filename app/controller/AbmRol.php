<?php
class ABMRol{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
            
        }
        return $resp;

    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Rol
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idrol',$param)  and array_key_exists('rodescripcion',$param) ){
            $obj = new Rol();
            $obj->cargar($param['idrol'],$param['rodescripcion']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Rol
     */
    
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idrol']) ){
            $obj = new Rol();
            $obj->setear($param['idrol'], null);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idrol']))
            $resp = true;
        return $resp;
    }
    
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idrol'] =null;
        $elObjtTabla = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($elObjtTabla!=null and $elObjtTabla->insertar()){
            $resp = true;
        }
        return $resp;
        
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjeto($param);
            if($elObjtTabla!=null and $elObjtTabla->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    

    public function darUsuarios($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idusuario']))
                $where.=" and idusuario =".$param['idusuario'];
            if  (isset($param['idrol']))
                 $where.=" and idrol ='".$param['idrol']."'";
        }
        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);
        //echo "Van ".count($arreglo);
        return $arreglo;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idrol']))
                $where.=" and idrol =".$param['idrol'];
            if  (isset($param['rodescripcion']))
                 $where.=" and rodescripcion ='".$param['rodescripcion']."'";
         }
        $obj = new Rol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    public function listarRoles($condicion = "") {
                try {
                    $colRoles = Rol::listar($condicion);   
                } catch (PDOException $e) {
                    $this->setMsjError('Error Rol: ' . $e->getMessage());
                    $colRoles = [];
                }
                return $colRoles;
            }
            public function obtenerRolUsuario()
                {
                    $rolCliente = null;
            
                    try {
                        $roles = Rol::listar("rodescripcion= 'Alumno'");
            
                        if (!empty($roles)) {
                            $rolCliente = $roles[0];
                        }
                    } catch (PDOException $e) {
                        $this->setMsjError('Error' . $e->getMessage());
                    }
            
                    return $rolCliente;
                }   
}

// class AbmRol
// {
//     private $msjOp;

//     public function __construct() {}

//     public function getMsjError()
//     {
//         return $this->msjOp;
//     }

//     public function setMsjError($msjOp)
//     {
//         $this->msjOp = $msjOp;
//     }

//     public function buscarRol()
//     {
//         $resp = false;
        
//     }

//     public function crearRol() {}

//     public function modificarRol() {}

//     public function listarRoles($condicion = "") {
//         try {
//             $colRoles = Rol::listar($condicion);   
//         } catch (PDOException $e) {
//             $this->setMsjError('Error Rol: ' . $e->getMessage());
//             $colRoles = [];
//         }
//         return $colRoles;
//     }

//     public function eliminarRol() {}

//     public function obtenerRol() {}

//     public function obtenerRolAlumno()
//     {
//         $rolCliente = null;

//         try {
//             $roles = Rol::listar("rolDescr = 'Alumno'");

//             if (!empty($roles)) {
//                 $rolCliente = $roles[0];
//             }
//         } catch (PDOException $e) {
//             $this->setMsjError('Error' . $e->getMessage());
//         }

//         return $rolCliente;
//     }

//     public function darRolUsuario() {}

//     private function obtenerDatosRol()
//     {
//         $datos = darDatosSubmitted();
//         return [
//             'idrol' => $datos['idrol'] ?? null,
//             'rolDescr' => $datos['rolDescr'] ?? null
//         ];
//     }
// }

?>
