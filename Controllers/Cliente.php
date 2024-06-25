<?php
    class Cliente extends Controllers{

        public function __construct()
        {
            parent::__construct();
        }

        public function clientes(){
            //Validar el metodo
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];
                //Validar si es un metodo GET
                if($method == "GET")
                {
                    
                    //Extraer todos los clientes
                    $arrData = $this->model->getClientes();

                    //if arrdata empty return error
                    if(empty($arrData))
                    {
                        $response = array(
                            "status" => false,
                            "message" => "No hay clientes registrados"
                        );
                        $code = 400;
                        jsonResponse($response, $code);
                        die();
                    }else
                    {
                        $response = array(
                            "status" => true,
                            "message" => "Clientes encontrados",
                            "data" => $arrData
                        );
                        $code = 200;
                    }
                }
                else
                {
                    $response = array(
                    "status" => 400,
                    "message" => "Error al consultar solo se permiten metodos GET"
                    );

                    $code = 400;
                }
                jsonResponse($response, $code);
                die();
            } catch (Exception $ex) {
                //throw $ex
                echo "Error: ".$ex->getMessage();
            }
        }

        
        public function cliente($idcliente)
        {
            //devolver un cliente por id
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];
                //Validar si es un metodo GET
                if($method == "GET")
                {
                    //Si el id es vacio o no es numerico devolver error
                    if(empty($idcliente) || !is_numeric($idcliente)){
                        $response = array(
                            "status" => false,
                            "message" => "Error en el id del cliente"
                        );
                        jsonResponse($response, 400);
                        die();
                    }

                    //Buscar en el metodo getCliente del modelo el cliente por id
                    $arrCliente = $this->model->getCliente($idcliente);
                    
                    if(empty($arrCliente))
                    {
                        $response = array(
                            "status" => false,
                            "message" => "El cliente no existe"
                        );
                        $code = 400;
                        jsonResponse($response, $code);
                        die();
                    }else
                    {
                        $response = array(
                            "status" => true,
                            "message" => "Cliente encontrado",
                            "data" => $arrCliente
                        );
                        $code = 200;
                    }

                }
                else
                {
                    $response = array(
                    "status" => 400,
                    "message" => "Error al consultar" .$method
                    );

                    $code = 400;
                }   
                
                jsonResponse($response, $code);
                die();

                } //end try
                    catch (Exception $ex) {
                    //throw $ex
                    echo "Error: ".$ex->getMessage();
                } //end catch

        } //end function cliente


         //Create function registro
         public function registro()
         {
             try {
                 $method = $_SERVER['REQUEST_METHOD'];
                 $response = [];
 
 
                 //Validar si es un metodo post
                 if($method == "POST")
                 {
                     
                    $_POST = json_decode(file_get_contents('php://input'), true);
 
                    //Validar identificacion
                      if(empty($_POST['identificacion']))
                      {
                             $response = array(
                             "status" => false,
                             "message" => "Error en la identificación"
                             );
                             jsonResponse($response, 400);
                             die();
     
                      }
 
                    //Validar nombres
                    if(empty($_POST['nombres']) || !testString($_POST['nombres']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en el nombre"
                        );
                        jsonResponse($response, 400);
                        die();
                    }
                    //Validar apellidos
                    if(empty($_POST['apellidos']) || !testString($_POST['apellidos']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en el apellido"
                        );
                        jsonResponse($response, 400);
                        die();     
                    }
                    //validar telefono
                    if(empty($_POST['telefono']) || !testEntero($_POST['telefono']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en el telefono"
                        );
                        jsonResponse($response, 400);
                        die();
                    }
                    //validar email
                    if(empty($_POST['email']) || !testEmail($_POST['email']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en el email"
                        );
                        jsonResponse($response, 400);
                        die();
                    }
                    //validar direccion
                    if(empty($_POST['direccion']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en la direccion"
                        );
                        jsonResponse($response, 400);
                        die();
                    }
 
                     //Almacenar datos en variables
 
                     $strIdentificacion =  $_POST['identificacion'];
                     $strNombres =  ucwords(strtolower($_POST['nombres']));
                     $strApellidos =  ucwords(strtolower($_POST['apellidos']));
                     $intTelefono =  $_POST['telefono'];
                     $strEmail =  strtolower($_POST['email']);
                     $strDireccion =  $_POST['direccion'];
                     //strClean es una funcion de helpers.php para limpiar los datos de caracteres especiales
                     $strNit = !empty($_POST['nit']) ? strClean($_POST['nit']) : "";
                     $strNomFiscal = !empty($_POST['nombrefiscal']) ? strClean($_POST['nombrefiscal']) : "";
                     $strDirFiscal = !empty($_POST['direccionfiscal']) ? strClean($_POST['direccionfiscal']) : "";
 
                     $request = $this->model->insertCliente($strIdentificacion, 
                                                            $strNombres, 
                                                            $strApellidos, 
                                                            $intTelefono, 
                                                            $strEmail, 
                                                            $strDireccion, 
                                                            $strNit, 
                                                            $strNomFiscal, 
                                                            $strDirFiscal);

                    Print_r($request);
 
 
 
                 if($request > 0)
                 {
                     $arrCliente = array('idcliente' => $request,
                                     'identificacion' => $strIdentificacion,
                                     'nombres' => $strNombres,
                                     'apellidos' => $strApellidos,
                                     'telefono' => $intTelefono,
                                     'email' => $strEmail,
                                     'direccion' => $strDireccion,
                                     'nit' => $strNit,
                                     'nombreFiscal' => $strNomFiscal,
                                     'direccionFiscal' => $strDirFiscal
                                     );
                     $response = array('status' => true , 'msg' => 'Datos guardados correctamente', 'data' => $arrCliente);                
                 }else{
                     $response = array('status' => false , 'msg' => 'La identificación o el email ya existe');
                 }
                 $code = 200;  
                         
                 }else{
                     $response = array(
                     "status" => 400,
                     "message" => "Error al registrar"
                     );
 
                     $code = 400;
                 } //end if method post
                 
                 $code = 200;
                 //Llamamos funcion response desde helpers.php
                 jsonResponse($response, $code);
                 die();
                 
             } //end if method post
             catch(Exception $e){
                 //show error in screen
                 echo "Error: ".$e->getMessage();
 
             }
             die();
         }

        //UPDATE cliente
        public function actualizar($idcliente)
        {
            //Validar el tipo de solicitud
            try {

                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];
                //Array para almacenar los datos del cliente a actualizar
                $arrdata = json_decode(file_get_contents("php://input"), true);

                
                //Validar si es un metodo PUT
                if($method == "PUT")
                {
                    
                    //Validar datos
                    if(empty($idcliente) || !is_numeric($idcliente)){
                        $response = array(
                            "status" => false,
                            "message" => "Error en el id del cliente"
                        );
                        jsonResponse($response, 400);
                        die();
                    }

                    //Validar identificacion
                    if(empty($arrdata['identificacion']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en la identificación"
                        );
                        jsonResponse($response, 400);
                        die();

                    }
                    //Validar nombres
                    if(empty($arrdata['nombres']) || !testString($arrdata['nombres']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en el nombre"
                        );
                        jsonResponse($response, 400);
                        die();
                    }
                    //Validar apellidos
                    if(empty($arrdata['apellidos']) || !testString($arrdata['apellidos']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en el apellido"
                        );
                        jsonResponse($response, 400);
                        die();     
                    }
                    //validar telefono
                    if(empty($arrdata['telefono']) || !testEntero($arrdata['telefono']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en el telefono"
                        );
                        jsonResponse($response, 400);
                        die();
                    }
                    //validar email
                    if(empty($arrdata['email']) || !testEmail($arrdata['email']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en el email"
                        );
                        jsonResponse($response, 400);
                        die();
                    }
                    //validar direccion
                    if(empty($arrdata['direccion']))
                    {
                        $response = array(
                        "status" => false,
                        "message" => "Error en la direccion"
                        );
                        jsonResponse($response, 400);
                        die();
                    }

                    //Almacenar datos en variables
                    //Ucwords convierte la primera letra en mayuscula
                    //Strtolower convierte todo en minuscula
                    $strIdentificacion =  $arrdata['identificacion'];
                    $strNombres =  ucwords(strtolower($arrdata['nombres']));
                    $strApellidos =  ucwords(strtolower($arrdata['apellidos']));
                    $intTelefono =  $arrdata['telefono'];
                    $strEmail =  strtolower($arrdata['email']);
                    $strDireccion =  $arrdata['direccion'];
                    //operador ternario para validar si el campo esta vacio
                    $strNit = !empty($arrdata['nit']) ? strClean($arrdata['nit']) : "";
                    $strNomFiscal = !empty($arrdata['nombrefiscal']) ? strClean($arrdata['nombrefiscal']) : "";
                    $strDirFiscal = !empty($arrdata['direccionfiscal']) ? strClean($arrdata['direccionfiscal']) : "";

                    //Validar si el cliente existe
                    $buscar_cliente = $this->model->getCliente($idcliente);

                    if(empty($buscar_cliente))
                    {
                        $response = array(
                            "status" => false,
                            "message" => "El cliente no existe"
                        );
                        $code = 400;
                        jsonResponse($response, $code);
                        die();
                    }
                    

                    //enviar los datos al modelo
                    $request = $this->model->updateCliente($idcliente, 
                                                           $strIdentificacion, 
                                                           $strNombres, 
                                                           $strApellidos, 
                                                           $intTelefono, 
                                                           $strEmail, 
                                                           $strDireccion, 
                                                           $strNit, 
                                                           $strNomFiscal, 
                                                           $strDirFiscal);
                    
                    if($request)
                    {
                        //Return updated data
                        $arrdata = array('idcliente' => $idcliente,
                                        'identificacion' => $strIdentificacion,
                                        'nombres' => $strNombres,
                                        'apellidos' => $strApellidos,
                                        'telefono' => $intTelefono,
                                        'email' => $strEmail,
                                        'direccion' => $strDireccion,
                                        'nit' => $strNit,
                                        'nombreFiscal' => $strNomFiscal,
                                        'direccionFiscal' => $strDirFiscal
                                        );



                                        $response = array('status' => true , 'msg' => 'Datos actualizados correctamente', 'data' => $arrdata);
                    }else
                    {
                        $response = array('status' => false , 'msg' => 'La identificación o el email ya existe');
                    }

                    
                    $code = 200;

                }
                else
                {
                    $response = array(
                    "status" => 400,
                    "message" => "Error al actualizar"
                    );

                    $code = 400;
                }

                jsonResponse($response, $code);
                die();

                
                
            } catch (Exception $ex) {
                //throw $ex
                echo "Error: ".$ex->getMessage();
            }
        }

        //delete cliente
        public function eliminar($idcliente)
        {
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];
                //Validar si es un metodo DELETE
                if($method == "DELETE")
                {
                    //Si el id es vacio o no es numerico devolver error
                    if(empty($idcliente) || !is_numeric($idcliente)){
                        $response = array(
                            "status" => false,
                            "message" => "Error en el id del cliente"
                        );
                        jsonResponse($response, 400);
                        die();
                    }

                    //Validar si el cliente existe
                    $buscar_cliente = $this->model->getCliente($idcliente);

                    if(empty($buscar_cliente))
                    {
                        $response = array(
                            "status" => false,
                            "message" => "El cliente no existe"
                        );
                        $code = 400;
                        jsonResponse($response, $code);
                        die();
                    }

                    //Hacemos request al modelo
                    $request = $this->model->deleteCliente($idcliente);

                    if($request)
                    {
                        $response = array("status" => true,"message" => "Cliente eliminado correctamente");
                    }else
                    {
                        $response = array("status" => false,"message" => "Error al eliminar");
                    }

                    $code = 200;

                }else{
                    $response = array("status" => false,"message" => "Error al consultar " .$method);
                    $code = 400;
                }
                jsonResponse($response, $code);
                die();
            } catch (Exception $ex) {
                echo "Error: ".$ex->getMessage();
            }
        }

       

        




    }


?>