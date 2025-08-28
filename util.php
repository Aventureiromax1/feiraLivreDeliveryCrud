<?php 
$dbname = 'feiraLivreDeliveryData';
//$dbname = 'feiraLivreData';
 function conectar($param = '') {
        if ($param == '') {
            $param = 'pgsql:host=localhost; port=5432; dbname=feiraLivreData; user=postgres; password=postgres';
        }
        try {
            $Conn = new PDO($param);
            return $Conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }
    ini_set('session.cookie_lifetime', 86400); // 1 dia
    ini_set('session.gc_maxlifetime', 86400);
    session_start();
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>