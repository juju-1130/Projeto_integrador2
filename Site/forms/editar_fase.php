<?php
include_once '../conexao.php';

$fase_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$fase = null;
if($fase_id > 0){
    $sql = "SELECT * FROM Fase WHERE fase_id = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("i", $fase_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $fase = $result->fetch_assoc();
        $stmt->close();
    } else {
        die("Erro na consulta: " . $conn->error);
    }
}

if(!$fase){
    die("Fase não encontrada.");
}

if($_POST && isset($_POST['tipoFase'])){
    $tipoFase = $_POST['tipoFase'];
    
    $sql = "UPDATE Fase SET tipo_fase = ? WHERE fase_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("si", $tipoFase, $fase_id);
        
        if($stmt->execute()){
            header("Location: form_fase.php");
            exit();
        } else{
            echo "<div class='alert alert-danger'>Erro ao atualizar fase: " . $conn->error . "</div>";
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
      <h5 class="m-0">Editar Fase</h5>
      <a href="form_fase.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="">
        <div class="mb-3">
          <label for="tipoFase" class="form-label">Tipo de Fase</label>
          <input type="text" class="form-control" id="tipoFase" name="tipoFase" value="<?php echo htmlspecialchars($fase['tipo_fase']); ?>" required>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="form_fase.php" class="btn btn-secondary me-md-2">Cancelar</a>
          <button type="submit" class="btn btn-primary">Atualizar Fase</button>
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