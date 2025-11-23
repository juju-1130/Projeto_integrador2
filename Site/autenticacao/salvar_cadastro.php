<?php
include '../conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar entradas
    $nome = filter_var($_POST['usuario'] ?? '', FILTER_SANITIZE_STRING);
    $email = trim($_POST['email'] ?? '');          
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('Email inválido!');
            window.location.href = '../index.php?erro_cadastro=1';
        </script>";
        exit();
    }
    $telefone = $_POST['telefone'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirma = $_POST['confirmar_senha'] ?? '';

    // Validação de campos vazios
    if (empty($nome) || empty($email) || empty($telefone) || empty($senha) || empty($confirma)) {
        echo "<script>
            localStorage.setItem('cadastroError', 'Preencha todos os campos obrigatórios!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Validação de email - SIMPLIFICADA
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            localStorage.setItem('cadastroError', 'Por favor, insira um email válido!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Limpar e validar telefone - ACEITA APENAS NÚMEROS
    $telefone_limpo = preg_replace('/\D/', '', $telefone);
    
    if (strlen($telefone_limpo) < 10 || strlen($telefone_limpo) > 11) {
        echo "<script>
            localStorage.setItem('cadastroError', 'Por favor, insira um telefone válido com DDD + número (10 ou 11 dígitos)!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Formatar telefone para salvar no banco (opcional)
    if (strlen($telefone_limpo) === 11) {
        $telefone_formatado = "({$telefone_limpo[0]}{$telefone_limpo[1]}){$telefone_limpo[2]}{$telefone_limpo[3]}{$telefone_limpo[4]}{$telefone_limpo[5]}{$telefone_limpo[6]}-{$telefone_limpo[7]}{$telefone_limpo[8]}{$telefone_limpo[9]}{$telefone_limpo[10]}";
    } else {
        $telefone_formatado = "({$telefone_limpo[0]}{$telefone_limpo[1]}){$telefone_limpo[2]}{$telefone_limpo[3]}{$telefone_limpo[4]}{$telefone_limpo[5]}-{$telefone_limpo[6]}{$telefone_limpo[7]}{$telefone_limpo[8]}{$telefone_limpo[9]}";
    }

    // Validação de senha
    if ($senha !== $confirma) {
        echo "<script>
            localStorage.setItem('cadastroError', 'As senhas não coincidem!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Validação de força da senha (backend)
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $senha)) {
        echo "<script>
            localStorage.setItem('cadastroError', 'A senha não atende aos requisitos de segurança!');
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
            localStorage.setItem('cadastroError', 'Este e-mail já está cadastrado!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuario (nome_usuario, email_usuario, telefone_usuario, senha_usuario, tipo_usuario) 
            VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>
            localStorage.setItem('cadastroError', 'Erro no banco de dados!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }

    // Usar o telefone formatado no banco
    $stmt->bind_param("ssss", $nome, $email, $telefone_formatado, $senhaHash);

    if ($stmt->execute()) {
        echo "<script>
            localStorage.setItem('cadastroSuccess', 'Usuário cadastrado com sucesso! Faça login para continuar.');
            window.location.href = '../index.php?show_login=1';
        </script>";
        exit;
    } else {
        echo "<script>
            localStorage.setItem('cadastroError', 'Erro ao cadastrar usuário!');
            window.location.href = '../index.php?show_cadastro=1';
        </script>";
        exit;
    }
}
?>