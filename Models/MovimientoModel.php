<?php

    //Herencia de la clase padre Mysql
    class MovimientoModel extends Mysql
    {

        //Tipos de movimiento
        private $strMovimiento;
        private $intTipoMovimiento;
        private $strDescripcion;

        //Movimientos
        private $intIdMovimiento;
        private $intIdCuenta;
        private $descripcion;
        private $intMonto;
        private $intMovimiento;

        
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


        public function insertMovimiento(int $idcuenta, int $idMovimiento, int $movimiento, float $monto, string $descripcion){
            $this->intIdCuenta = $idcuenta;
            $this->intIdMovimiento = $idMovimiento;
            $this->intTipoMovimiento = $movimiento;
            $this->intMonto = $monto;
            $this->descripcion = $descripcion;

            $sql = "INSERT INTO movimiento(cuentaid,idtipomovimiento,movimiento,monto,descripcion) VALUES(:idcuenta,:idmovimiento,:movimiento,:monto,:descripcion)";

            $arrData = array(":idcuenta" => $this->intIdCuenta, 
                             ":idmovimiento" => $this->intIdMovimiento,
                             ":movimiento" => $this->intTipoMovimiento, 
                             ":monto" => $this->intMonto, 
                             ":descripcion" => $this->descripcion
                            );

            $request = $this->insert($sql, $arrData);

            return $request;
                        

        }
        
        public function selectMovimientos()
        {
            $sql = "SELECT m.idmovimiento, m.cuentaid, m.movimiento, m.monto, m.descripcion, DATE_FORMAT(m.datecreated, '%d-%m-%y' ) as fechaRegistro FROM movimiento m INNER JOIN tipo_movimiento tm ON m.idtipomovimiento = tm.idtipomovimiento";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectMovimiento(int $idmovimiento)
        {
            $this->intIdMovimiento = $idmovimiento;
            $sql = "SELECT m.idmovimiento, m.cuentaid, m.movimiento, m.monto, m.descripcion, DATE_FORMAT(m.datecreated, '%d-%m-%y' ) as fechaRegistro FROM movimiento m INNER JOIN tipo_movimiento tm ON m.idtipomovimiento = tm.idtipomovimiento WHERE m.idmovimiento = :idmovimiento";
    $arrData = array(":idmovimiento" => $this->intIdMovimiento);
    $request = $this->select($sql, $arrData);
    return $request;
        }
    }

?>