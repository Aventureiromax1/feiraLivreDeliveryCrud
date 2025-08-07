<?php 
$dbname = 'feiraLivreDeliveryData';
//$dbname = 'feiraLivreData';
 function conectar($param = '') {
        if ($param == '') {
            $param = 'pgsql:host=localhost; port=5432; dbname=feiraLivreDelivery; user=postgres; password=postgres';
        }
        try {
            $Conn = new PDO($param);
            return $Conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

?>