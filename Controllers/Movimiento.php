<?php
    class Movimiento extends Controllers{

        public $views;

        public function __construct()
        {
            parent::__construct();
        }

        
public function registroTipoMovimiento()
{
    try {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "POST") {
            $_POST = json_decode(file_get_contents('php://input'), true);

            if (empty($_POST['movimiento'])) {
                jsonResponse(["status" => false, "msg" => "El movimiento es requerido"], 200);
                return; // Use return instead of die()
            }

            if (empty($_POST['tipo_movimiento']) || ($_POST['tipo_movimiento'] != 1 && $_POST['tipo_movimiento'] != 2)) {
                jsonResponse(["status" => false, "msg" => "El tipo de movimiento es requerido y debe ser 1 o 2"], 200);
                return;
            }

            if (empty($_POST['descripcion'])) {
                jsonResponse(["status" => false, "msg" => "La descripción es requerida"], 200);
                return;
            }

            // Assuming strclean is a custom function that cleans strings
            $strMovimiento = ucwords(strclean($_POST['movimiento']));
            $intTipoMovimiento = $_POST['tipo_movimiento'];
            $strDescripcion = strclean($_POST['descripcion']);

            $request_movimiento = $this->model->insertTipoMovimiento($strMovimiento, $intTipoMovimiento, $strDescripcion);

            if ($request_movimiento > 0) {
                $arrMovimiento = [
                    'idtipomovimiento' => $request_movimiento,
                    'movimiento' => $strMovimiento,
                    'tipo_movimiento' => $intTipoMovimiento,
                    'descripcion' => $strDescripcion,
                ];

                jsonResponse(["status" => true, "msg" => "Movimiento registrado correctamente", "data" => $arrMovimiento], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No es posible registrar el movimiento"], 200);
            }
        } else {
            jsonResponse(["status" => false, "msg" => "Error en el método de envío"], 400);
        }
    } catch (Exception $e) { // Catch any error
        echo "Error en el proceso " . $e->getMessage();
    }
}

// Ensure jsonResponse is defined like this or adjust accordingly
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
}

public function fetchTiposMovimiento()
{
    try {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "GET") {
            $arrData = $this->model->selectTiposMovimiento();

            if (!empty($arrData)) {

                //echo json_encode($arrData);

                $response = array(
                    "status" => true,
                    "message" => "Lista de Movimientos",
                    "data" => $arrData // Changed from $arrFrecuencias to $arrData
                );
                $code = 200;
            } else {
                $response = [
                    "status" => false,
                    "msg" => "No hay movimientos registrados"
                ];
                $code = 200;
                jsonResponse($response, $code); // Adjusted the order of parameters to match the function definition
                die();
            }
        } else {
            $response = [
                'status' => false,
                'msg' => 'Error en el método de envío debe de ser GET',
            ];
            $code = 400; // Changed to 400 to reflect client error on method not allowed
            jsonResponse($response, $code); // Added this line to ensure a response is sent in this case
        }
    } catch (Exception $e) {
        // Handle exception
        $response = [
            'status' => false,
            'msg' => 'Error en el proceso: ' . $e->getMessage(),
        ];
    }
    $code = 500; // Internal Server Error
    jsonResponse($response, $code);
}


// METODOS PARA MOVIMIENTOS
public function registroMovimiento()
{
    try{
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "POST") {
            $_POST = json_decode(file_get_contents('php://input'), true);

            if (empty($_POST['cuentaid']) || !is_numeric($_POST['cuentaid'])) {
                jsonResponse(["status" => false, "msg" => "Error en el id de la cuenta"], 200);
                return; // Use return instead of die()
            }

            if (empty($_POST['idtipomovimiento']) || !is_numeric($_POST['idtipomovimiento'])) {
                jsonResponse(["status" => false, "msg" => "El tipo de movimiento es requerido"], 200);
                return;
            }

            if(empty($_POST['movimiento']) || ($_POST['movimiento'] != 1 && $_POST['movimiento'] != 2)){
                jsonResponse(["status" => false, "msg" => "Error en el movimiento"], 200);
                return;
            }

            if (empty($_POST['monto']) || !is_numeric($_POST['monto'])) {
                jsonResponse(["status" => false, "msg" => "El monto es requerido"], 200);
                return;
            }

            if (empty($_POST['descripcion'])) {
                jsonResponse(["status" => false, "msg" => "La descripción es requerida"], 200);
                return;
            }

            $intCuentaId = $_POST['cuentaid'];
            $intTipoMovimiento = $_POST['idtipomovimiento'];
            $movimiento = $_POST['movimiento'];
            $intMonto = $_POST['monto'];
            $strDescripcion = strclean($_POST['descripcion']);

            $request_movimiento = $this->model->insertMovimiento($intCuentaId, $intTipoMovimiento, $movimiento, $intMonto, $strDescripcion);

            if ($request_movimiento > 0) {
                $arrMovimiento = [
                    'idmovimiento' => $request_movimiento
                    
                ];

                jsonResponse(["status" => true, "msg" => "Movimiento registrado correctamente", "data" => $arrMovimiento], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No es posible registrar el movimiento"], 200);
            }
            

        }else{
            jsonResponse(["status" => false, "msg" => "Error en la solicitud " . $method . " debe utilizar POST"], 200);
        }
    }catch(Exception $e){
        echo "Error en el proceso : " . $e->getMessage();
    }
}

