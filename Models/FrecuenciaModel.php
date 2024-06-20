<?php

    //Herencia de la clase padre Mysql
    class FrecuenciaModel extends Mysql
    {

        private $intIdFrecuencia;
        private $strFrecuencia;
        private $strFecha;
        private $intStatus;
        
        public function __construct()
        {
            //Cargamos el constructor de la clase padre
            
            parent::__construct();
        }

        //Metodo para insertar una frecuencia
        public function insertFrecuencia(string $frecuencia)
        {
            $this->strFrecuencia = $frecuencia;

            //insert frecuencia sql
            $sql = "INSERT INTO frecuencia(frecuencia, status) VALUES(:frecuencia, 1)";
            $arrData = array(':frecuencia' => $this->strFrecuencia);

            $request = $this->insert($sql, $arrData);

            return $request;




        }

        //Metodo para obtener todas las frecuencias get
        public function getFrecuencias(){
            $sql = "SELECT * FROM frecuencia WHERE status != 0 ORDER BY idfrecuencia DESC"; 
            
            $request = $this->select_all($sql);

            return $request;

        }

        //Metodo para obtener una frecuencia por id
        public function getFrecuencia(int $idfrecuencia)
        {
            $this->intIdFrecuencia = $idfrecuencia;
            $sql = "SELECT * FROM frecuencia WHERE idfrecuencia = $this->intIdFrecuencia";
            
            $request = $this->select($sql, []);

            return $request;
        }
        

    }

?>