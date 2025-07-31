<?php 
include "util.php";
$Conn = conectar();

$varSQL = "SELECT * FROM alunos WHERE id = :id";
$select = $Conn->prepare($varSQL);
$select->bindParam(':id', $_GET['id']);
$select->execute();
$linha = $select->fetch();
$id = $linha['id'];
$nome = $linha['nome'];
$email = $linha['email'];
$telefone = $linha['telefone'];
$legal = ($linha['legal'] == 1) ? 'sim' : 'nao';
$engracado = ($linha['engracado'] == 1) ? 'sim' : 'nao';
$sexo = $linha['sexo'];
$curso = $linha['curso'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
        section {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #343a40;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #343a40;
        }
        input[type="text"], input[type="email"], input[type="tel"], select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Alterar Dados</h1>
    </header>
    <section>
        <h2>Formulário</h2>
        <form action="alter.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required>

            <label for="legal">Legal:</label>
            <select id="legal" name="legal" required>
                <option value="1" <?php echo $legal === 'sim' ? 'selected' : ''; ?>>Sim</option>
                <option value="0" <?php echo $legal === 'nao' ? 'selected' : ''; ?>>Não</option>
            </select>
            <label for="engracado">Engraçado:</label>
            <select id="engracado" name="engracado" required>
                <option value="1" <?php echo $engracado === 'sim' ? 'selected' : ''; ?>>Sim</option>
                <option value="0" <?php echo $engracado === 'nao' ? 'selected' : ''; ?>>Não</option>
            </select>
            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M" <?php echo $sexo === 'M' ? 'selected' : ''; ?>>Masculino</option>
                <option value="F" <?php echo $sexo === 'F' ? 'selected' : ''; ?>>Feminino</option>
            </select>
            <label for="curso">Curso:</label>
        <select name="curso" id="curso">
            <option value="INI1A" <?php echo $curso === 'INI1A' ? 'selected' : ''; ?>>INI1A</option>
            <option value="INI1B" <?php echo $curso === 'INI1B' ? 'selected' : ''; ?>>INI1B</option>
            <option value="INI2A" <?php echo $curso === 'INI2A' ? 'selected' : ''; ?>>INI2A</option>
            <option value="INI2B" <?php echo $curso === 'INI2B' ? 'selected' : ''; ?>>INI2B</option>
            <option value="INI3A" <?php echo $curso === 'INI3A' ? 'selected' : ''; ?>>INI3A</option>
            <option value="INI3B" <?php echo $curso === 'INI3B' ? 'selected' : ''; ?>>INI3B</option>
            <option value="INF1" <?php echo $curso === 'INF1' ? 'selected' : ''; ?>>INF1</option>
            <option value="INF2" <?php echo $curso === 'INF2' ? 'selected' : ''; ?>>INF2</option>
            <option value="INF3" <?php echo $curso === 'INF3' ? 'selected' : ''; ?>>INF3</option>
            <option value="MEC1" <?php echo $curso === 'MEC1' ? 'selected' : ''; ?>>MEC1</option>
            <option value="MEC2" <?php echo $curso === 'MEC2' ? 'selected' : ''; ?>>MEC2</option>
            <option value="MEC3" <?php echo $curso === 'MEC3' ? 'selected' : ''; ?>>MEC3</option>
            <option value="ELE1" <?php echo $curso === 'ELE1' ? 'selected' : ''; ?>>ELE1</option>
            <option value="ELE2" <?php echo $curso === 'ELE2' ? 'selected' : ''; ?>>ELE2</option>
            <option value="ELE3" <?php echo $curso === 'ELE3' ? 'selected' : ''; ?>>ELE3</option>
            <option value="MECNOT1" <?php echo $curso === 'MECNOT1' ? 'selected' : ''; ?>>MECNOT1</option>
            <option value="MECNOT2" <?php echo $curso === 'MECNOT2' ? 'selected' : ''; ?>>MECNOT2</option>
            <option value="MECNOT3" <?php echo $curso === 'MECNOT3' ? 'selected' : ''; ?>>MECNOT3</option>
            <option value="ELENOT1" <?php echo $curso === 'ELENOT1' ? 'selected' : ''; ?>>ELENOT1</option>
            <option value="ELENOT2" <?php echo $curso === 'ELENOT2' ? 'selected' : ''; ?>>ELENOT2</option>
            <option value="ELENOT3" <?php echo $curso === 'ELENOT3' ? 'selected' : ''; ?>>ELENOT3</option>
        </select>
        </select>
            <button type="submit">Salvar Alterações</button>
        </form>
    </section>
</body>
</html>