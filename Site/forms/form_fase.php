<?php
include_once '../conexao.php';

if($_POST && isset($_POST['tipoFase'])){
    $tipoFase = $_POST['tipoFase'];
    
    $sql = "INSERT INTO Fase (tipo_fase) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tipoFase);
    
    if($stmt->execute()){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Fase adicionada com sucesso!
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else{
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Erro ao adicionar fase: " . $conn->error . "
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
    $stmt->close();
}

$sql = "SELECT * FROM Fase ORDER BY fase_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <?php include __DIR__ . '/../head.php'; ?>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
      <h5 class="m-0">Tipos de Fase</h5>
      <a href="../admin_php/editar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="">
        <div class="mb-3">
          <label for="tipoFase" class="form-label">Tipo de Fase</label>
          <input type="text" class="form-control" id="tipoFase" name="tipoFase" required>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="../admin_php/editar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
          <button type="submit" class="btn btn-primary">Adicionar Fase</button>
        </div>
      </form>

      <hr>

      <h5 class="mt-3">Fases Cadastradas</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if($result && $result->num_rows > 0){
              while ($row = $result->fetch_assoc()){
                  echo "<tr>";
                  echo "<td>{$row['tipo_fase']}</td>";
                  echo "<td>";
                  echo "<a href='../forms/editar_fase.php?id={$row['fase_id']}' class='btn btn-warning btn-sm'>Editar</a> ";
                  echo "<a href='../forms/excluir_fase.php?id={$row['fase_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>";
                  echo "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='2' class='text-center'>Nenhuma fase cadastrada.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>