<?php
require '../../conexao.php';

if($_POST && isset($_POST['titulo'])){
    $titulo = $_POST['titulo'];
    $cidade = $_POST['cidade'] ?? '';
    $quantidade_placas = $_POST['quantidade_placas'] ?? null;
    $placa_id = $_POST['placa_id'] ?? null;
    $inversor_id = $_POST['inversor_id'] ?? null;
    $economia = $_POST['economia'] ?? null;
    $conclusao = $_POST['conclusao'] ?? null;
    $tipo = $_POST['tipo'] ?? '';
    $caracteristica = $_POST['caracteristica'] ?? '';
    $imagem_nome = '';
    
    $erro = '';
    $sucesso = false;
    
    // Processar upload da imagem
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        // Verificar tamanho do arquivo (máximo 10MB - atualizado)
        if($_FILES['imagem']['size'] > 10 * 1024 * 1024){
            $erro = 'A+imagem+deve+ter+no+máximo+10MB';
        } else {
            $upload_dir = '../uploads/projetos/';
            if(!is_dir($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }
            
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagem_nome = uniqid() . '.' . $extensao;
            $imagem_path = $upload_dir . $imagem_nome;
            
            if(!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_path)){
                $erro = 'Erro+ao+fazer+upload+da+imagem';
            }
        }
    } elseif(isset($_FILES['imagem']) && $_FILES['imagem']['error'] != 4) { // error 4 = nenhum arquivo
        $erro = 'Erro+no+upload+da+imagem:+código+' . $_FILES['imagem']['error'];
    }
    
    // Só insere no banco se não houve erro com a imagem
    if(empty($erro)){
        $sql = "INSERT INTO projeto (
            titulo, cidade, quantidade_placas, placa_id, inversor_id, 
            economia, conclusao, tipo, caracteristica, imagem, data_criacao
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        if($stmt){
            $stmt->bind_param(
                "ssiisdssss", 
                $titulo, 
                $cidade, 
                $quantidade_placas, 
                $placa_id, 
                $inversor_id, 
                $economia, 
                $conclusao, 
                $tipo, 
                $caracteristica, 
                $imagem_nome
            );
            
            if($stmt->execute()){
                $sucesso = true;
            } else{
                $erro = 'Erro+ao+salvar+projeto:+' . urlencode($conn->error);
            }
            $stmt->close();
        } else {
            $erro = 'Erro+ao+preparar+query:+' . urlencode($conn->error);
        }
    }
    
    // Redirecionar com parâmetros para exibir mensagens bonitas
    if($sucesso){
        header('Location: novo_projeto.php?sucesso=1');
    } else {
        header('Location: novo_projeto.php?erro=' . $erro);
    }
    exit;
} else {
    // Se não veio por POST, redireciona para o formulário
    header('Location: novo_projeto.php');
    exit;
}
?>
