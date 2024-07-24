<?php
    class Usuario extends Controllers{

        public $views;

        public function __construct()
        {
            parent::__construct();
        }

        public function usuario()
        {
            
        }

        public function registro(){
            
            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];

            if($method == "POST"){

                $_POST = json_decode(file_get_contents('php://input'), true);
 
                    //Validar nombre
                    if(empty($_POST['nombre']) || !testString($_POST['nombre'])){
                             
                      
                             $response = array(
                             "status" => false,
                             "message" => "El nombre es requerido"
                             );
                             jsonResponse($response, 200);
                             die();
     
                    }

                      //Validar apellido
                    if(empty($_POST['apellido']) || !testString($_POST['apellido'])){
                             
                      
                        $response = array(
                        "status" => false,
                        "message" => "El apellido es requerido"
                        );
                        jsonResponse($response, 200);
                        die();

                    }

                    //Validar email
                    if(empty($_POST['email']) || !testEmail($_POST['email'])){
                             
                      
                        $response = array(
                        "status" => false,
                        "message" => "El email es requerido"
                        );
                        jsonResponse($response, 200);
                        die();

                    }

                    //Validar password
                    if(empty($_POST['password'])){
                        $response = array(
                        "status" => false,
                        "message" => "El password es requerido"
                        );
                        jsonResponse($response, 200);
                        die();
                   }

                    $strNombre = ucwords(strClean($_POST['nombre']));
                    $strApellido = ucwords(strClean($_POST['apellido']));
                    $strEmail = strtolower(strClean($_POST['email']));
                    $strPassword = hash("SHA256", $_POST['password']);

                    $request = $this->model->insertUsuario($strNombre, 
                                                           $strApellido, 
                                                           $strEmail, 
                                                           $strPassword);

                    if($request > 0){
                        $response = [
                            "status" => true,
                            "msg" => "Registro exitoso"
                        ];

                        $code = 200;

                        jsonResponse($response, $code);

                    }else{
                        $response = [
                            "status" => false,
                            "msg" => "Error al registrar"
                        ];

                        $code = 400;

                        jsonResponse($response, $code);

                    }
                


            }else{
                $response = [
                    "status" => false,
                    "msg" => "Error en el método, debe de ser POSTS"
                ];

                $code = 400;

                jsonResponse($response, $code);

            }
        }//Cierre m◙todo registro
            
        } // Cierre de la clase


    


?>