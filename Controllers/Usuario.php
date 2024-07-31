<?php
    class Usuario extends Controllers{

        public $views;

        public function __construct()
        {
            parent::__construct();
        }

        public function fetchUsuario($idusuario){

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];
                if($method == "GET")
                {
                    if(empty($idusuario) or !is_numeric($idusuario)){
                        $response = array('status' => false , 'msg' => 'Error en los parametros');
                        jsonResponse($response,400);
                        die();
                    }
                    $arrUser = $this->model->getUsuario($idusuario);
                    if(empty($arrUser))
                    {
                        $response = array('status' => false , 'msg' => 'Registro no encontrado');
                    }else{
                        $response = array('status' => true , 'msg' => 'Datos encontrados', 'data' => $arrUser);
                    }
                    $code = 200;                    
                }else{
                    $response = array('status' => false , 'msg' => 'Error en la solicitud '.$method);
                    $code = 400;
                }

                jsonResponse($response,$code);
                die();

            } catch (Exception $e) {
                echo "Error en el proceso: ". $e->getMessage();
            }

            die();


        }

        public function fetchAll()
        {
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];
                if($method == "GET")
                {
                    $arrData = $this->model->getUsuarios();
                    if(empty($arrData))
                    {
                        $response = array('status' => false , 'msg' => 'No hay datos para mostrar', 'data' => '');
                    }else{
                        $response = array('status' => true , 'msg' => 'Datos encontrados ', 'data' =>  $arrData);
                    }
                    $code = 200;
                }else{
                    $response = array('status' => false , 'msg' => 'Error en la solicitud '.$method);
                    $code = 400;
                }
                jsonResponse($response,$code);
                die();

            } catch (Exception $e) {
                echo "Error en el proceso: ". $e->getMessage();
            }
            die();
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
                            "msg" => "Registro de usuario exitoso"
                        ];

                        $code = 200;

                        jsonResponse($response, $code);

                    }else{
                        $response = [
                            "status" => false,
                            "msg" => "El email ya existe"
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


        public function actualizar($idusuario){

            $method = $_SERVER["REQUEST_METHOD"];
            $response = [];

            $arrdata = json_decode(file_get_contents("php://input"), true);

            if($method == "PUT"){
                if($idusuario == ""){
                    $response = [
                        "status" => false,
                        "msg" => "El id del usuario es requerido"
                    ];

                    $code = 400;

                    jsonResponse($response, $code);

                    die();
                }

                if(!isset($arrdata['nombre']) || !testString($arrdata['nombre'])){
                    $response = [
                        "status" => false,
                        "msg" => "El nombre es requerido"
                    ];

                    $code = 400;

                    jsonResponse($response, $code);

                    die();
                }

                if(!isset($arrdata['apellido']) || !testString($arrdata['apellido'])){
                    $response = [
                        "status" => false,
                        "msg" => "El apellido es requerido"
                    ];

                    $code = 400;

                    jsonResponse($response, $code);

                    die();
                }

                if(!isset($arrdata['email']) || !testEmail($arrdata['email'])){
                    $response = [
                        "status" => false,
                        "msg" => "El email es requerido"
                    ];

                    $code = 400;

                    jsonResponse($response, $code);

                    die();
                }

                if(!isset($arrdata['password'])){
                    $response = [
                        "status" => false,
                        "msg" => "El password es requerido"
                    ];

                    $code = 400;

                    jsonResponse($response, $code);

                    die();
                }

                $strNombre = ucwords(strClean($arrdata['nombre']));
                $strApellido = ucwords(strClean($arrdata['apellido']));
                $strEmail = strtolower(strClean($arrdata['email']));
                $strPassword = hash("SHA256", $arrdata['password']);

                $buscarUsuario = $this->model->getUsuario($idusuario);
                

                if(empty($buscarUsuario)){
                    $response = [
                        "status" => false,
                        "msg" => "El usuario no existe"
                    ];

                    $code = 400;

                    jsonResponse($response, $code);

                    die();
                }

                $request = $this->model->updateUsuario($idusuario,
                                                       $strNombre, 
                                                       $strApellido, 
                                                       $strEmail, 
                                                       $strPassword);

                if($request){
                    $response = [
                        "status" => true,
                        "msg" => "Actualización de usuario exitoso"
                    ];

                    $code = 200;

                    jsonResponse($response, $code);

                }else{
                    $response = [
                        "status" => false,
                        "msg" => "Error en la actualización"
                    ];

                    $code = 400;

                    jsonResponse($response, $code);

                }
            
            }else{
                $response = [
                    "status" => false,
                    "msg" => "Error en el método, debe de ser PUT"
                ];

                $code = 400;

                jsonResponse($response, $code);

            }

        }

        public function eliminar($idusuario)
        {
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];
                if($method == "DELETE")
                {
                    if(empty($idusuario) or !is_numeric($idusuario)){
                        $response = array('status' => false , 'msg' => 'Error en los parametros');
                        jsonResponse($response,400);
                        die();
                    }

                    $buscar_usuario = $this->model->getUsuario($idusuario);
                    if(empty($buscar_usuario))
                    {
                        $response = array('status' => false , 'msg' => 'El usuario no existe o ya fue eliminado');
                        jsonResponse($response,400);
                        die();
                    }
                    $request = $this->model->deleteUsuario($idusuario);
                    if($request)
                    {
                        $response = array('status' => true , 'msg' => 'Registro eliminado');
                    }else{
                        $response = array('status' => false , 'msg' => 'No es posible eliminar el registro');
                    }
                    $code = 200; 
                }else{
                    $response = array('status' => false , 'msg' => 'Error en la solicitud '.$method);
                    $code = 400;
                }
                jsonResponse($response,$code);
                die();

            } catch (Exception $e) {
                echo "Error en el proceso: ". $e->getMessage();
            }
            die();

        }

        public function login(){

            try{

                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];

                

                if($method == "POST")
                {

                    $_POST = json_decode(file_get_contents('php://input'), true);
                    
                    if(empty($_POST['email']) || empty($_POST['password'])){
                        $response = [
                            "status" => false,
                            "msg" => "El email y el password son requeridos"
                        ];

                        $code = 200;

                        jsonResponse($response, $code);

                        die();
                    }

                    $strEmail = strClean($_POST['email']);
                    $strPassword = hash("SHA256", $_POST['password']);
                    $requestUser = $this->model->loginUser($strEmail, $strPassword);




                    dep($requestUser);
                    exit;


                }else{
                    
                    $response = [
                        "status" => false,
                        "msg" => "Error en el método, debe de ser POST"
                    ];

                    $code = 400;

                    jsonResponse($response, $code);

                
                }


            }catch(Exception $e){
                echo "Error en el proceso login: ". $e->getMessage();
            }
            die();

        }
            
        } // Cierre de la clase


    


?>