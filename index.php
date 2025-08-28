<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feira Livre Delivery</title>
</head>

<body>
    <?php
    session_start();
    if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'registrado') {
        echo '<p style="color:green;">Registro realizado com sucesso! Faça seu login.</p>';
    }
    if (isset($_GET['erro']) && $_GET['erro'] == 'acesso_negado') {
        echo '<p style="color:red;">Acesso negado! Por favor, faça login.</p>';
    }
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

    header('Location: menu.php');
    exit;
}
    ?>
    <div
        style="max-width: 350px; margin: 50px auto; padding: 24px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h2 style="text-align:center;">Login</h2>
        <form action="login.php" method="post" style="display:flex; flex-direction:column;">
            <div style="margin-bottom: 16px;">
                <label for="username" style="display:block; margin-bottom:6px;">Usuário</label>
                <input type="text" id="username" name="username" required
                    style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label for="password" style="display:block; margin-bottom:6px;">Senha</label>
                <input type="password" id="password" name="password" required
                    style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>
            <button type="submit"
                style="width:100%; padding:10px; background:#28a745; color:#fff; border:none; border-radius:4px; font-size:16px;">Entrar</button>
        </form>
        <?php
            if (isset($_GET['erro'])) {
                echo '<p style="color:red; text-align:center;">E-mail ou senha inválidos!</p>';
            }
        ?>
        <p style="text-align:center; margin-top:16px;"><a href="EsqueciSenhaFront.php">Esqueceu a senha?</a></p>

        <p style="text-align:center; margin-top:16px;">Não tem uma conta? <a href="registrar.php">Registrar</a></p>
    </div>
</body>

</html>