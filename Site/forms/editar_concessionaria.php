<?php
include_once '../conexao.php';

$concessionaria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$concessionaria = null;
if($concessionaria_id > 0){
    $sql = "SELECT * FROM Concessionaria WHERE concessionaria_id = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("i", $concessionaria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $concessionaria = $result->fetch_assoc();
        $stmt->close();
    } else {
        die("Erro na consulta: " . $conn->error);
    }
}

if(!$concessionaria){
    die("Concessionária não encontrada.");
}

if($_POST && isset($_POST['nomeConcessionaria'])){
    $nomeConcessionaria = $_POST['nomeConcessionaria'];
    
    $sql = "UPDATE Concessionaria SET nome_concessionaria = ? WHERE concessionaria_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("si", $nomeConcessionaria, $concessionaria_id);
        
        if($stmt->execute()){
            header("Location: form_concessionaria.php");
            exit();
        } else{
            echo "<div class='alert alert-danger'>Erro ao atualizar concessionária: " . $conn->error . "</div>";
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
      <h5 class="m-0">Editar Concessionária</h5>
      <a href="form_concessionaria.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="">
        <div class="mb-3">
          <label for="nomeConcessionaria" class="form-label">Nome da Concessionária</label>
          <input type="text" class="form-control" id="nomeConcessionaria" name="nomeConcessionaria" value="<?php echo htmlspecialchars($concessionaria['nome_concessionaria']); ?>" required>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="form_concessionaria.php" class="btn btn-secondary me-md-2">Cancelar</a>
          <button type="submit" class="btn btn-primary">Atualizar Concessionária</button>
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