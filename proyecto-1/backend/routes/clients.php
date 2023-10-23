<?php
    include "../db.php";
    include "../services/clients.php";
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
                echo json_encode(getClientDetail(array ($query_params)));
            } else {
                echo json_encode(getClients());
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array ("message" => $e->getMessage()));
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $params = array ("line" => intval($_POST["line"]),
            "document" => intval($_POST["document"]),
            "document_type" => $_POST["documentType"],
            "name" => $_POST["name"],
            "city" => $_POST["city"],
            "email" => $_POST["email"]);

            createClient($params);
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
                    'El cliente debe especificarse en forma de query');
            }

            $client_line = intval(explode('=', $query_params)[1]);
            $params = array ("line" => intval($_PATCH["line"]),
            "document" => intval($_PATCH["document"]),
            "document_type" => $_PATCH["documentType"],
            "name" => $_PATCH["name"],
            "city" => $_PATCH["city"],
            "email" => $_PATCH["email"]);

            updateClient($client_line, $params);
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