//Fetch todos los movimientos
public function fetchMovimientos(){
    try{
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "GET") {
            $arrData = $this->model->selectMovimientos();

            if (!empty($arrData)) {

                //echo json_encode($arrData);

                $response = array(
                    "status" => true,
                    "message" => "Lista de Movimientos",
                    "data" => $arrData // Changed from $arrFrecuencias to $arrData
                );
                $code = 200;
            } else {
                $response = [
                    "status" => false,
                    "msg" => "No hay movimientos registrados"
                ];
                $code = 200;
                jsonResponse($response, $code); // Adjusted the order of parameters to match the function definition
                die();
            }
        } else {
            $response = [
                'status' => false,
                'msg' => 'Error en el método de envío debe de ser GET',
            ];
            $code = 400; // Changed to 400 to reflect client error on method not allowed
            jsonResponse($response, $code); // Added this line to ensure a response is sent in this case
        }
    } catch (Exception $e) {
        // Handle exception
        $response = [
            'status' => false,
            'msg' => 'Error en el proceso: ' . $e->getMessage(),
        ];
    }
    $code = 500; // Internal Server Error
    jsonResponse($response, $code);
}

//Fetch movimiento por id
public function fetchMovimiento(int $id){
    try{
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "GET") {
            if (empty($id) || !is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "Error en el id del movimiento"], 200);
                return; // Use return instead of die()
            }

            $arrData = $this->model->selectMovimiento($id);

            if (!empty($arrData)) {

                //echo json_encode($arrData);

                $response = array(
                    "status" => true,
                    "message" => "Movimiento",
                    "data" => $arrData // Changed from $arrFrecuencias to $arrData
                );
                $code = 200;
            } else {
                $response = [
                    "status" => false,
                    "msg" => "No hay movimientos registrados"
                ];
                $code = 200;
                jsonResponse($response, $code); // Adjusted the order of parameters to match the function definition
                die();
            }
        } else {
            $response = [
                'status' => false,
                'msg' => 'Error en el método de envío debe de ser GET',
            ];
            $code = 400; // Changed to 400 to reflect client error on method not allowed
            jsonResponse($response, $code); // Added this line to ensure a response is sent in this case
        }
    } catch (Exception $e) {
        // Handle exception
        $response = [
            'status' => false,
            'msg' => 'Error en el proceso: ' . $e->getMessage(),
        ];
    }

    $code = 500; // Internal Server Error
    jsonResponse($response, $code);

}

//Delete movimiento
public function eliminarMovimiento(int $idmovimiento){
    try{
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "DELETE") {
            if (empty($idmovimiento) || !is_numeric($idmovimiento)) {
                jsonResponse(["status" => false, "msg" => "Error en el id del movimiento"], 200);
                return; // Use return instead of die()
            }

            $request_movimiento = $this->model->selectMovimiento($idmovimiento);

            // dep($request_movimiento);

            // exit;

            if(empty($request_movimiento)){
                jsonResponse(["status" => false, "msg" => "El movimiento no existe"], 200);
                return;
            }else{
                $request_movimiento = $this->model->deleteMovimiento($idmovimiento);
                
                if($request_movimiento){
                    jsonResponse(["status" => true, "msg" => "Movimiento eliminado correctamente", 'data' => $request_movimiento[0]], 200);
                }else{
                    jsonResponse(["status" => false, "msg" => "No es posible eliminar el movimiento"], 200);
                }
            }
        } else {
            $response = [
                'status' => false,
                'msg' => 'Error en el método de envío debe de ser POST',
            ];
            $code = 400; // Changed to 400 to reflect client error on method not allowed
            jsonResponse($response, $code); // Added this line to ensure a response is sent in this case
        }
    } catch (Exception $e) {
        // Handle exception
        $response = [
            'status' => false,
            'msg' => 'Error en el proceso: ' . $e->getMessage(),
        ];
    }

    $code = 500; // Internal Server Error
    jsonResponse($response, $code);
}


}// End of class
?>