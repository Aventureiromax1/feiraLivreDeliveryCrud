<?php
include "util.php";
    $Conn = conectar();
    $selectArray = 'SELECT * FROM feiralivredata';
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
    <table border="1">
        <tr>
            <td>Id</td>
            <td>nome</td>
            <td>preço</td>
            <td>data da colheita</td>
            <td>imagem</td>
            <td>Ações</td>
        </tr>
        <?php
                    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id_produto']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['preco']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['data_colheita']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['imagem']) . "</td>";
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