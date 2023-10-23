<?php
    include "../db.php";
    include "../services/contracts.php";
    header("Access-Control-Allow-Methods: *");
    header("Allow: *");
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json; charset=utf-8');
    // error_reporting(0);

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        try {
            $query_params = $_SERVER["QUERY_STRING"];
            
            if ($query_params) {
                $query_params = intval(explode('=', $query_params)[1]);
                echo json_encode(getContractDetail(array ($query_params)));
            } else {
                echo json_encode(getContracts());
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array ("message" => $e->getMessage()));
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $params = array ("code" => intval($_POST["code"]),
            "clientLine" => intval($_POST["clientLine"]),
            "price" => intval($_POST["price"]),
            "activatedAt" => $_POST["activatedAt"],
            "status" => $_POST["status"]);

            createContract($params);
            http_response_code(200);
            echo json_encode(array("message" => "Guardado exitosamente"));
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array("message" => $e->getMessage()));
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
        try {
            parse_str(file_get_contents('php://input'), $_PATCH);
            $query_params = $_SERVER["QUERY_STRING"];

            if (!$query_params) {
                throw new Exception(
                    'El contrato debe especificarse en forma de query');
            }

            $code = intval(explode('=', $query_params)[1]);
            $params = array ("code" => intval($_PATCH["code"]),
            "client_line" => intval($_PATCH["clientLine"]),
            "price" => intval($_PATCH["price"]),
            "activated_at" => $_PATCH["activatedAt"],
            "status" => $_PATCH["status"]);

            updateContract($code, $params);
            http_response_code(200);
            echo json_encode(array("message" => "Guardado exitosamente"));
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array("message" => $e->getMessage()));
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
        echo "Está haciendo una petición DELETE";
    }
?>