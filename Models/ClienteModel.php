<?php
    
    //Herencia de la clase padre Mysql
    class ClienteModel extends Mysql
    {

        private $intIdCliente;
        private $strIdentificacion;
        private $strNombres;
        private $strApellidos;
        private $intTelefono;
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
        public function insertCliente(string $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $direccion, string $nit, string $nomfiscal, string $dirfiscal)
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



        } //Fin de la funcion insertCliente

        //Funcion para actualizar cliente
        public function updateCliente(int $idcliente, string $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $direccion, string $nit, string $nomfiscal, string $dirfiscal)
        {
            $this->intIdCliente = $idcliente;
            $this->strIdentificacion = $identificacion;
            $this->strNombres = $nombres;
            $this->strApellidos = $apellidos;
            $this->intTelefono = $telefono;
            $this->strEmail = $email;
            $this->strDireccion = $direccion;
            $this->strNit = $nit;
            $this->strNomFiscal = $nomfiscal;
            $this->strDirFiscal = $dirfiscal;

            //Ver datos que llegan a la funcion updateCliente
            //dep(get_object_vars($this));

            $sql = "SELECT identificacion,email FROM cliente WHERE 
            (email = :email AND idcliente != :id ) OR
            (identificacion = :ident AND idcliente != :id) AND
            status = 1";
            $arrData = array(":email" => $this->strEmail,
                     ":ident" => $this->strIdentificacion,
                     ":id" =>  $this->intIdCliente 
                    );
            $request_cliente = $this->select($sql,$arrData);

            if(empty($request_cliente))
         //Si el cliente no existe insertar
            {
                $sql = "UPDATE cliente SET identificacion = :ident, nombres = :nom, apellidos = :ape, telefono = :tel, email = :email,
                                         direccion = :dir, nit = :nit, nombrefiscal = :nomfiscal, direccionfiscal = :dirfiscal
                        WHERE idcliente = :id ";
                $arrData = array(":ident" =>  $this->strIdentificacion,
                                 ":nom" => $this->strNombres,
                                 ":ape" => $this->strApellidos,
                                 ":tel" => $this->intTelefono,
                                 ":email" => $this->strEmail,
                                 ":dir" => $this->strDireccion,
                                 ":nit" => $this->strNit,
                                 ":nomfiscal" => $this->strNomFiscal,
                                 ":dirfiscal" => $this->strDirFiscal,
                                 ":id" => $this->intIdCliente
                            );
                $request = $this->update($sql,$arrData);
                
                return $request;

            }else{
                return false;
            }




        } //Fin de la funcion updateCliente

        //Funcion getCliente para buscar y validar id cliente
        public function getCliente(int $idcliente)
        {
            
            $this->intIdCliente = $idcliente;
            $sql = "SELECT idcliente, 
                           identificacion, 
                           nombres, 
                           apellidos, 
                           email, DATE_FORMAT(datecreated, '%d-%m-%y') as fecha_Registro FROM cliente WHERE idcliente = :idcliente";
            $arrData = array(":idcliente" => $this->intIdCliente);
            $request = $this->select($sql,$arrData);
            return $request;


        } //Fin de la funcion getCliente


        //Method to fetch all clients WHERE status = 1 AND ORDER BY IDCLIENTE DESCb
        public function getClientes()
        {
            $sql = "SELECT idcliente, 
                           identificacion, 
                           nombres, apellidos, 
                           telefono, 
                           email, 
                           direccion, 
                           nit, nombrefiscal, 
                           direccionfiscal, status FROM cliente WHERE status != 0 ORDER BY idcliente DESC";
            $request = $this->select_all($sql);
            return $request;
        } //Fin de la funcion getClientes
    }

?>