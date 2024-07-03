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

        public function selectCuentas(){
            //fetch cuentas
            $sql = "SELECT * FROM cuenta WHERE status = 1 ORDER BY idcliente DESC";
            $request = $this->select_all($sql);
            return $request;
        }

        public function getCuenta(int $idcuenta)
        {
            $this->intIdCuenta = $idcuenta;
            $sql = "SELECT c.idcuenta, c.idfrecuencia, f.frecuencia, c.monto, c.cuotas, c.monto_cuota, c.cargo, c.saldo,
                           DATE_FORMAT(c.datecreated, %d-%m-%y) as fechaRegistro,
                           c.clienteid, cl.nombre, cl.apellido, cl.telefono, cl.email, cl.direccion, cl.nit, cl.nombrefiscal,
                           cl.direccionfiscal,
                           p.idproducto, p.codigo as cod_producto, p.nombre 
                           FROM cuenta c 
                           INNER JOIN frecuencia f 
                           ON c.idfrecuencia = f.idfrecuencia
                           INNER JOIN cliente cl 
                           ON c.idcliente = cl.idcliente 
                           INNER JOIN producto p
                            ON c.idproducto = p.idproducto
                            WHERE c.idcuenta = $this->intIdCuenta";

            $arrData = array($this->intIdCuenta);                
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

