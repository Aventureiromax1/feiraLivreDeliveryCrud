<?php
include "util.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;
    $conn = conectar();
    if(validarEmail($email) === false) {
        header('Location: alterarUsuario.php?erro=email_invalido&id=' . urlencode($id));
        exit();
    }
    if ($id !=null && $usuario && $email) {
        // Se senha foi informada, atualiza também
        try {
            if ($senha) {
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $sql = "UPDATE feiralivreusers SET usuario = ?, email = ?, senha = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([$usuario, $email, $senhaHash, $id]);
            } else {
                $sql = "UPDATE feiralivreusers SET usuario = ?, email = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([$usuario, $email, $id]);
            }

            if ($result) {
                echo "Usuário alterado com sucesso!";
                $_SESSION['usuario_nome'] = $usuario;
                $_SESSION['usuario_email'] = $email;
                header('Location: profile.php');
            } else {
                echo "Erro ao alterar usuário: {$stmt->errorInfo()[2]}";
            }
        } catch (PDOException $e) {
            echo "Erro ao alterar usuário: {$e->getMessage()}";
        }
    } else {
        echo "Dados inválidos.";
    }
} else {
    echo "Requisição inválida.";
}