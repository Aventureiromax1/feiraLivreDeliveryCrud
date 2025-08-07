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
    $imageInfo = getimagesize($tmpName);//info imagens

    if ($imageInfo['mime'] === 'image/png') {
        $image = imagecreatefrompng($tmpName);
        ob_start();
        imagejpeg($image, null, 90);
        $jpegData = ob_get_clean();
        imagedestroy($image);
        $insert->bindParam(':imagem', $jpegData);
    } else {
        $imageData = file_get_contents($tmpName);
        $insert->bindParam(':imagem', $imageData);
    }
} else {
    $insert->bindValue(':imagem', null);
}

$insert->execute();
header("Location: menu.php");