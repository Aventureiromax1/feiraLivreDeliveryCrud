<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alterar Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        background: #f4f4f4;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 400px;
        margin: 60px auto;
        background: #fff;
        padding: 32px 24px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    h2 {
        text-align: center;
        margin-bottom: 24px;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
    }

    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 18px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }

    .msg {
        text-align: center;
        margin-bottom: 16px;
        color: #d9534f;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Alterar Senha</h2>
        <!-- Mensagem de erro/sucesso pode ser exibida aqui -->
        <?php if(isset($_GET['msg'])): ?>
        <div class="msg"><?php echo htmlspecialchars($_GET['msg']); ?></div>
        <?php endif; ?>
        <form method="post" action="processaAlterarSenha.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="senhaAtual">Senha Atual</label>
            <input type="password" id="senhaAtual" name="senhaAtual" required>

            <label for="novaSenha">Nova Senha</label>
            <input type="password" id="novaSenha" name="novaSenha" required>

            <label for="confirmaSenha">Confirme a Nova Senha</label>
            <input type="password" id="confirmaSenha" name="confirmaSenha" required>

            <?php
                if (isset($_GET['erro'])) {
                    echo "<p style='color:red;'>" . htmlspecialchars($_GET['erro']) . "</p>";
                }
            ?>

            <button type="submit">Alterar Senha</button>
            <button type="button" onclick="window.history.back();">Voltar</button>

        </form>
    </div>
</body>

</html>