<?php
session_start();
require '../conexao.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: esqueci_senha.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['erro'] = 'E-mail inválido';
    header('Location: esqueci_senha.php');
    exit;
}

if (empty($telefone)) {
    $_SESSION['erro'] = 'Telefone é obrigatório';
    header('Location: esqueci_senha.php');
    exit;
}

$stmt = $conn->prepare("SELECT usuario_id, nome_usuario FROM Usuario WHERE email_usuario = ? AND telefone_usuario = ?");
$stmt->bind_param('ss', $email, $telefone);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    $_SESSION['erro'] = 'E-mail ou telefone não encontrados';
    header('Location: esqueci_senha.php');
    exit;
}

$user = $res->fetch_assoc();
$codigo = strval(rand(100000, 999999));
$expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));

$upd = $conn->prepare("UPDATE Usuario SET codigo_recuperacao = ?, expira_em = ? WHERE usuario_id = ?");
$upd->bind_param('ssi', $codigo, $expira, $user['usuario_id']);

if (!$upd->execute()) {
    $_SESSION['erro'] = 'Erro ao gerar código. Tente novamente.';
    header('Location: esqueci_senha.php');
    exit;
}

$mail = new PHPMailer(true);

try {
    // Configurações SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.elasticemail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'janjulia401@gmail.com'; // ⚠️ SUBSTITUA pelo email que usou no cadastro
    $mail->Password = '75B8ADF888C2570CD4FB502EDBA6C5E4DA9F8D0CABFA8DBAACA504923AC747D3D928520EEE8BFFEBEF6B6BF047D1CC00'; // Sua API Key
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 2525;
    $mail->CharSet = 'UTF-8';
    
    // Para melhor compatibilidade, adicione estas linhas:
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Remetente e destinatário
    $mail->setFrom('janjulia401@gmail.com', 'Suporte do Sistema'); // ⚠️ MESMO EMAIL do Username
    $mail->addAddress($email, $user['nome_usuario']);
    
    // Conteúdo do email
    $mail->isHTML(true);
    $mail->Subject = 'Código de Recuperação de Senha';
    $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
            <h2 style='color: #2563eb; text-align: center;'>Recuperação de Senha</h2>
            <p>Olá <strong>{$user['nome_usuario']}</strong>,</p>
            <p>Você solicitou a recuperação de senha. Use o código abaixo:</p>
            <div style='background: #f8f9fa; padding: 15px; border-radius: 5px; text-align: center; margin: 20px 0;'>
                <span style='font-size: 28px; font-weight: bold; color: #2563eb; letter-spacing: 5px;'>$codigo</span>
            </div>
            <p><strong>⏰ Válido por 15 minutos</strong></p>
            <hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'>
            <p style='color: #666; font-size: 12px;'>
                Se você não solicitou esta recuperação, ignore este email.<br>
                Equipe de Suporte
            </p>
        </div>
    ";
    
    $mail->AltBody = "Código de recuperação: $codigo\nVálido por 15 minutos.";

    if ($mail->send()) {
        $_SESSION['msg'] = '✅ Código enviado para seu e-mail!';
    } else {
        throw new Exception('Falha no envio');
    }
    
} catch (Exception $e) {
    // Log de erro e fallback
    error_log("Elastic Email Error: " . $e->getMessage());
    
    // Modo debug - mostra código na tela
    $_SESSION['debug_codigo'] = $codigo;
    $_SESSION['msg'] = '📧 Email não enviado. Use este código para teste: ' . $codigo;
}

$_SESSION['recupera_email'] = $email;
header('Location: verificar_codigo.php');
exit;
?>