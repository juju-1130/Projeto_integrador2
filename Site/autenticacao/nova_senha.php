<?php
session_start();
require '../conexao.php';

// se não tem usuário em reset, volta ao "esqueci senha"
if (empty($_SESSION['usuario_reset'])) {
    header('Location: ../autenticacao/esquecisenha.php');
    exit;
}

$usuarioId = (int) $_SESSION['usuario_reset'];

// se formulário enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha1 = $_POST['senha1'] ?? '';
    $senha2 = $_POST['senha2'] ?? '';

    if ($senha1 !== $senha2) {
        $_SESSION['erro'] = 'As senhas não coincidem.';
        header('Location: nova_senha.php');
        exit;
    }

    if (strlen($senha1) < 6) {
        $_SESSION['erro'] = 'A senha deve ter pelo menos 6 caracteres.';
        header('Location: nova_senha.php');
        exit;
    }

    // gera hash seguro da senha
    $hash = password_hash($senha1, PASSWORD_DEFAULT);

    // atualiza no banco
    $stmt = $conn->prepare("UPDATE Usuario 
                            SET senha_usuario = ?, codigo_recuperacao = NULL, expira_em = NULL 
                            WHERE usuario_id = ?");
    $stmt->bind_param('si', $hash, $usuarioId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        unset($_SESSION['usuario_reset']); // limpa sessão
        $_SESSION['msg'] = 'Senha alterada com sucesso! Faça login.';
        header('Location: ../autenticacao/login.php'); // ajuste para seu login
        exit;
    } else {
        $_SESSION['erro'] = 'Erro ao atualizar senha. Tente novamente.';
        header('Location: nova_senha.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Senha</title>
</head>
<body>
    <?php if (!empty($_SESSION['erro'])): ?>
        <p style="color:red"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
    <?php endif; ?>

    <h2>Defina sua nova senha</h2>
    <form method="post" action="">
        <label for="senha1">Nova senha:</label><br>
        <input type="password" name="senha1" id="senha1" required><br><br>

        <label for="senha2">Confirme a senha:</label><br>
        <input type="password" name="senha2" id="senha2" required><br><br>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
