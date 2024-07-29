<?php

    //Herencia de la clase padre Mysql
    class UsuarioModel extends Mysql
    {

        private $intIdUsuario;
        private $strNombre;
        private $strApellido;
        private $strEmail;
        private $strPassword;

        
        public function __construct()
        {
            //Cargamos el constructor de la clase padre
            
            parent::__construct();
        }

        //Insertar un nuevo usuario
        public function insertUsuario( string $nombre, string $apellido, string $email, string $password){

            $this->strNombre = $nombre;
            $this->strApellido = $apellido;
            $this->strEmail = $email;
            $this->strPassword = $password;

            // dep(get_object_vars($this));

            //Sql query para validar que el usuario no exista
            $sql = "SELECT * FROM usuario WHERE email = '{$this->strEmail}' and Status != 0";
            
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $query_insert = "INSERT INTO usuario(nombre, apellido, email, password, status) 
                VALUES(:nom, :ape, :email, :pass, 1)";

                $arrData = array(':nom' => $this->strNombre,
                                 ':ape' => $this->strApellido,
                                 ':email' => $this->strEmail,
                                 ':pass' => $this->strPassword
                                );

                $request_insert = $this->insert($query_insert, $arrData);

                return $request_insert;
            }else{
                return "El usuario ya existe";
            }


        }

    }

?>