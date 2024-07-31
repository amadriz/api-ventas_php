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

        public function getUsuario(int $idusuario)
        {
            $this->intIdUsuario = $idusuario;
            $sql = "SELECT id_usuario,
							nombre,
							apellido,
							email,
							DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro
							FROM usuario WHERE id_usuario = :iduser AND status != :status ";
            $arrData = array(":iduser" => $this->intIdUsuario, ":status" => 0);
            $request = $this->select($sql,$arrData);
            return $request;
        }

        //fetch all
        public function getUsuarios(){
            $sql = "SELECT id_usuario,
                            nombre,
                            apellido,
                            email,
                            DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro
                            FROM usuario WHERE status != 0";
            
            
            $request = $this->select_all($sql);
            
            
            return $request;


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

            // dep($request);

            if(empty($request))
            {
                $query_insert = "INSERT INTO usuario(nombre, apellido, email, password) 
                VALUES(:nom, :ape, :email, :pass)";

                $arrData = array(':nom' => $this->strNombre,
                                 ':ape' => $this->strApellido,
                                 ':email' => $this->strEmail,
                                 ':pass' => $this->strPassword
                                );

                $request_insert = $this->insert($query_insert, $arrData);

                return $request_insert;
            }else{
                return false;
            }


        } //Fin de la función insertUsuario

        public function updateUsuario(int $idusuario, string $nombres, string $apellidos, string $email, string $password){
            $this->intIdUsuario = $idusuario;
            $this->strNombre = $nombres;
			$this->strApellido = $apellidos;
			$this->strEmail = $email;
			$this->strPassword = $password;

            $sql = "SELECT email FROM usuario WHERE 
                    (email = :email AND id_usuario != :id ) AND
                    status != 0";
            $arrData = array(":email" => $this->strEmail,":id" => $this->intIdUsuario);
            $request_usuario = $this->select($sql,$arrData);
            if(empty($request_usuario))
            {
                if($this->strPassword == "")
                {
                    $sql = "UPDATE usuario SET nombre = :nom, apellido = :ape, email = :email
                    WHERE id_usuario = :id ";
                    $arrData = array(":nom" => $this->strNombre,
                                    ":ape" =>  $this->strApellido,
                                    ":email" => $this->strEmail,
                                    ":id" => $this->intIdUsuario);

                }else{
                    $sql = "UPDATE usuario SET nombre = :nom, apellido = :ape, email = :email, password = :pass
                    WHERE id_usuario = :id ";
                    $arrData = array(":nom" => $this->strNombre,
                                    ":ape" =>  $this->strApellido,
                                    ":email" => $this->strEmail,
                                    ":pass" => $this->strPassword,
                                    ":id" => $this->intIdUsuario);
                }
                $request = $this->update($sql,$arrData);
                return $request;
            }else{
                return false;
            }

        } //Fin de la función updateUsuario

        public function deleteUsuario(int $idusuario){
            $this->intIdUsuario = $idusuario;
            $sql = "UPDATE usuario SET status = :estado WHERE id_usuario = :id ";
            $arrData = array(":estado" => 0, ":id" => $this->intIdUsuario );
            $request = $this->update($sql,$arrData);
            return $request;
        }

        public function loginUser(string $email, string $password)
        {
            $this->strEmail = $email;
            $this->strPassword = $password;

            //BINARY para que sea case sensitive
            $sql = "SELECT id_usuario, status FROM usuario WHERE email =  BINARY :email AND password = BINARY :pass AND status != 0";
            $arrData = array(":email" => $this->strEmail, ":pass" => $this->strPassword);
            $request = $this->select($sql,$arrData);

            return $request;
        }

    }

?>