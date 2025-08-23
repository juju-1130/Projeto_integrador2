<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custo Kit Solar</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container p-0">
        <div class="p-4">
            <form method="post" action="salvar.php" class="mb-4" id="formCusto">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="custo" class="form-label">Item</label>
                        <input type="text" name="custo" id="custo" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="valor" class="form-label">Valor (R$):</label>
                        <input type="number" name="valor" id="valor" class="form-control" required>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Atualizar Valor</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>