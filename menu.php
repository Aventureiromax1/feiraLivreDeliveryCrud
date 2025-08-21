<?php
include "util.php";
session_start(); // Sempre no topo!
if (!isset($_SESSION['usuario_id'])) {
    // Se não tem crachá, expulsa da página.
    header('Location: index.php?erro=acesso_negado');
    exit();
}
$Conn = conectar();
$selectArray = 'SELECT * FROM feiralivredata order by id_produto asc';
$select = $Conn->prepare($selectArray);
$select->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feira</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Bem-vindo ao Menu da Feira Livre</h1>
        <h2>Olá <?php echo isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Usuário'; ?></h2>
    </header>
    <table border="1">
        <tr>
            <td>Id</td>
            <td>nome</td>
            <td>preço(R$)</td>
            <td>data da colheita</td>
            <td>imagem</td>
            <td>Ações</td>
        </tr>
        <?php
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id_produto']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
            echo "<td>" . htmlspecialchars("R$" . $row['preco']) . "</td>";
            echo "<td>" . htmlspecialchars($row['data_colheita']) . "</td>";
            if (!empty($row['imagem'])) {
                $imgData = $row['imagem'];
                if (is_resource($imgData)) {
                    $imgData = stream_get_contents($imgData);
                }
                // Detecta o tipo da imagem
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($imgData);
                $imgBase64 = base64_encode($imgData);
                echo "<td><img src='data:$mimeType;base64,$imgBase64' alt='Imagem' style='max-width:100px; max-height:100px;'/></td>";
            } else {
                echo "<td>Sem imagem</td>";
            }
            echo "<td>
                                <form action='alterar.php' method='get' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . htmlspecialchars($row['id_produto']) . "'>
                                    <input type='submit' value='Alterar'>
                                </form>
                                <form action='excluir.php' method='post' style='display:inline;' onsubmit=\"return confirm('Tem certeza que deseja excluir este registro?');\">
                                    <input type='hidden' name='id' value='" . htmlspecialchars($row['id_produto']) . "'>
                                    <input type='submit' value='Excluir'>
                                </form>
                              </td>";
            echo "</tr>";
        }
        ?>
    </table>
    <form action="adicionar.html" method="post">
        <input type="submit" value="Adicionar">
    </form>
</body>

</html>