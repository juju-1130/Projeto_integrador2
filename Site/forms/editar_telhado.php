<?php
include_once '../conexao.php';

$telhado_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$telhado = null;
if($telhado_id > 0){
    $sql = "SELECT * FROM Telhado WHERE telhado_id = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("i", $telhado_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $telhado = $result->fetch_assoc();
        $stmt->close();
    } else {
        die("Erro na consulta: " . $conn->error);
    }
}

if(!$telhado){
    die("Telhado não encontrado.");
}

if($_POST && isset($_POST['tipo'])){
    $tipo = $_POST['tipo'];
    $imagem_nome = $telhado['foto_telhado']; 
    
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        $upload_dir = '../uploads/telhados/';
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }
        
        if($telhado['foto_telhado'] && file_exists($upload_dir . $telhado['foto_telhado'])){
            unlink($upload_dir . $telhado['foto_telhado']);
        }
        
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . '.' . $extensao;
        $imagem_path = $upload_dir . $imagem_nome;
        
        if(!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_path)){
            echo "<div class='alert alert-danger'>Erro ao fazer upload da imagem.</div>";
            $imagem_nome = $telhado['foto_telhado']; 
        }
    }
    
    $valor = $_POST['valor'];
    $sql = "UPDATE Telhado SET tipo_telhado = ?, foto_telhado = ?, valor = ? WHERE telhado_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("ssdi", $tipo, $imagem_nome, $valor, $telhado_id);
        
        if($stmt->execute()){
            header("Location: form_telhado.php");
            exit();
        } else{
            echo "<div class='alert alert-danger'>Erro ao atualizar telhado: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Erro na preparação da query: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <?php include __DIR__ . '/../head.php'; ?>
    <body>
    <div class="container p-0">
        <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Editar Telhado/EStrutura</h5>
        <a href="form_telhado.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
        </div>

        <div class="p-3">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row mb-3">
            <div class="col">
                <label for="tipo" class="form-label">Tipo do Telhado/Estrutura</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo htmlspecialchars($telhado['tipo_telhado']); ?>" required>
            </div>
            <div class="col">
                <label for="valor" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" class="form-control" id="valor" name="valor" 
                    value="<?php echo htmlspecialchars($telhado['valor']); ?>" required>
            </div>
            <div class="col">
                <label for="imagem" class="form-label">Imagem do Telhado</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                <?php if($telhado['foto_telhado']): ?>
                <div class="mt-2">
                    <small>Imagem atual:</small><br>
                    <img src="../uploads/telhados/<?php echo $telhado['foto_telhado']; ?>" width="100" alt="Imagem atual">
                </div>
                <?php endif; ?>
            </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="form_telhado.php" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Atualizar Telhado</button>
            </div>
        </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

<?php
$conn->close();
?>