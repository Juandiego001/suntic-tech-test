<?php
    try {
        $uri = getenv("POSTGRES_URI");
        $conn = pg_connect($uri);
    } catch (Exception $e) {
        echo "No se pudo conectar a la BD";
    }
?>