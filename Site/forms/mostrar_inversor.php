<?php
include_once '../conexao.php';

$inversor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$inversor = null;
if($inversor_id > 0){
    $sql = "SELECT * FROM Inversor WHERE inversor_id = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("i", $inversor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $inversor = $result->fetch_assoc();
        $stmt->close();
    } else {
        die("Erro na consulta: " . $conn->error);
    }
}

if(!$inversor){
    die("Inversor não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <?php include __DIR__ . '/../head.php'; ?>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
      <h5 class="m-0">Detalhes do Inversor</h5>
      <a href="form_inversor.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <div class="card">
        <div class="card-header bg-light">
          <h6 class="mb-0">Informações do Inversor</h6>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <strong>Nome:</strong> <?php echo htmlspecialchars($inversor['nome_inversor']); ?>
            </div>
            <div class="col-md-6">
              <strong>Marca:</strong> <?php echo htmlspecialchars($inversor['marca_inversor']); ?>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <strong>Tipo:</strong> <?php echo htmlspecialchars($inversor['tipo_inversor']); ?>
            </div>
            <div class="col-md-6">
              <strong>Potência:</strong> <?php echo htmlspecialchars($inversor['potencia_inversor']); ?>kW
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <strong>Eficiência:</strong> <?php echo number_format($inversor['eficiencia'], 1, ',', ''); ?>%
            </div>
            <div class="col-md-6">
              <strong>Fase:</strong> <?php echo htmlspecialchars($inversor['fase']); ?>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <strong>Entradas:</strong> <?php echo htmlspecialchars($inversor['entradas']); ?>
            </div>
            <div class="col-md-6">
              <strong>MPPT:</strong> <?php echo htmlspecialchars($inversor['mppt']); ?>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <strong>Overload:</strong> <?php echo htmlspecialchars($inversor['overload']); ?>%
            </div>
            <div class="col-md-6">
              <strong>Valor:</strong> R$ <?php echo number_format($inversor['valor_inversor'], 2, ',', '.'); ?>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <strong>Status:</strong> 
              <?php 
              if($inversor['ativo']) {
                  echo '<span class="badge bg-success">Ativo</span> (disponível para orçamentos)';
              } else {
                  echo '<span class="badge bg-secondary">Inativo</span> (não disponível para novos orçamentos)';
              }
              ?>
            </div>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
        <a href="form_inversor.php" class="btn btn-secondary me-md-2">Voltar</a>
        <a href="editar_inversor.php?id=<?php echo $inversor_id; ?>" class="btn btn-warning me-md-2">Editar</a>
        <a href="excluir_inversor.php?id=<?php echo $inversor_id; ?>" class="btn btn-danger" onclick='return confirm("Tem certeza que deseja excluir?")'>Excluir</a>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>