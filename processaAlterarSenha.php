<?php
include "util.php";
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?erro=login_requerido');
    exit;
}

// Recebe dados do formulário
$senha_atual = $_POST['senhaAtual'] ?? '';
$nova_senha = $_POST['novaSenha'] ?? '';
$confirma_senha = $_POST['confirmaSenha'] ?? '';

// Validação básica
if (empty($senha_atual) || empty($nova_senha) || empty($confirma_senha)) {
    header('Location: alterarSenha.php?erro=campos_vazios');
    exit;
}

// Verifica se as novas senhas batem
if ($nova_senha !== $confirma_senha) {
    header('Location: alterarSenha.php?erro=senhas_nao_batem');
    exit;
}

// Busca a senha atual do usuário no banco
$pdo = conectar();
$usuario_id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare('SELECT senha FROM feiralivreusers WHERE id = ?');
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: alterarSenha.php?erro=usuario_nao_encontrado');
    exit;
}

// Verifica se a senha atual está correta
if (!password_verify($senha_atual, $usuario['senha'])) {
    header('Location: alterarSenha.php?erro=senha_atual_incorreta');
    exit;
}

// Criptografa a nova senha
$nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

// Atualiza a senha no banco
$stmt = $pdo->prepare('UPDATE feiralivreusers SET senha = ? WHERE id = ?');
if ($stmt->execute([$nova_senha_hash, $usuario_id])) {
    header('Location: alterarUsuario.php?sucesso=senha_alterada');
    exit;
} else {
    header('Location: alterarSenha.php?erro=erro_ao_alterar');
    exit;
}
?>