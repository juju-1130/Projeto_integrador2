<?php
session_start();
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT usuario_id, senha_usuario, nome_usuario, email_usuario, telefone_usuario, tipo_usuario 
            FROM Usuario 
            WHERE email_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha_usuario'])) {
            // Garante nova sessão limpa
            session_regenerate_id(true);

            // 🔹 Variáveis de sessão padrão para todo o sistema
            $_SESSION['usuario_id'] = $user['usuario_id'];
            $_SESSION['nome_usuario'] = $user['nome_usuario'];
            $_SESSION['email_usuario'] = $user['email_usuario'];
            $_SESSION['telefone_usuario'] = $user['telefone_usuario'];
            $_SESSION['tipo_usuario'] = (int)$user['tipo_usuario'];
            $_SESSION['logado'] = true;

            // Log para depuração (pode remover em produção)
            error_log("Login bem-sucedido: ID {$user['usuario_id']} - Tipo {$user['tipo_usuario']}");

            // Fechar modal e recarregar a página
            echo "<script>
                localStorage.setItem('loginSuccess', 'true');
                window.location.href = '../index.php';
            </script>";
            exit;
        } else {
            // Mensagem única para ambos os casos de erro
            echo "<script>
                localStorage.setItem('loginError', 'Usuário ou senha incorretos!');
                window.location.href = '../index.php?show_login=1';
            </script>";
            exit;
        }
    } else {
        // Mensagem única para ambos os casos de erro
        echo "<script>
            localStorage.setItem('loginError', 'Usuário ou senha incorretos!');
            window.location.href = '../index.php?show_login=1';
        </script>";
        exit;
    }
}
?>