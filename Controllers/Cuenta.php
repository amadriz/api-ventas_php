<?php
    class Cuenta extends Controllers{

        public $views;

        public function __construct()
        {
            parent::__construct();
        }

        public function cuenta($idcuenta)
        {
            $method = $_SERVER['REQUEST_METHOD'];
                $response = [];

                if($method == 'GET'){

                }else{
                    
                    $response = ['status' => false, 'message' => 'Method not allowed must use POST'];
                    $code = 400;
                }
                jsonResponse($response, $code);
                die();

            
        }

        public function cuentas()
        {
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];

                if($method == 'GET'){
                    $arrData = $this->model->selectCuentas();
                    
                    if(empty($arrData)){
                        $response = ['status' => false, 'message' => 'No hay registros de cuentas'];
                        $code = 200;

                    }else
                    {
                        $response = array(
                            "status" => true,
                            "message" => "Cuentas encontradas",
                            "data" => $arrData
                        );
                        $code = 200;
                    }    

                }else{
                    
                    $response = ['status' => false, 'message' =>'Debe de usar método GET'];
                    $code = 400;
                }
                jsonResponse($response, $code);
                die();
            } catch (Exception $ex) {
                echo "Error en el proceso de registro " . $e->getMessage();
            }

        }

        //Select cuenta by id
        public function cuentaid($idcuenta)
        {
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];

                if($method == 'GET'){

                    
                    if(empty($idcuenta) || !is_numeric($idcuenta)){
                        
                        $response = array(
                            "status" => false,
                            "message" => "El dato idcuenta es requerido"
                        );
                        
                        die();
                    }
                    
                    $arrCuenta = $this->model->getCuenta($idcuenta);


                    dep($arrCuenta);

                    
                    
                    
                    $code = 200;

                }else{
                    
                    $response = ['status' => false, 'message' => 'Method not allowed must use POST'];
                    $code = 400;
                }

                jsonResponse($response, $code);
                die();



            } catch (Exception $ex) {
                //throw $th;
                echo "Error en el proceso de registro " . $e->getMessage();
            }
        }

        public function registro()
        {
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];

                if($method == 'POST'){

                    $_POST = json_decode(file_get_contents('php://input'), true);

                    //Validar datos enviados para el registro
                   if(empty($_POST['idcliente']) || !is_numeric($_POST['idcliente']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "El dato idcliente es requerido"
                       );
                       jsonResponse($response, 200);
                       die();
                   }
                   if(empty($_POST['idproducto']) || !is_numeric($_POST['idproducto']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "El dato idproducto es requerido"
                       );
                       jsonResponse($response, 200);
                       die();
                   }
                   if(empty($_POST['idfrecuencia']) || !is_numeric($_POST['idfrecuencia']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "El dato idfrecuencia es requerido"
                       );
                       jsonResponse($response, 200);
                       die();
                   }
                   if(empty($_POST['monto']) || !is_numeric($_POST['monto']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "El dato monto es requerido"
                       );
                       jsonResponse($response, 200);
                       die();
                   }
                   if(empty($_POST['cuotas']) || !is_numeric($_POST['cuotas']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "El dato cuotas es requerido"
                       );
                       jsonResponse($response, 200);
                       die();
                   }
                   if(empty($_POST['monto_cuota']) || !is_numeric($_POST['monto_cuota']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "El dato monto_cuota es requerido"
                       );
                       jsonResponse($response, 200);
                       die();
                   }
                   if(empty($_POST['cargo']) || !is_numeric($_POST['cargo']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "El dato cargo es requerido"
                       );
                       jsonResponse($response, 200);
                       die();
                   }
                   if(empty($_POST['saldo']) || !is_numeric($_POST['saldo']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "El dato saldo es requerido"
                       );
                       jsonResponse($response, 200);
                       die();
                   }

                    $intClienteId = strclean($_POST['idcliente']);
                    $intProductId = strclean($_POST['idproducto']);
                    $intFrecuenciaId = strclean($_POST['idfrecuencia']);
                    $intMonto = strclean($_POST['monto']);
                    $intCuotas = strclean($_POST['cuotas']);
                    $intMontoCuota = strclean($_POST['monto_cuota']);
                    $intCargo = strclean($_POST['cargo']);
                    $intSaldo = strclean($_POST['saldo']);

                    $request = $this->model->insertCuenta($intClienteId, 
                                                          $intProductId, 
                                                          $intFrecuenciaId, 
                                                          $intMonto,
                                                          $intCuotas, 
                                                          $intMontoCuota, 
                                                          $intCargo, 
                                                          $intSaldo);

                    //Check what is the value of the variables
                    dep($request);                                     

                    if($request > 0){
                        //array showing the data

                        $arrCuenta = array('idContrato' => $request);
                                        
                        $response = ['status' => true, 'message' => 'Registro de cuenta', 'data' => $arrCuenta];
                        $code = 200;
                    }else{
                        $response = ['status' => false, 'message' => 'No es posible realizar el registro de cuenta'];
                        $code = 200;
                    }

                }else{
                    
                    $response = ['status' => false, 'message' => 'Method not allowed must use POST'];
                    $code = 400;
                }
                jsonResponse($response, $code);
                die();

                
            } catch (Exception $ex) {
                echo "Error en el proceso de registro " . $e->getMessage();
            }

            die();


        }


    }


?>