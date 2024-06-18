<?php

    //Herencia de la clase padre Mysql
    class ProductoModel extends Mysql
    {

        //Se definen variables
        private $intIdProducto;
        private $strCodigo;
        private $strNombre;
        private $strDescripcion;
        private $strPrecio;
        private $strDateCreated;
        private $intStatus;



        
        public function __construct()
        {
            //Cargamos el constructor de la clase padre
            
            parent::__construct();
        }

        //Metodo para fetch todos los productos
        public function getProductos(){

            $sql = "SELECT idproducto,
                           codigo,
                           nombre,
                           descripcion,
                           precio,
                           datecreated,
                           status FROM producto WHERE status != 0 ORDER BY idproducto DESC"; 
            
            $request = $this->select_all($sql);

            return $request;

        }

        //Method to get a product by id
        public function getProducto(int $idproducto)
        {
            $this->intIdProducto = $idproducto;
            $sql = "SELECT idproducto,
                           codigo,
                           nombre,
                           descripcion,
                           precio,
                           datecreated,
                           status FROM producto WHERE idproducto = $this->intIdProducto";
            
            $request = $this->select($sql);

            return $request;
        }

        //Method to insert a product
        public function setProducto(string $codigo, string $nombre, string $descripcion, string $precio)
        {

            $this->strCodigo = $codigo;
            $this->strNombre = $nombre;
            $this->strDescripcion = $descripcion;
            $this->strPrecio = $precio;

            $sql = "SELECT * FROM producto WHERE codigo = :cod AND status = 1";

            $arrData = array(":cod" => $this->strCodigo);
            $producto = $this->select($sql, $arrData);

            if(empty($producto))
            {
                $query_insert = "INSERT INTO producto(codigo, nombre, descripcion, precio) VALUES(:codigo, :nombre, :descripcion, :precio)";
                $arrData = array(":codigo" => $this->strCodigo,
                                 ":nombre" => $this->strNombre,
                                 ":descripcion" => $this->strDescripcion,
                                 ":precio" => $this->strPrecio);
                $request_insert = $this->insert($query_insert, $arrData);
               
                return $request_insert;


            } else {
                $return = "El producto ya existe";
            }

        }    



    }

?>