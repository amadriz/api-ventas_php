<?php
    class Producto extends Controllers{

        public function __construct()
        {
            parent::__construct();
        }

        public function productos()
        {
            echo "Extraer todos los productos";
        }

        public function producto($idproducto)
        {
            echo "Extraer un producto ".$idproducto;
        }

        public function registro()
        {
            echo "Registrar un producto";
        }

        public function actualizar($idproducto)
        {
            echo "Actualizar un producto ". $idproducto;
        }

        public function eliminar($idproducto)
        {
            echo "Eliminar un producto ". $idproducto;
        }

        


    }


?>