<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telhado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
      <h5 class="m-0">Tipos de Telhado</h5>
      <a href="../admin_php/editar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="row mb-3">
          <div class="col">
            <label for="tipo" class="form-label">Tipo do Telhado</label>
            <input type="text" class="form-control" id="tipo" name="tipo" required>
          </div>
          <div class="col">
            <label for="imagem" class="form-label">Imagem do Telhado</label>
            <input type="file" class="form-control" id="imagem" name="imagem">
          </div>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="../admin_php/editar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
          <button type="submit" class="btn btn-primary">Adicionar Telhado</button>
        </div>
      </form>

      <hr>

      <h5 class="mt-3">Telhados Cadastrados</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Imagem</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Telhado Cerâmico</td>
            <td><img src="../uploads/telhados/ceramico.jpg" width="50" alt="Telhado Cerâmico"></td>
            <td>
              <a href="editar_item.php?tipo=telhado&id=1" class="btn btn-warning btn-sm">Editar</a>
              <a href="excluir_item.php?tipo=telhado&id=1" class="btn btn-danger btn-sm">Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Telhado Metálico</td>
            <td><img src="../uploads/telhados/metalico.jpg" width="50" alt="Telhado Metálico"></td>
            <td>
              <a href="editar_item.php?tipo=telhado&id=2" class="btn btn-warning btn-sm">Editar</a>
              <a href="excluir_item.php?tipo=telhado&id=2" class="btn btn-danger btn-sm">Excluir</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>