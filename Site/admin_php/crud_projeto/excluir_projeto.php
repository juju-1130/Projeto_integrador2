<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Excluir Projeto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php
$projetos = [
    1 => ['titulo' => 'Sistema solar de 6,27Kwp'],
    2 => ['titulo' => 'Sistema solar de 5,49Kwp'],
    3 => ['titulo' => 'Sistema solar de 5,13Kwp']
];

$id = $_GET['id'] ?? '';
$projeto = $projetos[$id] ?? null;

if ($projeto): 
?>
<div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Excluir Projeto</h5>
        <a href="cadastrar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <div class="alert alert-warning">
        <h5>Tem certeza que deseja excluir este projeto?</h5>
        <p class="mb-0">Esta ação não pode be desfeita.</p>
      </div>
      
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title"><?php echo $projeto['titulo']; ?></h5>
          <p class="card-text">ID: <?php echo $id; ?></p>
        </div>
      </div>
      
      <form method="POST" action="excluir_projeto.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="cadastrar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-danger">Excluir Projeto</button>
        </div>
      </form>
    </div>
</div>
<?php else: ?>
<div class="container p-0">
    <div class="alert alert-danger">Projeto não encontrado.</div>
</div>
<?php endif; ?>
</body>
</html>