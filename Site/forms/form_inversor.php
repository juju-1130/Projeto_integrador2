<?php
include_once '../conexao.php';

// CREATE - Adicionar novo inversor
if($_POST && isset($_POST['marca']) && isset($_POST['potencia']) && isset($_POST['valor'])){
    $marca = $_POST['marca'];
    $potencia = $_POST['potencia'];
    $valor = $_POST['valor'];
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $eficiencia = $_POST['eficiencia'];
    $fase = $_POST['fase'];
    $entradas = $_POST['entradas'];
    $mppt = $_POST['mppt'];
    $overload = $_POST['overload'];
    
    $sql = "INSERT INTO Inversor 
        (nome_inversor, marca_inversor, tipo_inversor, potencia_inversor, eficiencia, fase, entradas, mppt, overload, valor_inversor)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssddsiiid",
        $nome,          // s
        $marca,         // s
        $tipo,          // s
        $potencia,      // d
        $eficiencia,    // d
        $fase,          // s
        $entradas,      // i
        $mppt,          // i
        $overload,      // i
        $valor          // d
    );

    
    if($stmt->execute()){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Inversor adicionado com sucesso!
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else{
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Erro ao adicionar inversor: " . $conn->error . "
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
    $stmt->close();
}

$sql = "SELECT * FROM Inversor ORDER BY inversor_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inversores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Inversores</h5>
        <a href="../admin_php/editar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="">
        <div class="row mb-3">
          <div class="col">
              <label class="form-label">Nome</label>
              <input type="text" class="form-control" name="nome" required>
          </div>
          <div class="col">
            <label for="marca" class="form-label">Marca</label>
            <select name="marca" class="form-control" required>
                  <option value="Chint">CHINT</option>
                  <option value="Growatt">GROWATT</option>
                  <option value="Solis">SOLIS</option>
                  <option value="SAJ">SAJ</option>
            </select>
          </div>
          <div class="col">
            <label for="potencia" class="form-label">Potência(kW)</label>
            <input type="text" class="form-control" id="potencia" name="potencia" required>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Tipo</label>
                <input type="text" class="form-control" name="tipo" required>
            </div>
            <div class="col">
                <label class="form-label">Eficiência (%)</label>
                <input type="number" step="0.01" class="form-control" name="eficiencia" required>
            </div>
            <div class="col">
                <label class="form-label">Fase</label>
                <select name="fase" class="form-control" required>
                    <option value="Monofasico">Monofásico</option>
                    <option value="Bifasico">Bifásico</option>
                    <option value="Trifasico">Trifásico</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label">Entradas</label>
                <input type="number" class="form-control" name="entradas" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">MPPT</label>
                <input type="number" class="form-control" name="mppt" required>
            </div>
            <div class="col">
                <label class="form-label">Overload</label>
                <input type="number" class="form-control" name="overload" required>
            </div>
            <div class="col">
                <label for="valor" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" class="form-control" id="valor" name="valor" placeholder="Ex: 1100.00" required>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="../admin_php/editar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Adicionar Inversor</button>
        </div>
      </form>

      <hr>

      <h5 class="mt-3">Inversores Cadastrados</h5>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Marca</th>
              <th>Potência</th>
              <th>Valor</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $valor_formatado = "R$ " . number_format($row['valor_inversor'] ?? 0, 2, ',', '.');
                    echo "<tr>";
                    echo "<td>{$row['nome_inversor']}</td>";
                    echo "<td>{$row['marca_inversor']}</td>";
                    echo "<td>{$row['potencia_inversor']}kW</td>";
                    echo "<td>{$valor_formatado}</td>";
                    echo "<td>";
                    echo "<a href='../forms/mostrar_inversor.php?id={$row['inversor_id']}' class='btn btn-info btn-sm'>Visualizar</a> ";
                    echo "<a href='../forms/editar_inversor.php?id={$row['inversor_id']}' class='btn btn-warning btn-sm'>Editar</a> ";
                    echo "<a href='../forms/excluir_inversor.php?id={$row['inversor_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Nenhum inversor cadastrado.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>