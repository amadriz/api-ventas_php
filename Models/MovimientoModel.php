<?php

    //Herencia de la clase padre Mysql
    class MovimientoModel extends Mysql
    {

        private $intIdMovimiento;
        private $strMovimiento;
        private $intTipoMovimiento;
        private $strDescripcion;

        
        public function __construct()
        {
            //Cargamos el constructor de la clase padre
            
            parent::__construct();
        }

        public function insertTipoMovimiento(string $movimiento, int $tipomovimiento, string $descripcion)
        {
            $this->strMovimiento = $movimiento;
            $this->intTipoMovimiento = $tipomovimiento;
            $this->strDescripcion = $descripcion;

            $sql = "SELECT * FROM tipo_movimiento WHERE movimiento = :mov AND status != 0";
            $arrData = array('mov' => $this->strMovimiento);
            $request = $this->select($sql, $arrData);

            //dep($request);

            if(empty($request))
            {
                $query_insert  = "INSERT INTO tipo_movimiento(movimiento,tipo_movimiento,descripcion) VALUES(:mov,:tipo_mov,:desc)";
                $arrData = array(":mov" => $this->strMovimiento, "tipo_mov" => $this->intTipoMovimiento, ":desc" => $this->strDescripcion);
                $request_insert = $this->insert($query_insert,$arrData);
                return $request_insert;
            }else{
                return false;
            }
         
        }

        public function selectTiposMovimiento()
        {
            $sql = "SELECT * FROM tipo_movimiento WHERE status = 1";
            $request = $this->select_all($sql);
            return $request;
        }
    }

?>