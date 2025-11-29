<?php
include '../conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados
    $nome = $_POST['usuario'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirma = $_POST['confirmar_senha'] ?? '';

    // Validação de campos vazios
    if (empty($nome) || empty($email) || empty($telefone) || empty($senha) || empty($confirma)) {
        echo "<script>
            alert('Preencha todos os campos obrigatórios!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // VALIDAÇÃO DE EMAIL (Back-end)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('Email inválido! Use um formato válido: usuario@exemplo.com');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // VALIDAÇÃO DE TELEFONE (Back-end)
    $telefone_limpo = preg_replace('/\D/', '', $telefone);
    if (strlen($telefone_limpo) < 10 || strlen($telefone_limpo) > 11) {
        echo "<script>
            alert('Telefone inválido! Digite DDD + número (10 ou 11 dígitos)');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Verificar formato do telefone
    if (!preg_match('/^\d+$/', $telefone_limpo)) {
        echo "<script>
            alert('Telefone contém caracteres inválidos! Use apenas números.');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Validação de senha (apenas verificação se coincidem)
    if ($senha !== $confirma) {
        echo "<script>
            alert('As senhas não coincidem!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Verificar se email já existe
    $check = $conn->prepare("SELECT usuario_id FROM Usuario WHERE email_usuario = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>
            alert('Este e-mail já está cadastrado!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Verificar se telefone já existe
    $check_telefone = $conn->prepare("SELECT usuario_id FROM Usuario WHERE telefone_usuario = ?");
    $check_telefone->bind_param("s", $telefone_limpo);
    $check_telefone->execute();
    $check_telefone->store_result();

    if ($check_telefone->num_rows > 0) {
        echo "<script>
            alert('Este telefone já está cadastrado!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $telefone_formatado = $telefone_limpo;

    $sql = "INSERT INTO Usuario (nome_usuario, email_usuario, telefone_usuario, senha_usuario, tipo_usuario) 
            VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $telefone_formatado, $senhaHash);

    if ($stmt->execute()) {
        echo "<script>
            alert('Usuário cadastrado com sucesso! Faça login para continuar.');
            window.location.href = '../index.php?show_login=1';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Erro ao cadastrar usuário!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }
}
?>