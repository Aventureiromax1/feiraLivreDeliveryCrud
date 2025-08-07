<?php
include "util.php";
$Conn = conectar();
$id = $_POST['id'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];
$data_colheita = $_POST['data_colheita'];
$dadosImagem = null;

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
    $caminho_temporario = $_FILES['imagem']['tmp_name'];
    $dadosImagem = file_get_contents($caminho_temporario);

} else {
    $stmt = $Conn->prepare('SELECT imagem FROM feiralivredata WHERE id_produto = :id');
    $stmt->execute([':id' => $id]);
    $imagemBanco = $stmt->fetchColumn();
    if (is_resource($imagemBanco)) {
        $dadosImagem = stream_get_contents($imagemBanco);
    } else {
        $dadosImagem = $imagemBanco;
    }
}
$sql = "UPDATE feiralivredata 
                SET nome = :nome, 
                    preco = :preco, 
                    data_colheita = :data_colheita, 
                    imagem = :imagem 
                WHERE id_produto = :id";

$update = $Conn->prepare($sql);
$update->bindParam(':id', $id, PDO::PARAM_INT);
$update->bindParam(':nome', $nome, PDO::PARAM_STR);
$update->bindParam(':preco', $preco, PDO::PARAM_STR);
$update->bindParam(':data_colheita', $data_colheita, PDO::PARAM_STR);

$update->bindParam(':imagem', $dadosImagem, PDO::PARAM_LOB);//precisa do pdo param_lob para salvar imagens

if ($update->execute()) {
    header('Location:menu.php');
    exit;
} else {
    echo "<script>
                    alert('Ocorreu um erro ao alterar o produto. Tente novamente.');
                    window.history.back();
                  </script>";
}
?>