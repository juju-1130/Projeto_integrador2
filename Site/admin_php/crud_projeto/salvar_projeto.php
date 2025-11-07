<?php
// salvar_projeto.php
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
    
    // Processar upload da imagem
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        // Verificar tamanho do arquivo (máximo 5MB)
        if($_FILES['imagem']['size'] > 5 * 1024 * 1024){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    A imagem deve ter no máximo 5MB.
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
        } else {
            $upload_dir = '../uploads/projetos/';
            if(!is_dir($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }
            
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagem_nome = uniqid() . '.' . $extensao;
            $imagem_path = $upload_dir . $imagem_nome;
            
            if(!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_path)){
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Erro ao fazer upload da imagem.
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                      </div>";
            }
        }
    } elseif(isset($_FILES['imagem']) && $_FILES['imagem']['error'] != 4) { // error 4 = nenhum arquivo
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Erro no upload da imagem: código " . $_FILES['imagem']['error'] . "
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
    
    // Só insere no banco se não houve erro com a imagem
    if(empty($imagem_nome) || (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0 && !empty($imagem_nome))){
        $sql = "INSERT INTO projeto (
            titulo, cidade, quantidade_placas, placa_id, inversor_id, 
            economia, conclusao, tipo, caracteristica, imagem, data_criacao
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
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
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Projeto salvo com sucesso!
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
        } else{
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Erro ao salvar projeto: " . $conn->error . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
        }
        $stmt->close();
    }
}

// Redirecionar de volta para a página de projetos após 3 segundos
echo "<script>
    setTimeout(function() {
        window.location.href = 'novo_projeto.php';
    }, 3000);
</script>";
?>