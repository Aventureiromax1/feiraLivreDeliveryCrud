<head>
    <meta charset="UTF-8">
    <title>Registro de Novo Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background: #fff;
            max-width: 400px;
            margin: 40px auto;
            padding: 30px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background: #218838;
        }
        p {
            text-align: center;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .erro {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
    <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registro de Novo Usuário</title>
</head>
<body>
    <h2>Crie sua Conta</h2>

    <?php
    // Bloco para exibir mensagens de erro vindas do processa_registro.php
    if (isset($_GET['erro'])) {
        $erro = $_GET['erro'];
        $mensagem = '';
        switch ($erro) {
            case 'campos_vazios':
                $mensagem = 'Por favor, preencha todos os campos.';
                break;
            case 'email_invalido':
                $mensagem = 'O formato do e-mail é inválido.';
                break;
            case 'senhas_nao_conferem':
                $mensagem = 'As senhas não conferem.';
                break;
            case 'usuario_existente':
                $mensagem = 'Este nome de usuário ou e-mail já está em uso.';
                break;
            default:
                $mensagem = 'Ocorreu um erro inesperado. Tente novamente.';
                break;
        }
        echo '<p style="color:red;">' . $mensagem . '</p>';
    }
    ?>

    <form action="register.php" method="POST">
        <div>
            <label for="usuario">Nome de Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <br>
        <div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <br>
        <div>
            <label for="confirma_senha">Confirme a Senha:</label>
            <input type="password" id="confirma_senha" name="confirma_senha" required>
        </div>
        <br>
        <button type="submit">Registrar</button>
    </form>
    <br>
    <p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>

</body>
</html>
</head>