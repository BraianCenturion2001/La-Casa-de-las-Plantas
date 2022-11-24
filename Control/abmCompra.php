<?php

class abmCompra
{

    public function abm($datos){
        $resp=false;
        if($datos['action']== 'eliminar'){
            if($this->baja($datos)){
                $resp=true;
            }
        }
        if($datos['action']== 'modificar'){
            if($this->modificacion($datos)){
                $resp=true;
            }
        }
        if($datos['action']== 'alta'){
            if($this->alta($datos)){
                $resp=true;
            }
        }
        return $resp;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto
     * @param array $param
     * @return compra
     */
    private function cargarObjeto($param)
    {
        $objUsuario = new usuario();
        $objUsuario->setID($param['objusuario']);
        $objUsuario->cargar();
        $obj = null;
        if (array_key_exists('idcompra', $param) &&
            array_key_exists('cofecha', $param)&&
            array_key_exists('objusuario', $param)
        ) {
            $obj = new compra();
            $obj->setear($param['idcompra'], $param['cofecha'], $param['objusuario']);
        }
        return $obj;
    }
    private function cargarObjetoSinID($param)
    {
        $obj = null;
        if (
            array_key_exists('cofecha', $param) &&
            array_key_exists('idusuario', $param) 
        ) {
            $objusuario = new usuario();

            $objusuario->setID($param['idusuario']);

            $objusuario->cargar();

            $obj = new compra();
            $obj->setearSinID($param['cofecha'], $objusuario);
        }
        return $obj;
        
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return compra
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompra'])) {
            $obj = new compra();
            $obj->setear($param['idcompra'], null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompra'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     *
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        // $param['idrol'] =null;
        $objcompra = $this->cargarObjeto($param);
        // verEstructura($Objrol);
        if ($objcompra!=null and $objcompra->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function altaSinID($param)
    {
        $resp = false;
       
        $objCompra = $this->cargarObjetoSinID($param);
        if ($objCompra!=null and $objCompra->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objcompra = $this->cargarObjetoConClave($param);
            if ($objcompra!=null and $objcompra->eliminar()) {
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
    public function modificacion($param)
    {
        // echo "<i>**Realizando la modificación**</i>";

        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objcompra = $this->cargarObjeto($param);
            if ($objcompra!=null and $objcompra->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param<>null) {
            if (isset($param['idcompra'])) {
                $where.=" and idcompra ='".$param['idcompra']."'";
            }
            if (isset($param['cofecha'])) {
                $where.=" and cofecha ='".$param['cofecha']."'";
            }
            if (isset($param['objusuario'])) {
                $where.=" and objusuario ='".$param['objusuario']."'";
            }
        }
        $objC =  new compra();
        $arreglo = $objC->listar($where);
        return $arreglo;
    }

    
}
