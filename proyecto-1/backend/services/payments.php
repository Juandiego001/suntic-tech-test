<?php
    include "../db.php";    
    include "contracts.php";

    function checkId (array $params) {
        global $conn;
        $query = "SELECT * FROM PAYMENTS WHERE id = $1";
        $result = pg_query_params($conn, $query, $params);
        return pg_num_rows($result);
    }

    function getBalance(array $params) {
        global $conn;
        $query = "SELECT (contracts.price - SUM(payments.amount)) as balance " .
        "FROM CONTRACTS JOIN PAYMENTS " .
        "ON CONTRACTS.code = PAYMENTS.contract_code " . 
        "WHERE payments.contract_code = $1 " . 
        "GROUP BY contracts.price";
        $result = pg_query_params($conn, $query, $params);
        $balance = -1;
        while($row = pg_fetch_row($result)) {
            $balance = $row[0];
        }

        echo "BALANCE: " . $balance;
        return $balance;
    }

    function getAmount (array $params) {
        global $conn;
        $query = "SELECT amount FROM PAYMENTS" .
        "WHERE id = $1";
        $result = pg_query_params($conn, $query, $params);
        $amount = -1;
        while($row = pg_fetch_row($result)) {
            $amount = $row[0];
        }

        echo "AMOUNT PAYMENT: " . $amount;
        return $amount;

    }

    function createPayment (array $params) {
        global $conn;
        foreach($params as $value) {
            if (!$value) {
                throw new Exception(
                    "Uno o más campos requeridos no fueron enviados");
            }
        }

        $balance = getBalance(array ($params["contractCode"]));
        if ($balance != -1 && $params["amount"] > $balance) {
            throw new Exception("El pago no puede generar saldo a favor");
        }

        $query = "INSERT INTO PAYMENTS " .
        "(contract_code, amount, created_at) " .
        "VALUES($1, $2, $3)";
        $result = pg_query_params($conn, $query, $params);
        $wasError = pg_result_error($result);
        if ($wasError) {
            throw new Exception($wasError);
        }

        pg_query($conn, "COMMIT");
    }

    function getPaymentDetail (array $search) {
        global $conn;
        $query = "SELECT id, contract_code, amount, created_at " . 
        "FROM PAYMENTS " .
        "WHERE id = $1 " .
        "LIMIT 1";
        $result = pg_query_params($conn, $query, $search);
        
        $response = array();
        while($row = pg_fetch_row($result)) {
            $response["id"] = $row[0];
            $response["contractCode"] = $row[1];
            $response["amount"] = $row[2];
            $response["createdAt"] = $row[3];
        }

        return $response;
    }

    function getPayments () {
        global $conn;
        $query = "SELECT " .
        "payments.id, payments.contract_code, payments.amount, " .
        "payments.created_at, (contracts.price - SUM(payments.amount)) as balance " .
        "FROM PAYMENTS " . 
        "JOIN CONTRACTS ON PAYMENTS.contract_code = CONTRACTS.code " . 
        "GROUP BY payments.id, contracts.price";
        $result = pg_query($conn, $query);

        $response = array();
        while($row = pg_fetch_row($result)) {
            $temp_array = array();
            $temp_array["id"] = $row[0];
            $temp_array["contractCode"] = $row[1];
            $temp_array["amount"] = $row[2];
            $temp_array["createdAt"] = $row[3];
            $temp_array["balance"] = $row[4];
            array_push($response, $temp_array);
        }

        return $response;
    }

    function updatePayment (string $id, string $contract_code, array $params) {
        global $conn;

        if (!checkId(array($id))) {
            throw new Exception("El pago no existe");
        }

        if ($params["amount"]) {
            echo "AMOUNT: " . $params["amount"];
            $balance = getBalance(array ($contract_code));
            if ($balance != -1 && $params["amount"] > $balance) {
                throw new Exception("El pago no puede generar saldo a favor");
            }
        }

        if ($params["contract_code"]) {
            if (!checkCode(array ($params["contract_code"]))) {
                throw new Exception("El contrato no existe");
            }

            $balance = getBalance(array($params["contract_code"]));
            if ($balance != -1) {
                if (!$params["amount"]) {
                    $amount = getAmount(array($id));
                    echo "AMOUNT2: " . $amount;
                    if ($amount > $balance) { 
                        throw new Exception(
                            "El pago no puede generar saldo a favor");
                    }
                } elseif ($params["amount"] > $balance) {
                    throw new Exception(
                        "El pago no puede generar saldo a favor");
                }
            }
        }

        $query = "UPDATE PAYMENTS " . " SET ";
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
        
        $query = $query . " WHERE id = " . $id;
        $result = pg_query($conn, $query);
        pg_query($conn, "COMMIT");
    }

    // function deleteClient () {

    // }
?>