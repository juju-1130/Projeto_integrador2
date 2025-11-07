<?php
require '../../conexao.php';

if($_POST && isset($_POST['nome_vendedor'])){
    $nome_vendedor = $_POST['nome_vendedor'];
    $cargo = $_POST['cargo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $telefone_vendedor = $_POST['telefone_vendedor'] ?? '';
    $link_vendedor = $_POST['link_vendedor'] ?? '';
    $foto_vendedor = '';
    
    if(isset($_FILES['foto_vendedor']) && $_FILES['foto_vendedor']['error'] == 0){
        if($_FILES['foto_vendedor']['size'] > 5 * 1024 * 1024){
            header('Location: novo_vendedor.php?erro=Imagem muito grande (máximo 5MB)');
            exit;
        } else {
            $upload_dir = '../uploads/vendedores/';
            if(!is_dir($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }
            
            $extensao = pathinfo($_FILES['foto_vendedor']['name'], PATHINFO_EXTENSION);
            $foto_vendedor = uniqid() . '.' . $extensao;
            $imagem_path = $upload_dir . $foto_vendedor;
            
            if(!move_uploaded_file($_FILES['foto_vendedor']['tmp_name'], $imagem_path)){
                header('Location: novo_vendedor.php?erro=Erro ao fazer upload da imagem');
                exit;
            }
        }
    } elseif(isset($_FILES['foto_vendedor']) && $_FILES['foto_vendedor']['error'] != 4) {
        header('Location: novo_vendedor.php?erro=Erro no upload da imagem');
        exit;
    }
    
    // Inserir no banco
    $sql = "INSERT INTO Vendedor (
        nome_vendedor, cargo, descricao, telefone_vendedor, link_vendedor, foto_vendedor
    ) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nome_vendedor, $cargo, $descricao, $telefone_vendedor, $link_vendedor, $foto_vendedor);
    
    if($stmt->execute()){
        header('Location: novo_vendedor.php?sucesso=1');
        exit;
    } else{
        header('Location: novo_vendedor.php?erro=' . urlencode($conn->error));
        exit;
    }
    $stmt->close();
}

header('Location: novo_vendedor.php');
exit;
?>