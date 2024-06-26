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

        public function insertCuenta(int $idcliente, int $productId, int $frecuenciaId, float $monto, int $cuotas, float $montocuotas, float $cargo, float $saldo)
        {
            $this->intIdCliente = $idcliente;
            $this->intIdProduct = $productId;
            $this->intIdFrecuencia = $frecuenciaId;
            $this->intMonto = $monto;
            $this->intcuotas = $cuotas;
            $this->intMontoCuotas = $montocuotas;
            $this->intcargo = $cargo;
            $this->intsaldo = $saldo;

            //Check what is the value of the variables
           // dep(get_object_vars($this));

            $sql = "INSERT INTO cuenta (idcliente, idproducto, idfrecuencia, monto, cuotas, monto_cuotas, cargo, saldo) 
                        VALUES (:idcliente, :idproduct, :idfrecuencia, :monto, :cuotas, :montocuotas, :cargo, :saldo)";

            $arrData = array(':idcliente' => $this->intIdCliente, 
                             ':idproducto' => $this->intIdProduct, 
                             ':idfrecuencia' => $this->intIdFrecuencia, 
                             ':monto' => $this->intMonto, 
                             ':cuotas' => $this->intcuotas, 
                             ':montocuotas' => $this->intMontoCuotas, 
                             ':cargo' => $this->intcargo, 
                             ':saldo' => $this->intsaldo
                            );

            $request_insert = $this->insert($sql, $arrData);
            return $request_insert;

        }

    }

?>