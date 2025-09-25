<?php
session_start();
require '../conexao.php'; // conexão com o banco

// se não tem e-mail na sessão, volta para "esqueci senha"
if (empty($_SESSION['recupera_email'])) {
    header('Location: ../autenticacao/esquecisenha.php');
    exit;
}

$email = $_SESSION['recupera_email'];

// se o form foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = trim($_POST['codigo'] ?? '');

    if (!preg_match('/^\d{6}$/', $codigo)) {
        $_SESSION['erro'] = 'Código inválido. Digite 6 números.';
        header('Location: verificar_codigo.php');
        exit;
    }

    // busca usuário pelo email e verifica código
    $stmt = $conn->prepare("SELECT usuario_id, codigo_recuperacao, expira_em 
                            FROM Usuario 
                            WHERE email_usuario = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        $_SESSION['erro'] = 'Usuário não encontrado.';
        header('Location: ../autenticacao/esquecisenha.php');
        exit;
    }

    $user = $res->fetch_assoc();

    // verifica código e validade
    if ($user['codigo_recuperacao'] !== $codigo) {
        $_SESSION['erro'] = 'Código incorreto.';
        header('Location: verificar_codigo.php');
        exit;
    }

    if (strtotime($user['expira_em']) < time()) {
        $_SESSION['erro'] = 'Código expirado. Solicite novamente.';
        header('Location: ../autenticacao/esquecisenha.php');
        exit;
    }

    // código válido → guarda ID na sessão e redireciona para redefinir senha
    $_SESSION['usuario_reset'] = $user['usuario_id'];
    header('Location: ../autenticacao/nova_senha.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código</title>
</head>
<body>
    <?php if (!empty($_SESSION['erro'])): ?>
        <p style="color:red"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
    <?php endif; ?>

    <h2>Digite o código enviado para <?= htmlspecialchars($email) ?>:</h2>

    <form method="post" action="">
        <label for="codigo">Código (6 dígitos):</label>
        <input type="text" name="codigo" id="codigo" maxlength="6" required>
        <button type="submit">Verificar</button>
    </form>
</body>
</html>
