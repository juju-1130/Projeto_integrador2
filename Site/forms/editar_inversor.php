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

if($_POST && isset($_POST['nome']) && isset($_POST['marca']) && isset($_POST['potencia']) && isset($_POST['valor'])){
    $nome = $_POST['nome'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $potencia = $_POST['potencia'];
    $eficiencia = $_POST['eficiencia'];
    $fase = $_POST['fase'];
    $entradas = $_POST['entradas'];
    $mppt = $_POST['mppt'];
    $overload = $_POST['overload'];
    $valor = $_POST['valor'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    
    $sql = "UPDATE Inversor SET 
                nome_inversor = ?, 
                marca_inversor = ?, 
                tipo_inversor = ?, 
                potencia_inversor = ?, 
                eficiencia = ?, 
                fase = ?, 
                entradas = ?, 
                mppt = ?, 
                overload = ?, 
                valor_inversor = ?,
                ativo = ?
            WHERE inversor_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("sssddsiiidii", 
            $nome,          // s
            $marca,         // s
            $tipo,          // s
            $potencia,      // d
            $eficiencia,    // d
            $fase,          // s
            $entradas,      // i
            $mppt,          // i
            $overload,      // i
            $valor,         // d
            $ativo,         // i
            $inversor_id    // i
        );
        
        if($stmt->execute()){
            header("Location: form_inversor.php");
            exit();
        } else{
            echo "<div class='alert alert-danger'>Erro ao atualizar inversor: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Erro na preparação da query: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Inversor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
      <h5 class="m-0">Editar Inversor</h5>
      <a href="form_inversor.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="">
        <div class="row mb-3">
          <div class="col">
              <label class="form-label">Nome</label>
              <input type="text" class="form-control" name="nome" value="<?php echo htmlspecialchars($inversor['nome_inversor']); ?>" required>
          </div>
          <div class="col">
            <label for="marca" class="form-label">Marca</label>
            <select name="marca" class="form-control" required>
                  <option value="Chint" <?php echo ($inversor['marca_inversor'] == 'Chint') ? 'selected' : ''; ?>>CHINT</option>
                  <option value="Growatt" <?php echo ($inversor['marca_inversor'] == 'Growatt') ? 'selected' : ''; ?>>GROWATT</option>
                  <option value="Solis" <?php echo ($inversor['marca_inversor'] == 'Solis') ? 'selected' : ''; ?>>SOLIS</option>
                  <option value="SAJ" <?php echo ($inversor['marca_inversor'] == 'SAJ') ? 'selected' : ''; ?>>SAJ</option>
            </select>
          </div>
          <div class="col">
            <label for="potencia" class="form-label">Potência(kW)</label>
            <input type="text" class="form-control" id="potencia" name="potencia" value="<?php echo htmlspecialchars($inversor['potencia_inversor']); ?>" required>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Tipo</label>
                <input type="text" class="form-control" name="tipo" value="<?php echo htmlspecialchars($inversor['tipo_inversor']); ?>" required>
            </div>
            <div class="col">
                <label class="form-label">Eficiência (%)</label>
                <input type="number" step="0.01" class="form-control" name="eficiencia" value="<?php echo htmlspecialchars($inversor['eficiencia']); ?>" required>
            </div>
            <div class="col">
                <label class="form-label">Fase</label>
                <select name="fase" class="form-control" required>
                    <option value="Monofasico" <?php echo ($inversor['fase'] == 'Monofasico') ? 'selected' : ''; ?>>Monofásico</option>
                    <option value="Bifasico" <?php echo ($inversor['fase'] == 'Bifasico') ? 'selected' : ''; ?>>Bifásico</option>
                    <option value="Trifasico" <?php echo ($inversor['fase'] == 'Trifasico') ? 'selected' : ''; ?>>Trifásico</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label">Entradas</label>
                <input type="number" class="form-control" name="entradas" value="<?php echo htmlspecialchars($inversor['entradas']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">MPPT</label>
                <input type="number" class="form-control" name="mppt" value="<?php echo htmlspecialchars($inversor['mppt']); ?>" required>
            </div>
            <div class="col">
                <label class="form-label">Overload</label>
                <input type="number" class="form-control" name="overload" value="<?php echo htmlspecialchars($inversor['overload']); ?>" required>
            </div>
            <div class="col">
                <label for="valor" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="<?php echo number_format($inversor['valor_inversor'], 2, '.', ''); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1" <?php echo $inversor['ativo'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="ativo">
                        Inversor Ativo (disponível para orçamentos)
                    </label>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="form_inversor.php" class="btn btn-secondary me-md-2">Cancelar</a>
          <button type="submit" class="btn btn-primary">Atualizar Inversor</button>
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