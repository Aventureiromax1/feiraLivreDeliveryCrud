<?php
include "util.php";
$Conn = conectar();
$varSQL = "insert into alunos (nome, email, telefone, legal, engracado, sexo, curso) values (:nome, :email, :telefone, :legal, :engracado, :sexo, :curso);";


$insert = $Conn->prepare($varSQL);
$insert->bindParam(':nome', $_POST['nome']);
$insert->bindParam(':email', $_POST['email']);
$insert->bindParam(':telefone', $_POST['telefone']);
$legal = ($_POST['legal'] === 'sim') ? 1 : 0;
$engracado = ($_POST['engracado'] === 'sim') ? 1 : 0;
$insert->bindParam(':legal', $legal, PDO::PARAM_BOOL);
$insert->bindParam(':engracado', $engracado, PDO::PARAM_BOOL);
$sexo = $_POST['sexo'] === 'masculino' ? 'M' : ($_POST['sexo'] === 'feminino' ? 'F' : 'O');
$insert->bindParam(':sexo', $sexo);
$insert->bindParam(':curso', $_POST['curso']);
$insert->execute();
header("Location: alunos.php");
?>