<?php
include "util.php";
$Conn = conectar();
$varSQL = "insert into feiralivredata (nome, preco, data_colheita, imagem) values (:nome, :preco, :data_colheita, :imagem);";


$insert = $Conn->prepare($varSQL);
$insert->bindParam(':nome', $_POST['nome']);
$insert->bindParam(':preco', $_POST['preco']);
$insert->bindParam(':data_colheita', $_POST['dataColheita']);

if (isset($_FILES['imagem']) && $_FILES['imagem']['tmp_name']) {
    $tmpName = $_FILES['imagem']['tmp_name'];
    $imageInfo = getimagesize($tmpName);

    if ($imageInfo['mime'] === 'image/png') {
        // Converte PNG para JPEG
        $image = imagecreatefrompng($tmpName);
        ob_start();
        imagejpeg($image, null, 90); // 90 é a qualidade
        $jpegData = ob_get_clean();
        imagedestroy($image);
        $insert->bindParam(':imagem', $jpegData, PDO::PARAM_LOB);
    } else {
        // Se não for PNG, salva como está
        $imageData = file_get_contents($tmpName);
        $insert->bindParam(':imagem', $imageData, PDO::PARAM_LOB);
    }
} else {
    $insert->bindValue(':imagem', null, PDO::PARAM_NULL);
}

$insert->execute();
header("Location: menu.php");