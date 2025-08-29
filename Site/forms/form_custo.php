<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Custo</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <?php
        $tipos = array(
            'mao_obra' => 'Mão de obra',
            'cabos' => 'Cabos',
            'trilho' => 'Trilho',
            'conectores' => 'Conectores',
            'custos_fixos' => 'Custos fixos',
            'custos_extras' => 'Custos extras'
        );
        
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
        
        if (!array_key_exists($tipo, $tipos)) {
            echo "<div class='alert alert-danger'>Item não especificado ou inválido.</div>";
            exit;
        }
        
        $nomeItem = $tipos[$tipo];
        
        $valorAtual = 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $valor = $_POST['valor'];
            
            header("Location: ../admin/kit_solar.php?success=1");
            exit;
        }
        ?>
                
        <form method="post" action="" id="formCusto">
            <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
            
            <div class="mb-3">
                <label for="custo" class="form-label">Item</label>
                <input type="text" name="custo" id="custo" class="form-control" value="<?php echo htmlspecialchars($nomeItem); ?>" readonly>
            </div>
            
            <div class="mb-4">
                <label for="valor" class="form-label">Valor (R$):</label>
                <input type="number" name="valor" id="valor" class="form-control" step="0.01" value="<?php echo $valorAtual; ?>" required>
            </div>
            
            <div class="form-divider"></div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-secondary me-md-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>