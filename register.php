<?php
include "util.php";
require "registrar.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if (empty($usuario) || empty($email) || empty($senha) || empty($confirma_senha)) {
        header("Location: registrar.php?erro=campos_vazios");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: registrar.php?erro=email_invalido");
        exit();
    }
    if ($senha !== $confirma_senha) {
        header("Location: registrar.php?erro=senhas_nao_conferem");
        exit();
    }
    $Conn = conectar();
    $stmt = $Conn->prepare("SELECT * FROM FeiraLivreUsers WHERE usuario = :usuario OR email = :email");
    $stmt->execute(['usuario' => $usuario, 'email' => $email]);
    if ($stmt->rowCount() > 0) {
        header("Location: registrar.php?erro=usuario_existente");
        exit();
    }
    //criptografar senha
    $senha_hash = password_hash($senha, PASSWORD_ARGON2ID);

    try {
        $stmt = $Conn->prepare("INSERT INTO FeiraLivreUsers (usuario, email, senha) VALUES (:usuario, :email, :senha)");
        $stmt->execute([
            'usuario' => $usuario,
            'email' => $email,
            'senha' => $senha_hash
        ]);
        header("Location: index.php?sucesso=1");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao registrar usuário: " . $e->getMessage();
        exit();
    }
}