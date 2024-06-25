<?php
    class Frecuencia extends Controllers{

        public $views;

        public function __construct()
        {
            parent::__construct();
        }

        public function frecuencias()
        {

            try {
                $method = $_SERVER["REQUEST_METHOD"];
                $response = [];

                if($method == "GET")
                {
                    $arrFrecuencias = $this->model->getFrecuencias();

                    if(empty($arrFrecuencias))
                    {
                        $response = [
                            "status" => false,
                            "msg" => "No hay frecuencias registradas"
                        ];

                        $code = 200;
                        jsonResponse($code, $response);
                        die();
                    }else{
                        $response = array(
                            "status" => true,
                            "message" => "Lista de frecuencias",
                            "data" => $arrFrecuencias
                        );
                        $code = 200;
                    }
                }else{
                    $response = [
                        "status" => false,
                        "msg" => "Metodo no permitido"
                    ];
                    $code = 400;
                }

                jsonResponse($response, $code);
                die();
            } catch (Exception $e) {
                echo "Error en el modelo FrecuenciaModel";
            }
        }

        public function frecuencia($idfrecuencia)
        {
            try {
                $method = $_SERVER["REQUEST_METHOD"];
                $response = [];

                if(empty($idfrecuencia))
                    {
                        $response = [
                            "status" => false,
                            "msg" => "Frecuencia no encontrada"
                        ];
                        $code = 200;
                        jsonResponse($response, $code);
                        die();
                    }

                if($method == "GET")
                {
                    //validar si existe la frecuencia
                    
                        $arrFrecuencia = $this->model->getFrecuencia($idfrecuencia);
                        
                        if(empty($arrFrecuencia))
                        {
                            $response = [
                                "status" => false,
                                "msg" => "Frecuencia no encontrada"
                            ];
                            $code = 200;
                            jsonResponse($response, $code);
                            die();
                        }else{
                            $response = [
                                "status" => true,
                                "msg" => "Frecuencia encontrada",
                                "data" => $arrFrecuencia
                            ];
                            $code = 200;
                        }
                }
                else{
                    $response = [
                        "status" => false,
                        "msg" => "Metodo no permitido"
                    ];
                    $code = 400;
                }
                jsonResponse($response, $code);
                die();
            
            }catch (Exception $ex) {
                echo "Error en el controlador Frecuencia ".$ex->getMessage();
            }
        }


        public function registro()
        {
            //validate method post 
            try {
                $method = $_SERVER["REQUEST_METHOD"];
                $response = [];
    
                if($method == "POST")
                {
                   $_POST = json_decode(file_get_contents('php://input'), true);
                     if(empty($_POST['frecuencia']))
                     {
                          $response = [
                            "status" => 0,
                            "msg" => "Datos incorrectos"
                          ];
                        }else{
                            $strFrecuencia = $_POST['frecuencia'];
                            $frecuencia = $this->model->insertFrecuencia($strFrecuencia);
                            if($frecuencia)
                            {
                                $response = [
                                    "status" => 1,
                                    "msg" => "Frecuencia registrada correctamente"
                                ];
                            }else{
                                $response = [
                                    "status" => 0,
                                    "msg" => "Error al registrar la frecuencia"
                                ];
                            }
                        }
                        echo json_encode($response);

                }
            } catch (Exception $e) {
                echo "Error en el controlador Frecuencia";
            }
                
               
        }

        public function actualizar($idfrecuencia)
        {
            try
            {
                $method = $_SERVER["REQUEST_METHOD"];
                $response = [];

                if($method == "PUT")
                {
                    $arrData = json_decode(file_get_contents("php://input"), true);

                    if(empty($idfrecuencia))
                    {
                        $response = [
                            "status" => false,
                            "msg" => "Frecuencia no encontrada"
                        ];
                        $code = 400;
                        jsonResponse($response, $code);
                        die();
                    }

                    //validations data
                    if(empty($arrData['frecuencia']))
                    {
                        $response = [
                            "status" => false,
                            "msg" => "Datos incorrectos"
                        ];
                        $code = 400;
                        jsonResponse($response, $code);
                        die();
                    }

                    $strFrecuencia = $arrData['frecuencia'];

                    $buscarFrecuencia = $this->model->getFrecuencia($idfrecuencia);

                    if(empty($buscarFrecuencia))
                    {
                        $response = [
                            "status" => false,
                            "msg" => "Frecuencia no encontrada"
                        ];
                        $code = 400;
                        jsonResponse($response, $code);
                        die();
                    }

                    $request = $this->model->updateFrecuencia($idfrecuencia, $strFrecuencia);

                    if($request)
                    {
                        $arrFrecuencia = array("idfrecuencia" => $idfrecuencia, 
                            "frecuencia" => $strFrecuencia
                        );

                        $response = array("status" => true,"message" => "Frecuencia actualizada correctamente", "data" => $arrFrecuencia);

                        $code = 200;
                    }
                    else
                    {
                        $response = array("status" => false,"message" => "Error al actualizar la frecuencia ".$method);

                        $code = 200;
                    }
                    
                }
                else
                {
                    $response = array("status" => false,"message" => "Error al actualizar el producto ".$method);

                    $code = 200;
                }
                
                jsonResponse($response, $code);
                die();

            }
            catch (Exception $e)
            {
                echo "Error en el controlador Frecuencia";
            }


            
        }

        public function deleteFrecuencia()
        {
            
        }

        

        


    }


?>