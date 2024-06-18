<?php
    class Producto extends Controllers{

        public function __construct()
        {
            parent::__construct();
        }

        public function productos()
        {
           try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];

            if($method == "GET")
            {
                //Extraer todos los productos
                $arrProducts = $this->model->getProductos();

                //echo json_encode($arrProducts);

                if(empty($arrProducts))
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
                            "data" => $arrProducts
                        );
                        $code = 200;
                    }

                
            }
            else
            {
                $response = array("status" => 400, "message" => "Error con el metodo");
                $code = 400;
            }
            
            jsonResponse($response, $code);
            die();


           } catch (Exception $ex) {
            

            
            echo "Error: ".$ex->getMessage();

           }
        }

        public function producto($idproducto)
        {
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];

                //if id is empty
                if(empty($idproducto))
                {
                    $response = array(
                        "status" => false,
                        "message" => "No hay productos registrados"
                    );
                    $code = 400;
                    jsonResponse($response, $code);
                    die();
                }

                //if method
                if($method == "GET")
                {
                    //Extraer un producto
                    $arrProduct = $this->model->getProducto($idproducto);

                    if(empty($arrProduct))
                    {
                        $response = array(
                            "status" => false,
                            "message" => "No hay productos registrados"
                        );
                        $code = 400;
                        jsonResponse($response, $code);
                        die();
                    }else
                    {
                        $response = array(
                            "status" => true,
                            "message" => "Producto encontrado",
                            "data" => $arrProduct
                        );
                        $code = 200;
                    }
                }
                else
                {
                    $response = array("status" => 400, "message" => "Error con el metodo");
                    $code = 400;
                }

                jsonResponse($response, $code);
                die();

            } catch (Exception $ex) {
                echo "Error: ".$ex->getMessage();
            }
        } //end function producto id

        public function registro()
        {
            try {
                $method = $_SERVER['REQUEST_METHOD'];
                $response = [];


                //Validar si es un metodo post
                if($method == "POST")
                {
                    
                   $_POST = json_decode(file_get_contents('php://input'), true);

                  
                   //Validar codigo
                   if(empty($_POST['codigo']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "Error en el código"
                       );
                       jsonResponse($response, 400);
                       die();
                   }
                   //Validar nombre producto
                   if(empty($_POST['nombre']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "Error en el Nombre del producto"
                       );
                       jsonResponse($response, 400);
                       die();     
                   }
                   //validar descripcion del producto
                   if(empty($_POST['descripcion']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "Error en el descripcion"
                       );
                       jsonResponse($response, 400);
                       die();
                   }
                   //validar precio del producto
                   if(empty($_POST['precio']) or !is_numeric($_POST['precio']))
                   {
                       $response = array(
                       "status" => false,
                       "message" => "Error en el precio"
                       );
                       jsonResponse($response, 400);
                       die();
                   }

                   $strCodigo = strClean($_POST['codigo']);
                   $strNombre = ucwords(strClean($_POST['nombre']));
                   $strDescripcion = strClean($_POST['descripcion']);
                   $strPrecio = $_POST['precio'];

                   $request = $this->model->setProducto($strCodigo, $strNombre, $strDescripcion, $strPrecio);

                   if($request > 0)
                   {
                    $arrProduct = array('idProducto' => $request,
                        "codigo" => $strCodigo,
                        "nombre" => $strNombre,
                        "descripcion" => $strDescripcion,
                        "precio" => $strPrecio
                    );

                    $response = array('status' => true, 'message' => "Producto registrado correctamente", 'data' => $arrProduct);

                  }else{
                    

                    $response = array(
                    "status" => false,
                    "message" => "Error al registrar el producto, el código ya existe",
                    );
                  } //end if method post

                    $code = 200;



                        
                }else{
                    $response = array(
                    "status" => 400,
                    "message" => "Error al registrar el producto"
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