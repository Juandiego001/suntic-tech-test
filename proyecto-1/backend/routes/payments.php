<?php
    include "../db.php";
    include "../services/payments.php";
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
                echo json_encode(getPaymentDetail(array ($query_params)));
            } else {
                echo json_encode(getPayments());
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array ("message" => $e->getMessage()));
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $params = array ("contractCode" => intval($_POST["contractCode"]),
            "amount" => intval($_POST["amount"]),
            "createdAt" => $_POST["createdAt"]);

            createPayment($params);
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
                    "El id y el código de contrato deben especificarse en " . 
                    "forma de query");
            }

            $query_params = explode('&', $query_params);

            if (!count($query_params) > 1) {
                throw new Exception(
                    "El id y el código de contrato deben especificarse en " . 
                    "forma de query");
            }

            $id = intval(explode('=', $query_params[0])[1]);
            $contract_code = intval(explode('=', $query_params[1])[1]);

            $params = array ("contract_code" => intval($_PATCH["contractCode"]),
            "amount" => intval($_PATCH["amount"]),
            "created_at" => $_PATCH["createdAt"]);

            updatePayment($id, $contract_code, $params);
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