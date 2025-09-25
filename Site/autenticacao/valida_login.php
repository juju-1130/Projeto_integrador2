<?php
session_start();
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT usuario_id, senha_usuario, nome_usuario, tipo_usuario 
            FROM Usuario 
            WHERE email_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha_usuario'])) {
            // Limpa a sessão antes de setar novos valores
            session_regenerate_id(true);
            
            // Seta variáveis de sessão
            $_SESSION['usuario_id'] = $user['usuario_id'];
            $_SESSION['nome_usuario'] = $user['nome_usuario'];
            $_SESSION['tipo_usuario'] = (int)$user['tipo_usuario']; // Garante que é inteiro
            $_SESSION['logado'] = true;

            // Debug (remover em produção)
            error_log("Login bem-sucedido - Tipo usuário: " . $_SESSION['tipo_usuario']);
            
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['erro_login'] = "Senha incorreta!";
            header("Location: ../autenticacao/login.php");
            exit;
        }
    } else {
        $_SESSION['erro_login'] = "Usuário não encontrado!";
        header("Location: ../autenticacao/login.php");
        exit;
    }
}
?>