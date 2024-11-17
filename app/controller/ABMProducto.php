<?php 

class AMBProducto {
    private $mensajeOperacion;
    public function __construct() {}
    
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion): self
    {
        $this->mensajeOperacion = $mensajeOperacion;

        return $this;
    }
    /**
    * Gestiona las operaciones de alta, baja y modificación según la acción dada
    * @param array $datos
    * @return bool
    */
    public function gestionar($datos) {
        $accion = $datos['accion'] ?? '';
        $resp = null;
        switch ($accion) {
            case 'agregar':
                $resp = $this->cargarObjeto($datos);
            case 'modificar':
                $resp = $this->modificacion($datos);
            case 'borrar':
                $resp = $this->baja($datos);
            default:
                $resp = false;
        }
        return $resp;
    }
    
    public function cargar($datos) {
    
    }

    public function agregarProducto() { //alta
    }
        /**
         * Carga un objeto Producto con los datos proporcionados
         * @param array $datos
         * @return Producto|null
         */
        private function cargarProducto($datos) {
            $resp = false;

            if (!isset($datos['idProducto'], $datos['proNombre'], $datos['proDetalle'], $datos['precio'], $datos['proCantStock'])) {
                $resp = null;
            } else {
                $producto = new Producto();
                $producto->cargar($datos['idProducto'], $datos['proNombre'], $datos['proDetalle'], $datos['precio'], $datos['proCantStock']);
                $resp = $producto;
            }
            return $resp;
        }
    
        /**
         * Carga un objeto Producto solo con la clave primaria (idProducto)
         * @param array $datos
         * @return Producto|null
         */
        private function cargarObjetoConClave($datos) {
            if (!isset($datos['idProducto'])) {
                return null;
            }
            
            $producto = new Producto();
            $producto->cargar($datos['idProducto'], null, null, null, null);
            return $producto;
        }
    
        /**
         * Realiza el alta de un producto
         * @param array $datos
         * @return bool
         */
        private function alta($datos) {
            $datos['idProducto'] = null; // Generar un nuevo ID para un producto nuevo
            $producto = $this->cargarObjeto($datos);
            return $producto !== null && $producto->insertar();
        }
    
        /**
         * Realiza la baja de un producto
         * @param array $datos
         * @return bool
         */
        private function baja($datos) {
            $producto = $this->cargarObjetoConClave($datos);
            return $producto !== null && $producto->eliminar();
        }
    
        /**
         * Realiza la modificación de un producto existente
         * @param array $datos
         * @return bool
         */
        private function modificacion($datos) {
            $producto = $this->cargarObjeto($datos);
            return $producto !== null && $producto->modificar();
        }
    
        /**
         * Busca productos según los criterios dados en $datos
         * @param array $datos
         * @return array
         */
        public function buscar($datos) {
            $where = " true ";
            foreach ($datos as $campo => $valor) {
                $where .= " AND $campo = '$valor'";
            }
    
            $producto = new Producto();
            return $producto->listar($where);
        }
    
        /**
         * Verifica si el stock de un producto es suficiente para la cantidad deseada
         * @param int $idProducto
         * @param int $cantidad
         * @return bool
         */
        public function verificarStock($idProducto, $cantidad) {
            $producto = $this->buscar(['idProducto' => $idProducto])[0] ?? null;
            return $producto !== null && $producto->getProCantStock() >= $cantidad;
        }
        
    }