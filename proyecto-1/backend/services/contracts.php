<?php
    include "../db.php";

    function checkCode (array $params) {
        global $conn;
        $query = "SELECT * FROM CONTRACTS WHERE code = $1";
        $result = pg_query_params($conn, $query, $params);
        return pg_num_rows($result);
    }

    function createContract (array $params) {
        global $conn;
        foreach($params as $value) {
            if (!$value) {
                throw new Exception(
                    "Uno o más campos requeridos no fueron enviados");
            }
        }

        if (checkCode(array($params["code"]))) {
            throw new Exception("El contrato ya existe");
        }

        $query = "INSERT INTO CONTRACTS " .
        "(code, client_line, price, activated_at, status) " .
        "VALUES($1, $2, $3, $4, $5)";
        $result = pg_query_params($conn, $query, $params);
        $wasError = pg_result_error($result);
        if ($wasError) {
            throw new Exception($wasError);
        }

        pg_query($conn, "COMMIT");
    }

    function getContractDetail (array $search) {
        global $conn;
        $query = "SELECT code, client_line, price, activated_at, status " . 
        "FROM CONTRACTS " .
        "WHERE code = $1 " .
        "LIMIT 1";
        $result = pg_query_params($conn, $query, $search);
        
        $response = array();
        while($row = pg_fetch_row($result)) {
            $response["code"] = $row[0];
            $response["clientLine"] = $row[1];
            $response["price"] = $row[2];
            $response["activatedAt"] = $row[3];
            $response["status"] = $row[4];
        }

        return $response;
    }

    function getContracts () {
        global $conn;
        $query = "SELECT " .
        "contracts.code, clients.document, contracts.client_line, " .
        "contracts.activated_at, contracts.price, contracts.status " .
        "FROM CONTRACTS JOIN CLIENTS ON CONTRACTS.client_line = CLIENTS.line";
        $result = pg_query($conn, $query);

        $response = array();
        while($row = pg_fetch_row($result)) {
            $temp_array = array();
            $temp_array["code"] = $row[0];
            $temp_array["clientDocument"] = $row[1];
            $temp_array["clientLine"] = $row[2];
            $temp_array["activatedAt"] = $row[3];
            $temp_array["price"] = $row[4];
            $temp_array["status"] = $row[5];
            array_push($response, $temp_array);
        }

        return $response;
    }

    function updateContract (string $code, array $params) {
        global $conn;

        if (!checkCode(array($code))) {
            throw new Exception("El contrato no existe");
        }

        $query = "UPDATE CONTRACTS" . " SET ";
        $keys = array_keys($params);
        $total_keys = count($keys);
        for ($i = 0; $i < $total_keys; ++$i) {
            $key = $keys[$i];
            $value = $params[$key];
            if ($value) {
                $query = $query . $key . " = " . "'" . $value . "'";
            }
            if ($i + 1 != $total_keys) {
                $query = $query . ", ";
            }
        }
        
        $query = $query . " WHERE code = " . $code;
        $result = pg_query($conn, $query);
        pg_query($conn, "COMMIT");
    }

    // function deleteClient () {

    // }
?>