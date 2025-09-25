<?php
include '../conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome      = $_POST['usuario'] ?? '';
    $email     = $_POST['email'] ?? '';
    $telefone  = $_POST['telefone'] ?? '';
    $senha     = $_POST['senha'] ?? '';
    $confirma  = $_POST['confirmar_senha'] ?? '';

    if (empty($nome) || empty($email) || empty($telefone) || empty($senha) || empty($confirma)) {
        header("Location: cadastrar.php?erro=campos");
        exit;
    }

    if ($senha !== $confirma) {
        header("Location: cadastrar.php?erro=senha");
        exit;
    }

    $check = $conn->prepare("SELECT usuario_id FROM Usuario WHERE email_usuario = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: cadastrar.php?erro=email");
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuario (nome_usuario, email_usuario, telefone_usuario, senha_usuario, tipo_usuario) 
            VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        header("Location: cadastrar.php?erro=db");
        exit;
    }

    $stmt->bind_param("ssss", $nome, $email, $telefone, $senhaHash);

    if ($stmt->execute()) {
        header("Location: cadastrar.php?sucesso=1");
        exit;
    } else {
        header("Location: cadastrar.php?erro=inserir");
        exit;
    }
}
?>
