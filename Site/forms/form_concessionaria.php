<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Concessionária</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
      <h5 class="m-0">Concessionárias</h5>
      <a href="../admin/editar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <?php
      // Processar o formulário se foi enviado
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $nomeConcessionaria = $_POST['nomeConcessionaria'];
          
          // Aqui você salva no banco de dados
          // ...
          
          // Redireciona de volta para a página principal
          echo '<script>window.parent.location.href = "../admin/editar.php?success=1";</script>';
          exit;
      }
      ?>
      
      <form method="POST" action="">
        <div class="mb-3">
          <label for="nomeConcessionaria" class="form-label">Nome da Concessionária</label>
          <input type="text" class="form-control" id="nomeConcessionaria" name="nomeConcessionaria" required>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="../admin/editar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
          <button type="submit" class="btn btn-primary">Adicionar Concessionária</button>
        </div>
      </form>

      <hr>

      <h5 class="mt-3">Concessionárias Cadastradas</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>CEE</td>
            <td>
              <a href="editar_item.php?tipo=concessionaria&id=1" class="btn btn-warning btn-sm">Editar</a>
              <a href="excluir_item.php?tipo=concessionaria&id=1" class="btn btn-danger btn-sm">Excluir</a>
            </td>
          </tr>
          <tr>
            <td>RGE</td>
            <td>
              <a href="editar_item.php?tipo=concessionaria&id=2" class="btn btn-warning btn-sm">Editar</a>
              <a href="excluir_item.php?tipo=concessionaria&id=2" class="btn btn-danger btn-sm">Excluir</a>
            </td>
          </tr>
        </tbody>