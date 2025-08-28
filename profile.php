<?php
// profile.php

session_start();
// Exemplo de usuário logado
$user = [
    'nome' => $_SESSION['usuario_nome'],
    'email' => $_SESSION['usuario_email'],
    'id' => $_SESSION['usuario_id']
];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f9f9f9;
    }

    .profile-menu {
        max-width: 400px;
        margin: 40px auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px #ccc;
        padding: 24px;
    }

    .profile-info {
        margin-bottom: 32px;
    }

    .profile-info h2 {
        margin: 0 0 8px 0;
    }

    .profile-info p {
        margin: 4px 0;
        color: #555;
    }

    .menu-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .menu-actions button {
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .alterar {
        background: #007bff;
        color: #fff;
    }

    .excluir {
        background: #dc3545;
        color: #fff;
    }
    </style>
    <script>
    function confirmarExclusao() {
        return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.');
    }
    </script>
</head>

<body>
    <div class="profile-menu">
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($user['nome']); ?></h2>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <div class="menu-actions">
            <form action="alterarUsuario.php" method="get">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                <button type="submit" class="alterar">Alterar Usuário</button>
            </form>
            <form action="excluir_conta.php" method="post" onsubmit="return confirmarExclusao();">
                <button type="submit" class="excluir">Excluir Conta</button>
            </form>
            <form action="menu.php" method="get">
                <button type="submit" style="background:#6c757d;color:#fff;">Voltar</button>
            </form>
        </div>
    </div>
</body>

</html>