<?php
include "util.php";
// Recebe o ID do usuário via POST ou GET
$id = isset($_POST['id']) ? intval($_POST['id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);

// Conexão com o banco de dados (ajuste conforme necessário)
$conn = conectar();
if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

// Busca os dados do usuário
$usuario = $email = "";
if ($id > 0) {
    try {
        $stmt = $conn->prepare("SELECT usuario, email FROM feiralivreusers WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $usuario = $result['usuario'];
            $email = $result['email'];
        }
    } catch (PDOException $e) {
        die("Erro ao buscar usuário: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Alterar Usuário</h2>
        <form method="post" action="salvarAlteracaoUsuario.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite o nome"
                    value="<?php echo htmlspecialchars($usuario); ?>">
            </div>
            <div class="mb-3">

                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail"
                    value="<?php echo htmlspecialchars($email); ?>" required>
                <?php
                if (isset($_GET['erro']) && $_GET['erro'] == 'email_invalido') {
                    echo '<p style="color:red;">Email Invalido.</p>';
                    
                }
                ?>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                <a href="alterarSenha.php?id=<?php echo htmlspecialchars($id); ?>" class="btn btn-warning ms-2">Alterar
                    Senha</a>
        </form>
    </div>
</body>

</html>