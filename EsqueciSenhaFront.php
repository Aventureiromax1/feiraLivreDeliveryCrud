<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
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

    input[type="email"] {
        width: 93%;
        padding: 12px;
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
        margin-top: 10px;
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
        <h2>Recuperar Senha</h2>
        <form method="post" action="EsqueciSenhaBack.php">

            <label for="RecuperarSenha">Insira seu e-mail</label>
            <input type="email" id="RecuperarSenha" name="RecuperarSenha" required>

            <?php
                if (isset($_GET['erro'])) {
                    echo "<p style='color:red;'>" . htmlspecialchars($_GET['erro']) . "</p>";
                }
            ?>

            <button type="submit">Recuperar Senha</button>
            <button type="button" onclick="window.history.back();">Voltar</button>

        </form>
    </div>
    
</body>

</html>