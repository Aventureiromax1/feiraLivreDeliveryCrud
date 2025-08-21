<?php
include "util.php";


session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user_digitado = $_POST['username'];
    $senha_digitada = $_POST['password'];
    $Conn = conectar();
    $stmt = $Conn->prepare("SELECT id, senha FROM FeiraLivreUsers WHERE usuario = :usuario");
    $stmt->bindParam(':usuario', $user_digitado);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $user_digitado;
        $_SESSION['logged_in'] = true;

        header('Location: menu.php');
        exit();

    } else {
        header('Location: index.php?erro=1');
        exit();
    }
}
?>