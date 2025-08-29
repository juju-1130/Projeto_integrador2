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
            <label for="marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
          </div>
          <div class="col">
            <label for="potencia" class="form-label">Potência</label>
            <input type="text" class="form-control" id="potencia" name="potencia" required>
          </div>
        </div>
        <div class="mb-3">
          <label for="valor" class="form-label">Valor</label>
          <input type="text" class="form-control" id="valor" name="valor" required>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="../admin_php/editar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Adicionar Inversor</button>
        </div>
      </form>

      <hr>

      <h5 class="mt-3">Inversores Cadastrados</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Marca</th>
            <th>Potência</th>
            <th>Valor</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Chint</td>
            <td>5kW</td>
            <td>R$ 1100,00</td>
            <td>
              <a href="editar_item.php?tipo=inversor&id=1" class="btn btn-warning btn-sm">Editar</a>
              <a href="excluir_item.php?tipo=inversor&id=1" class="btn btn-danger btn-sm">Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Growatt</td>
            <td>3kW</td>
            <td>R$ 900,00</td>
            <td>
              <a href="editar_item.php?tipo=inversor&id=2" class="btn btn-warning btn-sm">Editar</a>
              <a href="excluir_item.php?tipo=inversor&id=2" class="btn btn-danger btn-sm">Excluir</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>