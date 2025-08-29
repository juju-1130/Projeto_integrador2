<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Excluir Vendedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Excluir Vendedor</h5>
        <a href="../editar_vendedor.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <?php
      $vendedores = [
        1 => ['nome' => 'Jonathan Kirsch'],
        2 => ['nome' => 'Dhonavan Dias'],
        3 => ['nome' => 'MK Energia Solar']
      ];
      
      $id = $_GET['id'] ?? '';
      $vendedor = $vendedores[$id] ?? null;
      
      if ($vendedor): 
      ?>
      
      <div class="alert alert-warning">
        <h5>Tem certeza que deseja excluir este vendedor?</h5>
        <p class="mb-0">Esta ação não pode ser desfeita.</p>
      </div>
      
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title"><?php echo $vendedor['nome']; ?></h5>
          <p class="card-text">ID: <?php echo $id; ?></p>
        </div>
      </div>
      
      <form method="POST" action="excluir_vendedor.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="../editar_vendedor.php" class="btn btn-secondary me-md-2">Cancelar</a>
          <button type="submit" class="btn btn-danger">Excluir Vendedor</button>
        </div>
      </form>
      
      <?php else: ?>
      <div class="alert alert-danger">Vendedor não encontrado.</div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>