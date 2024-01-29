<?php
    
    //Herencia de la clase padre Mysql
    class ClienteModel extends Mysql
    {

        private $intIdCliente;
        private $strIdentificacion;
        private $strNombres;
        private $strApellidos;
        private $strTelefono;
        private $strEmail;
        private $strDireccion;
        private $strNit;
        private $strNomFiscal;
        private $intStatus;
        
        public function __construct()
        {
            //Cargamos el constructor de la clase padre
            parent::__construct();
        }

        //Invocamos la funcion para obtener los clientes
        public function insertCliente(string $identificacion, string $nombres, string $apellidos, string $telefono, string $email, string $direccion, string $nit, string $nomfiscal, string $dirfiscal)
        {
            $this->strIdentificacion = $identificacion;
            $this->strNombres = $nombres;
            $this->strApellidos = $apellidos;
            $this->intTelefono = $telefono;
            $this->strEmail = $email;
            $this->strDireccion = $direccion;
            $this->strNit = $nit;
            $this->strNomFiscal = $nomfiscal;
            $this->strDirFiscal = $dirfiscal;

            //Sql query validar que el cliente este activo y que exista
            
            $sql = "SELECT identificacion, email FROM cliente WHERE (identificacion = :ident OR email = :email) and status = :estado";
            $arrParams = array(':ident' => $this->strIdentificacion, ':email' => $this->strEmail, ':estado' => 1);

            $request = $this->select($sql, $arrParams);

            //Si el cliente no existe insertar
            if(!empty($request))
            {
                return false;
            }else{
                $query_inset= "INSERT INTO cliente(identificacion,nombres,apellidos,telefono,email,direccion,nit,nombrefiscal,direccionfiscal)
                                VALUES(:ident,:nom,:ape,:tel,:email,:dir,:nit,:nomfiscal,:dirfiscal)";
                $arrData = array(":ident" =>  $this->strIdentificacion,
                                 ":nom" => $this->strNombres,
                                 ":ape" => $this->strApellidos,
                                 ":tel" => $this->intTelefono,
                                 ":email" => $this->strEmail,
                                 ":dir" => $this->strDireccion,
                                 ":nit" => $this->strNit,
                                 ":nomfiscal" => $this->strNomFiscal,
                                 ":dirfiscal" => $this->strDirFiscal
                            );
                $request_insert = $this->insert($query_inset,$arrData);
                return $request_insert;
            }


            //Get objet vars retorna un array asociativo con todas las propiedades
            //y valores de un objeto
            dep(get_object_vars($this));



        }
        

    }

?>