<?php
include "util.php";
$Conn = conectar();
$varSQL = "DELETE FROM feiralivredata WHERE id_produto = :id";
$delete = $Conn->prepare($varSQL);
$delete->bindParam(':id', $_POST['id']);
$delete->execute();
header("Location: menu.php");
?>