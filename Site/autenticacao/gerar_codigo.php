<?php
session_start();
require '../conexao.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: esqueci_senha.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');

// Validações
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

// Verifica usuário
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

// Atualiza código no banco
$upd = $conn->prepare("UPDATE Usuario SET codigo_recuperacao = ?, expira_em = ? WHERE usuario_id = ?");
$upd->bind_param('ssi', $codigo, $expira, $user['usuario_id']);

if (!$upd->execute()) {
    $_SESSION['erro'] = 'Erro ao gerar código. Tente novamente.';
    header('Location: esqueci_senha.php');
    exit;
}

// Configuração do PHPMailer com tratamento de erro melhorado
$mail = new PHPMailer(true);

try {
    // Configurações do servidor
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Ativa debug detalhado
    $mail->isSMTP();
    $mail->Host = 'smtp.elasticemail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'seu-email@gmail.com'; // SUBSTITUA pelo seu e-mail
    $mail->Password = 'sua-api-key'; // SUA API KEY REAL
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 2525;
    $mail->CharSet = 'UTF-8';
    
    // Configurações de timeout
    $mail->Timeout = 30;
    $mail->SMTPKeepAlive = true;

    // Remetente e destinatário
    $mail->setFrom('seu-email@gmail.com', 'Suporte do Sistema');
    $mail->addAddress($email, $user['nome_usuario']);
    
    // Conteúdo
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
        throw new Exception('Falha no envio do e-mail');
    }
    
} catch (Exception $e) {
    // Log detalhado do erro
    error_log("ERRO PHPMailer: " . $e->getMessage());
    
    // Modo fallback - mostra código na tela para testes
    $_SESSION['debug_codigo'] = $codigo;
    $_SESSION['msg'] = '📧 Problema no envio de e-mail. Use este código: ' . $codigo;
    $_SESSION['erro_email'] = $e->getMessage(); // Para debug
}

$_SESSION['recupera_email'] = $email;
header('Location: verificar_codigo.php');
exit;
?>