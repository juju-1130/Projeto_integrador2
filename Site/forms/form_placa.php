<?php
include_once '../conexao.php';

if($_POST && isset($_POST['marca']) && isset($_POST['potencia']) && isset($_POST['valor'])){
    $marca = $_POST['marca'];
    $potencia = $_POST['potencia'];
    $valor = $_POST['valor'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    
    $sql = "INSERT INTO Placa (marca_placa, potencia_placa, valor_placa, ativo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $marca, $potencia, $valor, $ativo);
    
    if($stmt->execute()){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Placa adicionada com sucesso!
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else{
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Erro ao adicionar placa: " . $conn->error . "
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
    $stmt->close();
}

$sql = "SELECT * FROM Placa ORDER BY placa_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <?php include __DIR__ . '/../head.php'; ?>

    <body>
        <div class="container p-0">
            <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
                <h5 class="m-0">Modelos de Placas</h5>
                <a href="../admin_php/editar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
            </div>

            <div class="p-3">
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" required>
                    </div>
                    <div class="col">
                        <label for="potencia" class="form-label">Potência (W)</label>
                        <input type="text" class="form-control" id="potencia" name="potencia" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="valor" class="form-label">Valor (R$)</label>
                        <input type="number" step="0.01" class="form-control" id="valor" name="valor" placeholder="Ex: 700.00" required>
                    </div>
                    <div class="col">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1" checked>
                            <label class="form-check-label" for="ativo">
                                Placa Ativa (disponível para orçamentos)
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="../admin_php/editar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Adicionar Placa</button>
                </div>
            </form>

            <hr>

            <h5 class="mt-3">Placas Cadastradas</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Potência (W)</th>
                        <th>Valor (R$)</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($result && $result->num_rows > 0){
                        while ($row = $result->fetch_assoc()){
                            $valor_formatado = "R$ " . number_format($row['valor_placa'], 2, ',', '.');
                            $status = $row['ativo'] ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-secondary">Inativo</span>';
                            echo "<tr>";
                            echo "<td>{$row['marca_placa']}</td>";
                            echo "<td>{$row['potencia_placa']}W</td>";
                            echo "<td>{$valor_formatado}</td>";
                            echo "<td>{$status}</td>";
                            echo "<td>";
                            echo "<a href='../forms/editar_placa.php?id={$row['placa_id']}' class='btn btn-warning btn-sm'>Editar</a> ";
                            echo "<a href='excluir_placa.php?id={$row['placa_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Nenhuma placa cadastrada.</td></tr>";
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