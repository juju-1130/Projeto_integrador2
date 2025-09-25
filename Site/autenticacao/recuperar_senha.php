<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT usuario_id FROM usuarios WHERE email_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $codigo = rand(100000, 999999); 
        $expira = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        $user = $result->fetch_assoc();
        $id = $user['usuario_id'];

        $upd = $conn->prepare("UPDATE usuarios SET codigo_recuperacao=?, expira_em=? WHERE usuario_id=?");
        $upd->bind_param("ssi", $codigo, $expira, $id);
        $upd->execute();

        $assunto = "Recuperação de Senha";
        $mensagem = "Seu código de recuperação é: $codigo (válido por 10 minutos).";
        $headers = "From: suporte@seudominio.com\r\n";

        if (mail($email, $assunto, $mensagem, $headers)) {
            echo "Código enviado para seu e-mail!";
        } else {
            echo "Erro ao enviar e-mail.";
        }
    } else {
        echo "E-mail não encontrado!";
    }
}
?>
