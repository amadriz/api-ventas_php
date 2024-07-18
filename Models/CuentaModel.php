<?php

    //Herencia de la clase padre Mysql
    class CuentaModel extends Mysql
    {
        private $intIdCuenta;
        private $intIdCliente;
        private $intIdProduct;
        private $intIdFrecuencia;
        private $intMonto;
        private $intcuotas;
        private $intMontoCuotas;
        private $intcargo;
        private $intsaldo;



        
        public function __construct()
        {
            //Cargamos el constructor de la clase padre
            
            parent::__construct();
        }

        //Method to get Movimientos
        public function getMovimientos(int $idcuenta)
        {
            $this->intIdCuenta = $idcuenta;
            $sql = "SELECT m.idmovimiento, m.monto, m.descripcion, DATE_FORMAT(m.datecreated, '%d-%m-%Y') as fechaRegistro,
                    tm.idtipomovimiento, tm.movimiento, tm.tipo_movimiento
                    FROM movimiento m
                    INNER JOIN tipo_movimiento tm ON m.idtipomovimiento = tm.idtipomovimiento
                    WHERE m.cuentaid = $this->intIdCuenta AND m.status != 0";
                    
            
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectCuentas(){
            //fetch cuentas
            $sql = "SELECT c.idcuenta,
                    DATE_FORMAT(c.datecreated, '%d-%m-%Y') as fechaRegistro,
                    concat(cl.nombres, ' ', cl.apellidos) as cliente,
                    f.frecuencia,
                    c.cuotas,
                    c.monto_cuotas,
                    c.cargo,
                    c.saldo
                    FROM cuenta c 
                    INNER JOIN frecuencia f 
                    ON c.idfrecuencia = f.idfrecuencia
                    INNER JOIN cliente cl 
                    ON c.idcliente = cl.idcliente 
                    WHERE c.status != 0 ORDER BY c.idcuenta DESC";
            $request = $this->select_all($sql);
            return $request;
            
        }

        public function getCuenta(int $idcuenta)
        {
            $this->intIdCuenta = $idcuenta;
            $sql = "SELECT c.idcuenta, c.idfrecuencia, f.frecuencia, c.monto, c.cuotas, c.monto_cuotas, c.cargo, c.saldo,
                           DATE_FORMAT(c.datecreated, '%d-%m-%Y') as fechaRegistro,
                           c.idcliente, cl.nombres, cl.apellidos, cl.telefono, cl.email, cl.direccion, cl.nit, cl.nombrefiscal,
                           cl.direccionfiscal,
                           p.idproducto, p.codigo as cod_producto, p.nombre 
                           FROM cuenta c 
                           INNER JOIN frecuencia f ON c.idfrecuencia = f.idfrecuencia
                           INNER JOIN cliente cl ON c.idcliente = cl.idcliente 
                           INNER JOIN producto p ON c.idproducto = p.idproducto
                           WHERE c.idcuenta = :idcuenta";
        
            $arrData = array(":idcuenta" => $this->intIdCuenta);                     
            $request = $this->select($sql, $arrData);
            return $request;
        }

        public function insertCuenta(int $idcliente, int $idproducto, int $idfrecuencia, float $monto, int $cuotas, float $montocuotas, float $cargo, float $saldo)
        {
            $this->intIdCliente = $idcliente;
            $this->intIdProduct = $idproducto;
            $this->intIdFrecuencia = $idfrecuencia;
            $this->intMonto = $monto;
            $this->intcuotas = $cuotas;
            $this->intMontoCuotas = $montocuotas;
            $this->intcargo = $cargo;
            $this->intsaldo = $saldo;

            //Check what is the value of the variables
           // dep(get_object_vars($this));

           
           $sql = "INSERT INTO cuenta (idcliente, idproducto, idfrecuencia, monto, cuotas, monto_cuotas, cargo, saldo) 
                   VALUES (:idcl, :idpr, :idfr, :monto, :cuotas, :mtcuotas, :cargo, :saldo)";

            $arrData = array(':idcl' => $this->intIdCliente, 
                             ':idpr' => $this->intIdProduct, 
                             ':idfr' => $this->intIdFrecuencia, 
                             ':monto' => $this->intMonto, 
                             ':cuotas' => $this->intcuotas, 
                             ':mtcuotas' => $this->intMontoCuotas, 
                             ':cargo' => $this->intcargo, 
                             ':saldo' => $this->intsaldo
                            );

            $request_insert = $this->insert($sql, $arrData);
            return $request_insert;

        }

    }

