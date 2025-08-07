<?php
include "util.php";
$Conn = conectar();

// Busca os dados do produto no banco de dados
$varSQL = "SELECT * FROM feiralivredata WHERE id_produto = :id";
$select = $Conn->prepare($varSQL);
$select->bindParam(':id', $_GET['id']);
$select->execute();

// Pega a linha de resultado
$linha = $select->fetch();

// Atribui os dados a variáveis para facilitar o uso
$id = $linha['id_produto'];
$nome = $linha['nome'];
$preco = $linha['preco'];
$data_colheita = $linha['data_colheita'];
// A variável $imagem contém os dados binários da imagem vindos do banco
$imagem = $linha['imagem'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados do Produto</title>
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
            color: #495057;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .imagem-atual-container {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Alterar Dados</h1>
    </header>
    <section>
        <h2>Formulário de Alteração</h2>
        <form action="alter.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>

            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" value="<?php echo htmlspecialchars($preco); ?>" required>

            <label for="data_colheita">Data da Colheita:</label>
            <input type="date" id="data_colheita" name="data_colheita"
                value="<?php echo htmlspecialchars($data_colheita); ?>" required>

            <div class="imagem-atual-container">
                <label>Imagem Atual:</label>
                <?php
                
                if (is_resource($imagem)) {// verifica se a imagem veio corretamente do banco
                    $imagem = stream_get_contents($imagem);//transforma a imagem em uma string
                }
                $imagemBase64 = base64_encode($imagem); //transforma a string em base64
                if (!empty($imagem)) {
                    $imagemBase64 = base64_encode($imagem);//transforma a string em base64
                    $tipoMime = new finfo(FILEINFO_MIME_TYPE);//detecta o tipo do arquivo
                    $mimeImagem = $tipoMime->buffer($imagem);//buffer retorna o tipo da imagem
                    echo '<div><img src="data:' . $mimeImagem . ';base64,' . $imagemBase64 . '" alt="Imagem Atual do Produto" style="max-width: 150px; max-height: 150px; border-radius: 4px; border: 1px solid #ddd;"></div>';
                    //exibe a imagem
                } else {
                    // Se não houver imagem, exibe uma mensagem.
                    echo '<div>Nenhuma imagem cadastrada.</div>';
                }
                ?>

                <label for="imagem_input">Alterar Imagem (opcional):</label>
                <input type="file" id="imagem_input" name="imagem" accept="image/*">

                <button type="submit">Salvar Alterações</button>
        </form>
    </section>
</body>

</html>