<?php
    include "../db.php";

    function checkLineDocument (array $params) {
        global $conn;
        $query = "SELECT * FROM CLIENTS " .
        "WHERE line = $1 or document = $2";
        $result = pg_query_params($conn, $query, $params);
        return pg_num_rows($result);
    }

    function createClient (array $params) {
        global $conn;
        foreach($params as $value) {
            if (!$value) {
                throw new Exception(
                    "Uno o más campos requeridos no fueron enviados");
            }
        }

        if (checkLineDocument(array($params["line"], $params["document"]))) {
            throw new Exception("El cliente ya existe");
        }

        $query = "INSERT INTO CLIENTS " .
        "(line, document, document_type, name, city, email) " .
        "VALUES($1, $2, $3, $4, $5, $6)";
        $result = pg_query_params($conn, $query, $params);
        $wasError = pg_result_error($result);
        if ($wasError) {
            throw new Exception($wasError);
        }

        pg_query($conn, "COMMIT");
    }

    function getClientDetail (array $search) {
        global $conn;
        $query = "SELECT line, document, document_type, name, city, email " . 
        "FROM CLIENTS " .
        "WHERE line = $1 or document = $1 " .
        "LIMIT 1";
        $result = pg_query_params($conn, $query, $search);
        
        $response = array();
        while($row = pg_fetch_row($result)) {
            $response["documentType"] = $row[2];
            $response["document"] = $row[1];
            $response["name"] = $row[3];
            $response["line"] = $row[0];
            $response["city"] = $row[4];
            $response["email"] = $row[5];
        }

        return $response;
    }

    function getClients () {
        global $conn;
        $query = "SELECT * FROM CLIENTS";
        $result = pg_query($conn, $query);

        $response = array();
        while($row = pg_fetch_row($result)) {
            $temp_array = array();
            $temp_array["documentType"] = $row[2];
            $temp_array["document"] = $row[1];
            $temp_array["name"] = $row[3];
            $temp_array["line"] = $row[0];
            $temp_array["city"] = $row[4];
            $temp_array["email"] = $row[5];
            array_push($response, $temp_array);
        }

        return $response;
    }

    function updateClient (string $client_line, array $params) {
        global $conn;

        if (!checkLineDocument(array($client_line, null))) {
            throw new Exception("El cliente a actualizar no existe");
        }

        $query = "UPDATE CLIENTS" . " SET ";
        $keys = array_keys($params);
        $total_keys = count($keys);
        for ($i = 0; $i < $total_keys; ++$i) {
            $key = $keys[$i];
            $value = $params[$key];
            if ($value) {
                if ($key == "line" || $key == "document") {
                    $query = $query . $key . " = " . $value;
                } else {
                    $query = $query . $key . " = " . "'" . $value . "'";
                }
            }
            if ($i + 1 != $total_keys) {
                $query = $query . ", ";
            }
        }
        
        $query = $query . " WHERE line = " . $client_line;        
        $result = pg_query($conn, $query);
        pg_query($conn, "COMMIT");
    }

    function deleteClient () {

    }
?>