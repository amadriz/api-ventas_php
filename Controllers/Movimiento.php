<?php
    class Movimiento extends Controllers{

        public $views;

        public function __construct()
        {
            parent::__construct();
        }

        
public function registroTipoMovimiento()
{
    header('Content-Type: application/json'); // Ensure the content type is set to JSON
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
    } catch (\Throwable $e) { // Catch any error
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


    }


?>