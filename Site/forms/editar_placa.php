<?php
include_once '../conexao.php';

$placa_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$placa = null;
if($placa_id > 0){
    $sql = "SELECT * FROM Placa WHERE placa_id = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("i", $placa_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $placa = $result->fetch_assoc();
        $stmt->close();
    } else {
        die("Erro na consulta: " . $conn->error);
    }
}

if(!$placa){
    die("Placa não encontrada.");
}

if($_POST && isset($_POST['marca']) && isset($_POST['potencia']) && isset($_POST['valor'])){
    $marca = $_POST['marca'];
    $potencia = $_POST['potencia'];
    $valor = $_POST['valor'];
    
    $sql = "UPDATE Placa SET marca_placa = ?, potencia_placa = ?, valor_placa = ? WHERE placa_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("ssdi", $marca, $potencia, $valor, $placa_id);
        
        if($stmt->execute()){
            header("Location: form_placa.php");
            exit();
        } else{
            echo "<div class='alert alert-danger'>Erro ao atualizar placa: " . $conn->error . "</div>";
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
            <h5 class="m-0">Editar Placa</h5>
            <a href="form_placa.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
            </div>

            <div class="p-3">
            <form method="POST" action="">
                <div class="row mb-3">
                <div class="col">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" value="<?php echo htmlspecialchars($placa['marca_placa']); ?>" required>
                </div>
                <div class="col">
                    <label for="potencia" class="form-label">Potência (W)</label>
                    <input type="text" class="form-control" id="potencia" name="potencia" value="<?php echo htmlspecialchars($placa['potencia_placa']); ?>" required>
                </div>
                </div>
                <div class="mb-3">
                <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="<?php echo number_format($placa['valor_placa'], 2, '.', ''); ?>" required>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="form_placa.php" class="btn btn-secondary me-md-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Atualizar Placa</button>
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