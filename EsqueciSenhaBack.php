<?php
    include "util.php";
    require_once "PHPMailer/src/PHPMailer.php";
    require_once "PHPMailer/src/SMTP.php";
    require_once "PHPMailer/src/Exception.php";

    use PHPMailer\src\PHPMailer;
    use PHPMailer\src\SMTP;
    use PHPMailer\src\Exception;

    //verifica se o email esta no banco
    $emailRecebido = $_POST['recuperar-senha'];
    $Conn = conectar();
    if (!$conn) {
        die("Erro ao conectar ao banco de dados.");
    }
    $stmt = $conn->prepare("SELECT id, usuario, email FROM FeiraLivreUsers WHERE email = :email");
    $stmt->bindParam(':email', $emailRecebido);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        // For security, don't tell the user if the email was found or not.
        // This prevents attackers from figuring out which emails are registered.
        header('Location: EsqueciSenhaFront.php?sucesso=true');
        exit();
    }

    // 2. Generate a secure, unique token and set its expiration (e.g., 1 hour)
    $token = bin2hex(random_bytes(32));
    $expires = date("U") + 3600;

    // 3. Store the token in the database for later validation
    $stmt = $conn->prepare("UPDATE FeiraLivreUsers SET reset_token = :token, reset_token_expiration = :expires WHERE id = :id");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':expires', $expires);
    $stmt->bindParam(':id', $usuario['id']);
    $stmt->execute();
    
    // 4. Construct the password reset link using only the secure token
    $link = "http://localhost/recuperarmail.php?token=" . $token;

    // 5. PHPMailer setup
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        // You MUST use the email and app password of the account you're sending from
        $mail->Username = $usuario; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Recipients
        $mail->setFrom("leonardo.g.anjos@unesp.br", "Feira Livre Delivery");
        $mail->addAddress($usuario['email']); // Use the correct email from the database

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Recuperação de senha";
        $mail->Body = "Olá,<br><br>Clique no link abaixo para redefinir sua senha: <a href='$link'>$link</a><br><br>Se você não solicitou a redefinição, ignore este e-mail.";
        
        $mail->send();
        header('Location: EsqueciSenhaFront.php?sucesso=true');
        exit();
    } catch (Exception $e) {
        // Log the error for debugging, but don't show it to the user
        error_log("Erro ao enviar e-mail: " . $mail->ErrorInfo);
        header('Location: EsqueciSenhaFront.php?erro=email_fail');
        exit();
    }