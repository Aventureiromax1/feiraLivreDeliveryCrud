<?php
// 1. Incluir o arquivo de conexão e conectar ao banco de dados
include "util.php"; // Seu arquivo que contém a função conectar()
$Conn = conectar();

// 2. Verificar se a página foi acessada através do envio do formulário (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {
        // 3. Recuperar os dados enviados pelo formulário
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $data_colheita = $_POST['data_colheita'];
        
        // Inicia a variável que guardará os dados binários da imagem
        $dados_imagem_final = null;

        // 4. Lógica para decidir qual imagem usar (a nova ou a antiga)
        // Verifica se um NOVO arquivo foi enviado e se não houve erro no upload
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
            
            // Se uma nova imagem foi enviada, lê seu conteúdo. O resultado já é uma 'string'.
            $caminho_temporario = $_FILES['imagem']['tmp_name'];
            $dados_imagem_final = file_get_contents($caminho_temporario);

        } else {
            // Se NENHUMA imagem nova foi enviada, busca a imagem ANTIGA do banco para mantê-la.
            $stmt = $Conn->prepare('SELECT imagem FROM feiralivredata WHERE id_produto = :id');
            $stmt->execute([':id' => $id]);
            $imagem_do_banco = $stmt->fetchColumn(); // Pega apenas a coluna da imagem

            // ✅ AQUI ESTÁ A CORREÇÃO DEFINITIVA DO ERRO
            // Verifica se o dado retornado do banco é um 'resource'
            if (is_resource($imagem_do_banco)) {
                // Se for, lê o conteúdo do 'resource' para uma 'string'
                $dados_imagem_final = stream_get_contents($imagem_do_banco);
            } else {
                // Caso contrário, o dado já é uma 'string' (ou nulo), então pode ser usado diretamente
                $dados_imagem_final = $imagem_do_banco;
            }
        }

        // 5. Preparar o comando SQL para ATUALIZAR o registro no banco de dados
        $sql = "UPDATE feiralivredata 
                SET nome = :nome, 
                    preco = :preco, 
                    data_colheita = :data_colheita, 
                    imagem = :imagem 
                WHERE id_produto = :id";
        
        $update = $Conn->prepare($sql);

        // 6. Associar (bind) todos os parâmetros aos seus respectivos valores
        $update->bindParam(':id', $id, PDO::PARAM_INT);
        $update->bindParam(':nome', $nome, PDO::PARAM_STR);
        $update->bindParam(':preco', $preco, PDO::PARAM_STR);
        $update->bindParam(':data_colheita', $data_colheita, PDO::PARAM_STR);
        
        // Para colunas BLOB/BYTEA, é fundamental usar PDO::PARAM_LOB para tratar como um "Large Object"
        $update->bindParam(':imagem', $dados_imagem_final, PDO::PARAM_LOB);

        // 7. Executar a atualização
        if ($update->execute()) {
            // Se a execução for bem-sucedida, exibe um alerta e redireciona o usuário
            echo "<script>
                    alert('Produto alterado com sucesso!');
                    window.location.href = 'listagem.php'; // Altere para a sua página de listagem
                  </script>";
        } else {
            // Se ocorrer um erro na execução, informa o usuário
            echo "<script>
                    alert('Ocorreu um erro ao alterar o produto. Tente novamente.');
                    window.history.back(); // Volta para a página anterior (o formulário)
                  </script>";
        }

    } catch (PDOException $e) {
        // Captura e exibe qualquer erro de conexão ou de comando com o banco de dados
        die("Erro na operação de banco de dados: " . $e->getMessage());
    }

} else {
    // Medida de segurança: se alguém acessar este script diretamente pela URL, nega o acesso.
    header('HTTP/1.1 403 Forbidden');
    echo "Acesso negado. Você deve enviar os dados através do formulário.";
    exit;
}
?>