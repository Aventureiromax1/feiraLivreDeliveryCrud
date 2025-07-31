<?php
include "util.php";
$Conn = conectar();

$varSQL = "update alunos set nome = :nome, email = :email, telefone = :telefone, legal = :legal, engracado = :engracado, sexo = :sexo, curso = :curso WHERE  id = :id;";
$update = $Conn->prepare($varSQL);
$update->bindParam(':nome', $_POST['nome']);
$update->bindParam(':email', $_POST['email']);
$update->bindParam(':telefone', $_POST['telefone']);
$legal = isset($_POST['legal']) ? $_POST['legal'] : "false";
$engracado = isset($_POST['engracado']) ? $_POST['engracado'] : "false";
$update->bindParam(':legal', $legal);
$update->bindParam(':engracado', $engracado);
$update->bindParam(':sexo', $_POST['sexo']);
$update->bindParam(':curso', $_POST['curso']);
$update->bindParam(':id', $_POST['id']);
$update->execute();
header("Location: alunos.php");